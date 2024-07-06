<?php

declare(strict_types=1);

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Library\DTO\Reader;

use Micro\Library\DTO\Merger\MergerFactoryInterface;

/**
 * @TODO: Get XSD api version
 */
readonly class XmlReader implements ReaderInterface
{
    /**
     * @param iterable<string> $classDefinitionFilesCollection
     */
    public function __construct(
        private iterable $classDefinitionFilesCollection,
        private MergerFactoryInterface $mergerFactory
    ) {
    }

    public function read(): iterable
    {
        $classCollection = [];
        foreach ($this->classDefinitionFilesCollection as $filePath) {
            $xml = $this->createDom($filePath);

            foreach ($xml->getElementsByTagName(self::TAG_CLASS_DEFINITION) as $classDef) {
                $classCollection[] = $this->parse($classDef);
            }
        }

        return $this->mergerFactory->create($classCollection)->merge();
    }

    /**
     * @param \DOMDocument $document
     *
     * @return string[]
     */
    protected function lookupXsd(\DOMDocument $document): array
    {
        $schemaLocation = $document->getElementsByTagName('dto')[0]->getAttribute('xsi:schemaLocation');
        if (!$schemaLocation) {
            throw new \RuntimeException('XSD Scheme should be declared on <dto xsi:schemaLocation="">');
        }

        $location = explode(' ', $schemaLocation);
        if (2 !== \count($location)) {
            throw new \RuntimeException(sprintf('XSD Scheme declaration failed <dto xsi:schemaLocation="%s">', $schemaLocation));
        }

        return $location;
    }

    /**
     * @param \DOMNode $node
     *
     * @return array
     */
    protected function parse(\DOMNode $node): array
    {
        $attributes = [];

        if ($node->hasAttributes()) {
            /**
             * @var \DOMAttr $tmpAttribute
             *
             * Ignored psalm because hasAttribute() checks `attributes` on NULL
             *
             * @psalm-suppress PossiblyNullIterator
             */
            foreach ($node->attributes as $tmpAttribute) {
                $attributes[$tmpAttribute->nodeName] = $tmpAttribute->nodeValue;
            }
        }

        if ($node->hasChildNodes()) {
            /** @var \DOMNode $child */
            foreach ($node->childNodes as $child) {
                $childName = $child->nodeName;
                if ('#text' === $childName) {
                    continue;
                }

                if (!isset($attributes[$childName]) || !\is_array($attributes[$childName])) {
                    $attributes[$childName] = [];
                }

                $attributes[$childName][] = $this->parse($child);
            }
        }

        return $attributes;
    }

    protected function createDom(string $filePath): \DOMDocument
    {
        if (!file_exists($filePath)) {
            throw new \RuntimeException(sprintf('File %s is not found', $filePath));
        }

        if (!is_readable($filePath)) {
            throw new \RuntimeException(sprintf('Has no access to read the file %s', $filePath));
        }

        $xml = new \DOMDocument();
        $xml->load($filePath);

        $xsdSchemaCfg = $this->lookupXsd($xml);
        $xsdSchemaLocation = $xsdSchemaCfg[1];

        libxml_use_internal_errors(true);

        if ($xml->schemaValidate($xsdSchemaLocation)) {
            return $xml;
        }

        $errs = [];

        foreach (libxml_get_errors() as $error) {
            $errs[] = sprintf('%s in file `%s` on line %d', $error->message, $error->file, $error->line);
        }

        $errorMessage = implode("\n ", $errs);

        libxml_use_internal_errors(false);

        throw new \RuntimeException(sprintf("Schema validation exception: \r\n %s\r", $errorMessage));
    }
}

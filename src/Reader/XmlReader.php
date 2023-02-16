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
 * @TODO: Temporary solution. MVP
 * @TODO: Get XSD api version
 */
class XmlReader implements ReaderInterface
{
    /**
     * @param iterable<string> $classDefinitionFilesCollection
     */
    public function __construct(
        private readonly iterable $classDefinitionFilesCollection,
        private readonly MergerFactoryInterface $mergerFactory
    ) {
    }

    public function read(): iterable
    {
        $classCollection = [];
        foreach ($this->classDefinitionFilesCollection as $filePath) {
            $xml = $this->createDom($filePath);

            foreach ($xml->getElementsByTagName(self::TAG_CLASS_DEFINITION) as $classDef) {
                $classCollection[] = $this->parseClass($classDef);
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
     * @return array<string, mixed>
     */
    protected function parseClass(\DOMNode $classDef): array
    {
        $class = [];
        $props = [];
        if (null === $classDef->attributes) {
            return $class;
        }

        /** @var \DOMNode $attribute */
        foreach ($classDef->attributes as $attribute) {
            $class[$attribute->nodeName] = $attribute->nodeValue;
        }

        /** @var \DOMNode $node */
        foreach ($classDef->childNodes as $node) {
            if (str_starts_with($node->nodeName, '#')) {
                continue;
            }

            $propCfg = [];
            $validation = $this->parseValidation($node);
            if ($validation) {
                $propCfg['validation'] = $validation;
            }

            if (null === $node->attributes) {
                continue;
            }

            foreach ($node->attributes as $attribute) {
                $propCfg[$attribute->nodeName] = $attribute->nodeValue;
            }
            /**
             * @psalm-suppress PossiblyInvalidArgument
             * @psalm-suppress InvalidArgument
             */
            if (\array_key_exists($propCfg[self::PROP_PROP_NAME], $props)) {
                throw new \RuntimeException(sprintf('Property "%s" already defined. Location: %s" ',  $propCfg[self::PROP_PROP_NAME], $classDef->baseURI));
            }

            /** @psalm-suppress PossiblyNullArrayOffset  */
            $props[$propCfg[self::PROP_PROP_NAME]] = $propCfg;
        }

        $class[self::PATH_PROP] = $props;

        return $class;
    }

    /**
     * @param \DOMNode $attribute
     *
     * @return mixed[]
     */
    protected function parseValidation(\DOMNode $attribute): array|null
    {
        if (!$attribute->childNodes->count()) {
            return null;
        }

        $constraints = [];
        /** @var \DOMNode $validationNode */
        foreach ($attribute->childNodes as $validationNode) {
            if (!$validationNode->childNodes->count() || 'validation' !== $validationNode->nodeName) {
                continue;
            }
            $groupConstraints = [];
            /** @var \DOMNode $constraintNode */
            foreach ($validationNode->childNodes as $constraintNode) {
                if ('#text' === $constraintNode->nodeName) {
                    continue;
                }

                $constraintAttributes = [];
                /** @var \DOMAttr $constraintItemAttribute */
                if ($constraintNode->attributes) {
                    foreach ($constraintNode->attributes as $constraintItemAttribute) {
                        $constraintAttributes[$constraintItemAttribute->nodeName] = $constraintItemAttribute->nodeValue;
                    }
                }

                if (empty($constraintAttributes)) {
                    $constraintAttributes = [];
                }

                if (!\array_key_exists('groups', $constraintAttributes)) {
                    $constraintAttributes['groups'] = 'Default';
                }

                $groupConstraints[$constraintNode->nodeName] = $constraintAttributes;
            }

            $constraints[] = $groupConstraints;
        }

        return $constraints;
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

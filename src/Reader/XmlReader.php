<?php

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
    )
    {
    }

    /**
     * {@inheritDoc}
     */
    public function read(): iterable
    {
        $classCollection = [];
        foreach ($this->classDefinitionFilesCollection as $filePath) {
            $xml = $this->createDom($filePath);

            foreach ($xml->getElementsByTagName(self::TAG_CLASS_DEFINITION) as $classDef) {
                $classData = $this->parseClass($classDef);
                if(!$classData) {
                    continue;
                }

                $classCollection[] = $classData;
            }
        }

        return $this->mergerFactory->create($classCollection)->merge();
    }

    /**
     * @param \DOMDocument $document
     *
     * @return array
     */
    protected function lookupXsd(\DOMDocument $document): array
    {
        $schemaLocation = $document->getElementsByTagName('dto')[0]->getAttribute('xsi:schemaLocation');
        if(!$schemaLocation) {
            throw new \RuntimeException('XSD Scheme should be declared on <dto xsi:schemaLocation="">');
        }

        $location = explode(' ', $schemaLocation);
        if(count($location) !== 2) {
            throw new \RuntimeException(sprintf('XSD Scheme declaration failed <dto xsi:schemaLocation="%s">', $schemaLocation));
        }

        return $location;
    }

    /**
     * @param \DOMNode $classDef
     *
     * @return array
     */
    protected function parseClass(\DOMNode $classDef): array
    {
        $class = [];
        $props = [];
        /** @var \DOMNode $attribute */
        foreach ($classDef->attributes as $attribute) {
            $class[$attribute->nodeName] = $attribute->nodeValue;
        }
        /** @var \DOMNode $node */
        foreach ($classDef->childNodes as $node) {
            if(str_starts_with($node->nodeName, '#')) {
                continue;
            }

            $propCfg = [];
            foreach ($node->attributes as $attribute) {
                $propCfg[$attribute->nodeName] = $attribute->nodeValue;
            }

            if(array_key_exists($propCfg[self::PROP_PROP_NAME], $props)) {
                throw new \RuntimeException(sprintf('Property "%s" already defined. Location: %s" ',  $propCfg[self::PROP_PROP_NAME], $classDef->baseURI));
            }

            $props[$propCfg[self::PROP_PROP_NAME]] = $propCfg;
        }

        $class[self::PATH_PROP] = $props;
        // @TODO:
        $class['_api_version'] = 'micro:dto-01';

        return $class;
    }

    /**
     * @param string $filePath
     *
     * @return \DOMDocument
     */
    protected function createDom(string $filePath): \DOMDocument
    {
        if(!file_exists($filePath)) {
            throw new \RuntimeException(sprintf('File %s is not found', $filePath));
        }

        if(!is_readable($filePath)) {
            throw new \RuntimeException(sprintf('Has no access to read the file %s', $filePath));
        }

        $xml = new \DOMDocument();
        $xml->load($filePath);

        $xsdSchemaCfg = $this->lookupXsd($xml);
        $xsdSchemaLocation = $xsdSchemaCfg[1];

        libxml_use_internal_errors(true);

        if($xml->schemaValidate($xsdSchemaLocation)) {
            return $xml;
        }

        $errs = [];

        foreach (libxml_get_errors() as $error) {
            $errs[] = $error->message;
        }

        libxml_use_internal_errors(false);

        throw new \RuntimeException(sprintf("Schema validation exception: \r\n %s\r", implode("\r ", $errs)));
    }
}
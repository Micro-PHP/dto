<?php

namespace Micro\Library\DTO\Reader;

use Micro\Library\DTO\Merger\MergerFactoryInterface;

/**
 * @TODO: Temporary solution. MVP
 * @TODO: Get XSD api version
 */
readonly class XmlReader implements ReaderInterface
{
    /**
     * @param iterable<string> $classDefinitionFilesCollection
     */
    public function __construct(
        private  iterable $classDefinitionFilesCollection,
        private MergerFactoryInterface $mergerFactory
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
            //$propCfg[$attribute->nodeName] = [];
            $validation = $this->parseValidation($node);
            if($validation) {
                $propCfg['validation'] = $validation;
            }

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

    protected function parseValidation(\DOMNode $attribute): array|null
    {
        if(!$attribute->childNodes->count()) {
            return null;
        }

        $constraints = [];
        /** @var \DOMNode $validationNode */
        foreach ($attribute->childNodes as $validationNode) {
            if(!$validationNode->childNodes->count() || $validationNode->nodeName !== 'validation') {
                continue;
            }

            /** @var \DOMNode $group */
            foreach ($validationNode->childNodes as $constraintsNodes) {
                if(!$constraintsNodes->childNodes->count() || $constraintsNodes->nodeName !== 'constraint') {
                    continue;
                }

                /** @var \DOMAttr $groupAttr */
                $groupAttr = $constraintsNodes->attributes->getNamedItem('group');
                $groupName = $groupAttr?->value ?: 'Default';
                $groupConstraints = [];
                /** @var  $constraintsColl */

                /** @var \DOMNode $constraint */
                foreach ($constraintsNodes->childNodes as $constraintNode) {
                    if($constraintNode->nodeName === '#text') {
                        continue;
                    }

                    $constraintAttributes = [];
                    /** @var \DOMAttr $constraintItemAttribute */
                    foreach ($constraintNode->attributes as $constraintItemAttribute) {
                        $constraintAttributes[$constraintItemAttribute->nodeName] = $constraintItemAttribute->nodeValue;
                    }

                    if(!$constraintAttributes) {
                        $constraintAttributes = [];
                    }

                    $groupConstraints[$constraintNode->nodeName] = $constraintAttributes;
                }

                if(!array_key_exists($groupName, $constraints)) {
                    $constraints[$groupName] = [];
                }

                $constraints[$groupName] = [...$constraints[$groupName], ...$groupConstraints];
            }
        }

        return $constraints;
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
            dump($error);
            $errs[] = sprintf('%s in file `%s` on line %d', $error->message, $error->file, $error->line);
        }

        $errorMessage = implode("\n ", $errs);

        libxml_use_internal_errors(false);

        throw new \RuntimeException(sprintf("Schema validation exception: \r\n %s\r", $errorMessage));
    }
}
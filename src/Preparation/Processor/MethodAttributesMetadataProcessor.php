<?php

namespace Micro\Library\DTO\Preparation\Processor;

use Micro\Library\DTO\ClassDef\ClassDefinition;
use Micro\Library\DTO\ClassDef\MethodDefinition;
use Micro\Library\DTO\Helper\NameNormalizerInterface;
use Micro\Library\DTO\Preparation\PreparationProcessorInterface;


class MethodAttributesMetadataProcessor implements PreparationProcessorInterface
{

    public function __construct(private readonly NameNormalizerInterface $nameNormalizer)
    {

    }

    public function process(iterable $classDef, ClassDefinition $classDefinition, array $classList): void
    {
        $metadataArray = [];
        foreach ($classDefinition->getProperties() as $property) {
            $meta = [];
            $meta[PreparationProcessorInterface::PROP_TYPE] = $property->getTypes();
            $meta[PreparationProcessorInterface::PROP_REQUIRED] = $property->isRequired();
            $meta[PreparationProcessorInterface::PROP_ACTION_NAME] = $this->nameNormalizer->normalize(ucfirst($property->getName()));

            $propertyName = $property->getName();
            $metadataArray[$propertyName] = $meta;
        }

        $attributesMetaMethod = new MethodDefinition();
        $attributesMetaMethod->setIsStatic(true);
        $attributesMetaMethod->setName('attributesMetadata');
        $attributesMetaMethod->setTypesReturn(['array']);
        $attributesMetaMethod->setVisibility('protected');
        $attributesMetaMethod->setBody(
            'return ' . var_export($metadataArray, true) . ';'
        );

        $classDefinition->addMethod($attributesMetaMethod);
    }
}
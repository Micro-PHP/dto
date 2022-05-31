<?php

namespace Micro\Library\DTO\Preparation\Processor\Property;

use Micro\Library\DTO\ClassDef\ClassDefinition;
use Micro\Library\DTO\ClassDef\PropertyDefinition;
use Micro\Library\DTO\Object\Collection;
use Micro\Library\DTO\Preparation\PreparationProcessorInterface;

class PropertyCollectionProcessor implements PropertyProcessorInterface
{
    /**
     * @param PropertyDefinition $propertyDefinition
     * @param ClassDefinition $classDefinition
     * @param array $propertyData
     * @param array $classList
     *
     * @return void
     */
    public function process(PropertyDefinition $propertyDefinition, ClassDefinition $classDefinition, array $propertyData, array $classList): void
    {
        $isCollection = $propertyData[PreparationProcessorInterface::PROP_TYPE_IS_COLLECTION] ?? false;
        $isRequired = $propertyDefinition->isRequired();
        if(!$isCollection) {
            return;
        }

       // $propTypes = $propertyDefinition->getTypes();
        $types = [
            'iterable'
        ];

        if(!$isRequired) {
            $types[] = 'null';
        }

        $propertyDefinition->setTypes($types);
        $propertyDefinition->setIsCollection(true);

        $classDefinition->addUseStatement(Collection::class);
    }
}
<?php

namespace Micro\Library\DTO\Preparation\Processor\Property;

use Micro\Library\DTO\ClassDef\ClassDefinition;
use Micro\Library\DTO\ClassDef\PropertyDefinition;
use Micro\Library\DTO\Preparation\PreparationProcessorInterface;

class PropertyRequiredProcessor implements PropertyProcessorInterface
{
    /**
     * @param PropertyDefinition $propertyDefinition
     * @param ClassDefinition $classDefinition
     * @param array $propertyData
     *
     * @return void
     */
    public function process(PropertyDefinition $propertyDefinition, ClassDefinition $classDefinition, array $propertyData, array $classList): void
    {
        $propertyDefinition->setIsRequired($propertyData[PreparationProcessorInterface::PROP_REQUIRED] ?? false);
    }
}
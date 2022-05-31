<?php

namespace Micro\Library\DTO\Preparation\Processor\Property;

use Micro\Library\DTO\ClassDef\ClassDefinition;
use Micro\Library\DTO\ClassDef\PropertyDefinition;

interface PropertyProcessorInterface
{
    /**
     * @param PropertyDefinition $propertyDefinition
     * @param ClassDefinition $classDefinition
     * @param array $propertyData
     * @param array $classList
     *
     * @return void
     */
    public function process(PropertyDefinition $propertyDefinition, ClassDefinition $classDefinition, array $propertyData, array $classList): void;
}
<?php

namespace Micro\Library\DTO\Preparation\Processor;

use Micro\Library\DTO\ClassDef\ClassDefinition;
use Micro\Library\DTO\ClassDef\PropertyDefinition;
use Micro\Library\DTO\Preparation\PreparationProcessorInterface;
use Micro\Library\DTO\Preparation\Processor\Property\PropertyProcessorInterface;

class ClassPropertyProcessor implements PreparationProcessorInterface
{
    /**
     * @param iterable<PropertyProcessorInterface> $propertyProcessorCollection
     */
    public function __construct(private readonly iterable $propertyProcessorCollection)
    {
    }

    public function process(iterable $classDef, ClassDefinition $classDefinition, array $classList): void
    {
        foreach ($classDef[self::SECTION_PROPERTIES] as $property) {
            $this->processProperty($classDefinition, $property, $classList);
        }
    }

    protected function processProperty(ClassDefinition $classDefinition, array $propertyData, array $classList): void
    {
        $property = new PropertyDefinition();
        $classDefinition->addProperty($property);

        foreach ($this->propertyProcessorCollection as $processor) {
            $processor->process($property, $classDefinition, $propertyData, $classList);
        }
    }
}
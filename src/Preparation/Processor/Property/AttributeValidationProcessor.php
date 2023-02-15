<?php

declare(strict_types=1);


namespace Micro\Library\DTO\Preparation\Processor\Property;


use Micro\Library\DTO\ClassDef\ClassDefinition;
use Micro\Library\DTO\ClassDef\PropertyDefinition;

class AttributeValidationProcessor implements PropertyProcessorInterface
{
    /**
     * @param iterable<PropertyProcessorInterface> $validatorProcessor
     */
    public function __construct(
        private readonly iterable $validatorProcessor
    )
    {
    }

    public function process(PropertyDefinition $propertyDefinition, ClassDefinition $classDefinition, array $propertyData, array $classList): void
    {
        if(!array_key_exists('validation', $propertyData)) {
            return;
        }

        foreach ($this->validatorProcessor as $processor) {
            $processor->process($propertyDefinition, $classDefinition, $propertyData['validation'], $classList);
        }
    }
}

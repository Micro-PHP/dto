<?php

declare(strict_types=1);


namespace Micro\Library\DTO\Preparation\Processor\Property\Assert;


use Micro\Library\DTO\ClassDef\ClassDefinition;
use Micro\Library\DTO\ClassDef\PropertyDefinition;
use Micro\Library\DTO\Preparation\Processor\Property\PropertyProcessorInterface;

abstract class AbstractConstraintProcessor implements PropertyProcessorInterface
{
    public function process(PropertyDefinition $propertyDefinition, ClassDefinition $classDefinition, array $propertyData, array $classList): void
    {
        foreach ($propertyData as $config) {
            $validatorData = $config[$this->getValidatorProperty()] ?? null;
            if($validatorData === null) {
                continue;
            }

            $this->addAttribute($propertyDefinition, $this->getAttributeClassName(), $this->generateArguments($validatorData));
        }
    }

    protected function stringToBool(string $boolValue): bool
    {
        return mb_strtolower($boolValue) === 'true';
    }

    protected function explodeString(string $string, string $separator = ','): array
    {
        $exploded = explode($separator, $string);

        return array_map('trim', $exploded);
    }

    /**
     * @param array<string|mixed> $arguments
     */
    protected function addAttribute(PropertyDefinition $propertyDefinition, string $attributeClass, array $arguments): void
    {
        $propertyDefinition->addAttribute($this->getAttributeClassName(), $arguments);
    }

    protected function generateArguments(array $config): array
    {
        return array_filter([
            'message' => $config['message'] ?? null,
            'groups' =>  $this->explodeString($config['groups']),
        ]);
    }

    protected abstract function getValidatorProperty(): string;

    /**
     * @return class-string
     */
    protected abstract function getAttributeClassName(): string;
}

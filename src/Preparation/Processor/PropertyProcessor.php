<?php

namespace Micro\Library\DTO\Preparation\Processor;

use Micro\Library\DTO\Preparation\PreparationProcessorInterface as PreparationProcessorInterfaceAlias;

class PropertyProcessor implements PreparationProcessorInterfaceAlias
{
    /**
     * {@inheritDoc}
     */
    public function processClassCollection(iterable &$classDef): void
    {
        foreach ($classDef[self::SECTION_PROPERTIES] as &$property) {
            $propName = $property[self::PROP_NAME];
            $this->validatePropertyName($propName);
            $property[self::PROP_ACTION_NAME] = ucfirst($this->createCamelCase($propName));
        }
    }

    protected function validatePropertyName(string $propertyName): void
    {
        if(!preg_match('/^\w+$/i', $propertyName)) {
            throw new \RuntimeException(sprintf('Invalid property name "%s"', $propertyName));
        }
    }

    protected function createCamelCase(string $propertyName): string
    {
        return lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $propertyName))));
    }
}
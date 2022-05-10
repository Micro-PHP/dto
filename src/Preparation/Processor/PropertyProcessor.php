<?php

namespace Micro\Library\DTO\Preparation\Processor;

use Micro\Library\DTO\Preparation\PreparationProcessorInterface as PreparationProcessorInterfaceAlias;

class PropertyProcessor implements PreparationProcessorInterfaceAlias
{
    /**
     * {@inheritDoc}
     */
    public function processClassCollection(array $classCollection): array
    {
        $result = [];

        foreach ($classCollection as &$classDef) {
            foreach ($classDef['properties'] as &$property) {
                $propName = $property['name'];
                $this->validatePropertyName($propName);
                $property['actionName'] = ucfirst($this->createCamelCase($propName));
            }

            $result[] = $classDef;
        }

        return $result;
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
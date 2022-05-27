<?php

namespace Micro\Library\DTO\Preparation\Processor;

use Micro\Library\DTO\Preparation\PreparationProcessorInterface;

class ClassDefDefaultsProcessor implements PreparationProcessorInterface
{
    /**
     * {@inheritDoc}
     */
    public function processClassCollection(iterable &$classDef): void
    {
        $defaultClassOptions = [
            'useStatements' => [],
            'type' => 'mixed',
            'namespace' => null,
        ];

        foreach ($defaultClassOptions as $name => $default) {
            if(isset($classDef[$name])) {
                continue;
            }

            $classDef[$name] = $default;
        }
    }
}
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
            self::CLASS_USE_STATEMENTS => [],
            self::PROP_TYPE => 'mixed',
            self::CLASS_NAMESPACE => null,
            self::PROP_TYPE_IS_COLLECTION => false,
        ];

        foreach ($defaultClassOptions as $name => $default) {
            if(isset($classDef[$name])) {
                continue;
            }

            $classDef[$name] = $default;
        }
    }
}
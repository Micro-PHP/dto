<?php

declare(strict_types=1);


namespace Micro\Library\DTO\Preparation\Processor\Property\Assert;


abstract class AbstractComparisonStrategy extends AbstractConstraintStrategy
{
    protected function generateArguments(array $config): array
    {
        $parent = parent::generateArguments($config);

        return array_filter([
            ...$parent,
            'propertyPath'  => $config['property_path'] ?? null,
            'value' => $config['value'] ?? null
        ]);
    }
}

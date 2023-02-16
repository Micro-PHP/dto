<?php

declare(strict_types=1);

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Library\DTO\Preparation\Processor\Property\Assert;

abstract class AbstractComparisonStrategy extends AbstractConstraintStrategy
{
    protected function generateArguments(array $config): array
    {
        $parent = parent::generateArguments($config);
        $value = $config['value'] ?? false;
        $int = (int) $value;
        $float = (float) $value;

        $current = [
            'propertyPath' => $config['property_path'] ?? null,
            'value' => ($int == $float) ? $int : $float,
        ];

        return array_filter(array_merge($parent, $current));
    }
}

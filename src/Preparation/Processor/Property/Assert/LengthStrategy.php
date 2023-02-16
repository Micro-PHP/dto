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

use Symfony\Component\Validator\Constraints\Length;

class LengthStrategy extends AbstractConstraintStrategy
{
    protected function generateArguments(array $config): array
    {
        $parent = parent::generateArguments($config);
        $attributesInteger = ['min', 'max'];
        foreach ($attributesInteger as $attribute) {
            if (!\array_key_exists($attribute, $config)) {
                continue;
            }

            $config[$attribute] = (int) $config[$attribute];
        }

        $current = [
            'max' => $config['max'] ?? null,
            'min' => $config['min'] ?? null,
            'minMessage' => $config['min_message'] ?? null,
            'maxMessage' => $config['max_message'] ?? null,
        ];

        return array_filter(array_merge($parent, $current));
    }

    protected function getValidatorProperty(): string
    {
        return 'length';
    }

    protected function getAttributeClassName(): string
    {
        return Length::class;
    }
}

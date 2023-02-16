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

use Symfony\Component\Validator\Constraints\Range;

class RangeStrategy extends LengthStrategy
{
    protected function generateArguments(array $config): array
    {
        $parent = parent::generateArguments($config);
        $current = [
            'invalidDateTimeMessage' => $config['invalid_datetime_message'] ?? null,
            'invalidMessage' => $config['invalid_message'] ?? null,
            'maxPropertyPath' => $config['property_path_max'] ?? null,
            'minPropertyPath' => $config['property_path_min'] ?? null,
            'notInRangeMessage' => $config['message_not_in_range'] ?? null,
        ];

        return array_filter(array_merge($parent, $current));
    }

    protected function getValidatorProperty(): string
    {
        return 'range';
    }

    protected function getAttributeClassName(): string
    {
        return Range::class;
    }
}

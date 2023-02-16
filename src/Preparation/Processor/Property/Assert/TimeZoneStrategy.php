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

use Symfony\Component\Validator\Constraints\Timezone;

class TimeZoneStrategy extends AbstractConstraintStrategy
{
    protected function generateArguments(array $config): array
    {
        $parent = parent::generateArguments($config);

        $parent['countryCode'] = $config['country_code'] ?? null;
        $parent['intlCompatible'] = $this->stringToBool($config['intl_compatible'] ?? 'false');
        $parent['zone'] = (int) ($config['zone'] ?? \DateTimeZone::ALL);

        return array_filter($parent);
    }

    protected function getValidatorProperty(): string
    {
        return 'time_zone';
    }

    protected function getAttributeClassName(): string
    {
        return Timezone::class;
    }
}

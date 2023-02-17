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

        $this->applyTz($parent, $config);

        return array_filter($parent);
    }

    /**
     * @param array<string, mixed> $args
     * @param array<string, mixed> $config
     *
     * @return void
     */
    protected function applyTz(array &$args, array $config): void
    {
        $zone = 0;
        if (empty($config['zone'])) {
            $args['zone'] = \DateTimeZone::ALL;

            return;
        }

        $zones = $config['zone'];
        foreach ($zones as $z) {
            $zone |= $this->getTzValue($z['value']);
        }

        $args['zone'] = $zone;
    }

    protected function getTzValue(string $zoneName): int
    {
        $constName = sprintf('%s::%s', \DateTimeZone::class, $zoneName);
        if (!\defined($constName)) {
            throw new \InvalidArgumentException(sprintf('Time zone `%s` is not defined in class %s', $zoneName, \DateTimeZone::class));
        }

        return \constant($constName);
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

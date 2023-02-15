<?php

declare(strict_types=1);


namespace Micro\Library\DTO\Preparation\Processor\Property\Assert;


use Symfony\Component\Validator\Constraints\Timezone;

class TimeZoneStrategy extends AbstractConstraintProcessor
{

    protected function generateArguments(array $config): array
    {
        $parent = parent::generateArguments($config);

        return array_filter([
            ...$parent,
            'countryCode'   => $config['country_code'] ?? null,
            'intlCompatible'    => $this->stringToBool($config['intl_compatible'] ?? 'false'),
            'zone'  => intval($config['zone'] ?? \DateTimeZone::ALL),
        ]);
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

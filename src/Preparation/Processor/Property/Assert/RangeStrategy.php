<?php

declare(strict_types=1);


namespace Micro\Library\DTO\Preparation\Processor\Property\Assert;


use Symfony\Component\Validator\Constraints\Range;

class RangeStrategy extends LengthStrategy
{
    protected function generateArguments(array $config): array
    {
        return array_filter([
            ...parent::generateArguments($config),
            'invalidDateTimeMessage'    => $config['invalid_datetime_message'] ?? null,
            'invalidMessage'    => $config['invalid_message'] ?? null,
            'maxPropertyPath'   => $config['property_path_max'] ?? null,
            'minPropertyPath' => $config['property_path_min'] ?? null,
            'notInRangeMessage' => $config['message_not_in_range'] ?? null,
        ]);
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

<?php

declare(strict_types=1);


namespace Micro\Library\DTO\Preparation\Processor\Property\Assert;


use Symfony\Component\Validator\Constraints\Bic;

class BicStrategy extends AbstractConstraintStrategy
{
    protected function generateArguments(array $config): array
    {
        return array_filter([
            ...parent::generateArguments($config),
            'iban'  => $config['iban'] ?? null,
            'ibanMessage'   => $config['message_iban'] ?? null,
            'ibanPropertyPath'  => $config['iban_property_path'] ?? null,
        ]);
    }

    protected function getValidatorProperty(): string
    {
        return 'bic';
    }

    protected function getAttributeClassName(): string
    {
        return Bic::class;
    }
}

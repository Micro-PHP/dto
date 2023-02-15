<?php

declare(strict_types=1);


namespace Micro\Library\DTO\Preparation\Processor\Property\Assert;


use Symfony\Component\Validator\Constraints\Iban;

class IbanStrategy extends AbstractConstraintStrategy
{
    protected function getValidatorProperty(): string
    {
        return 'iban';
    }

    protected function getAttributeClassName(): string
    {
        return Iban::class;
    }
}

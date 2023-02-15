<?php

declare(strict_types=1);


namespace Micro\Library\DTO\Preparation\Processor\Property\Assert;


use Symfony\Component\Validator\Constraints\Currency;

class CurrencyStrategy extends AbstractConstraintStrategy
{
    protected function getValidatorProperty(): string
    {
        return 'currency';
    }

    protected function getAttributeClassName(): string
    {
        return Currency::class;
    }
}

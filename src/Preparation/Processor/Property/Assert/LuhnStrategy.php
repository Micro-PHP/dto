<?php

declare(strict_types=1);


namespace Micro\Library\DTO\Preparation\Processor\Property\Assert;


use Symfony\Component\Validator\Constraints\Luhn;

class LuhnStrategy extends AbstractConstraintStrategy
{
    protected function getValidatorProperty(): string
    {
        return 'luhn';
    }

    protected function getAttributeClassName(): string
    {
        return Luhn::class;
    }
}

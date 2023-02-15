<?php

declare(strict_types=1);


namespace Micro\Library\DTO\Preparation\Processor\Property\Assert;


use Symfony\Component\Validator\Constraints\NegativeOrZero;

class AssertNegativeOrZeroProcessor extends AbstractConstraintProcessor
{

    protected function getValidatorProperty(): string
    {
        return 'negative_or_zero';
    }

    protected function getAttributeClassName(): string
    {
        return NegativeOrZero::class;
    }
}

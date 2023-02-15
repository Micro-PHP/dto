<?php

declare(strict_types=1);


namespace Micro\Library\DTO\Preparation\Processor\Property\Assert;


use Symfony\Component\Validator\Constraints\PositiveOrZero;

class PositiveOrZeroStrategy extends AbstractConstraintStrategy
{
    protected function getValidatorProperty(): string
    {
        return 'positive_or_zero';
    }

    protected function getAttributeClassName(): string
    {
        return PositiveOrZero::class;
    }
}
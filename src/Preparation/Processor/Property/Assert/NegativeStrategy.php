<?php

declare(strict_types=1);


namespace Micro\Library\DTO\Preparation\Processor\Property\Assert;


use Symfony\Component\Validator\Constraints\Negative;

class NegativeStrategy extends AbstractConstraintStrategy
{

    protected function getValidatorProperty(): string
    {
        return 'negative';
    }

    protected function getAttributeClassName(): string
    {
        return Negative::class;
    }
}

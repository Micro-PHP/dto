<?php

declare(strict_types=1);


namespace Micro\Library\DTO\Preparation\Processor\Property\Assert;


use Symfony\Component\Validator\Constraints\Positive;

class PositiveStrategy extends AbstractConstraintProcessor
{

    protected function getValidatorProperty(): string
    {
        return 'positive';
    }

    protected function getAttributeClassName(): string
    {
        return Positive::class;
    }
}

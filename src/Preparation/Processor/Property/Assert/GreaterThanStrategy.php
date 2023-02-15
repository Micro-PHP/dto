<?php

declare(strict_types=1);


namespace Micro\Library\DTO\Preparation\Processor\Property\Assert;

use Symfony\Component\Validator\Constraints\GreaterThan;

class GreaterThanStrategy extends AbstractComparisonStrategy
{

    protected function getValidatorProperty(): string
    {
        return 'less_than';
    }

    protected function getAttributeClassName(): string
    {
        return GreaterThan::class;
    }
}

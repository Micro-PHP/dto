<?php

declare(strict_types=1);


namespace Micro\Library\DTO\Preparation\Processor\Property\Assert;


use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;

class GreaterThanOrEqualStrategy extends AbstractComparisonStrategy
{
    protected function getValidatorProperty(): string
    {
        return 'greater_than_or_equal';
    }

    protected function getAttributeClassName(): string
    {
        return GreaterThanOrEqual::class;
    }
}

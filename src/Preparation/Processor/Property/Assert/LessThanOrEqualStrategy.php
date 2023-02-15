<?php

declare(strict_types=1);


namespace Micro\Library\DTO\Preparation\Processor\Property\Assert;


use Symfony\Component\Validator\Constraints\LessThanOrEqual;

class LessThanOrEqualStrategy extends AbstractComparisonStrategy
{
    protected function getValidatorProperty(): string
    {
        return 'less_than_or_equal';
    }

    protected function getAttributeClassName(): string
    {
        return LessThanOrEqual::class;
    }
}

<?php

declare(strict_types=1);


namespace Micro\Library\DTO\Preparation\Processor\Property\Assert;


use Symfony\Component\Validator\Constraints\NotEqualTo;

class NotEqualToStrategy extends AbstractComparisonStrategy
{
    protected function getValidatorProperty(): string
    {
        return 'not_equal_to';
    }

    protected function getAttributeClassName(): string
    {
        return NotEqualTo::class;
    }
}

<?php

declare(strict_types=1);


namespace Micro\Library\DTO\Preparation\Processor\Property\Assert;


use Symfony\Component\Validator\Constraints\EqualTo;

class EqualToStrategy extends AbstractComparisonStrategy
{
    protected function getValidatorProperty(): string
    {
        return 'equal_to';
    }

    protected function getAttributeClassName(): string
    {
        return EqualTo::class;
    }
}

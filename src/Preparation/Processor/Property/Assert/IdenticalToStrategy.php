<?php

declare(strict_types=1);


namespace Micro\Library\DTO\Preparation\Processor\Property\Assert;


use Symfony\Component\Validator\Constraints\IdenticalTo;

class IdenticalToStrategy extends AbstractComparisonStrategy
{

    protected function getValidatorProperty(): string
    {
        return 'identical_to';
    }

    protected function getAttributeClassName(): string
    {
        return IdenticalTo::class;
    }
}

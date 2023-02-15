<?php

declare(strict_types=1);


namespace Micro\Library\DTO\Preparation\Processor\Property\Assert;


use Symfony\Component\Validator\Constraints\NotIdenticalTo;

class NotIdenticalToStrategy extends AbstractComparisonStrategy
{

    protected function getValidatorProperty(): string
    {
        return 'not_identical_to';
    }

    protected function getAttributeClassName(): string
    {
        return NotIdenticalTo::class;
    }
}

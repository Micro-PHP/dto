<?php

declare(strict_types=1);


namespace Micro\Library\DTO\Preparation\Processor\Property\Assert;


use Symfony\Component\Validator\Constraints\Time;

class AssertTimeProcessor extends AbstractConstraintProcessor
{
    protected function getValidatorProperty(): string
    {
        return 'time';
    }

    protected function getAttributeClassName(): string
    {
        return Time::class;
    }
}

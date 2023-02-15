<?php

declare(strict_types=1);


namespace Micro\Library\DTO\Preparation\Processor\Property\Assert;


use Symfony\Component\Validator\Constraints\Date;

class DateStrategy extends AbstractConstraintProcessor
{

    protected function getValidatorProperty(): string
    {
        return 'date';
    }

    protected function getAttributeClassName(): string
    {
        return Date::class;
    }
}

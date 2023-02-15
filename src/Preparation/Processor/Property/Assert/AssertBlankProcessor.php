<?php

declare(strict_types=1);


namespace Micro\Library\DTO\Preparation\Processor\Property\Assert;


use Symfony\Component\Validator\Constraints\Blank;

class AssertBlankProcessor extends AbstractConstraintProcessor
{

    protected function getValidatorProperty(): string
    {
        return 'blank';
    }

    protected function getAttributeClassName(): string
    {
        return Blank::class;
    }
}

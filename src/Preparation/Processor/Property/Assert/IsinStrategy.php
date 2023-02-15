<?php

declare(strict_types=1);


namespace Micro\Library\DTO\Preparation\Processor\Property\Assert;


use Symfony\Component\Validator\Constraints\Isin;

class IsinStrategy extends AbstractConstraintStrategy
{
    protected function getValidatorProperty(): string
    {
        return 'isin';
    }

    protected function getAttributeClassName(): string
    {
        return Isin::class;
    }
}

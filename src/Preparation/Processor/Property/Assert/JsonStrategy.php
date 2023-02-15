<?php

declare(strict_types=1);


namespace Micro\Library\DTO\Preparation\Processor\Property\Assert;


use Symfony\Component\Validator\Constraints\Json;

class JsonStrategy extends AbstractConstraintStrategy
{
    protected function getValidatorProperty(): string
    {
        return 'json';
    }

    protected function getAttributeClassName(): string
    {
        return Json::class;
    }
}

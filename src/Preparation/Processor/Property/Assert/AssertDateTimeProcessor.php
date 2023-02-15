<?php

declare(strict_types=1);


namespace Micro\Library\DTO\Preparation\Processor\Property\Assert;


use Symfony\Component\Validator\Constraints\DateTime;

class AssertDateTimeProcessor extends AbstractConstraintProcessor
{
    protected function generateArguments(array $config): array
    {
        $parent =  parent::generateArguments($config);

        return [
            ...$parent,
            'format'    => $config['format'] ?? 'Y-m-d H:i:s',
        ];
    }

    protected function getValidatorProperty(): string
    {
        return 'datetime';
    }

    protected function getAttributeClassName(): string
    {
        return DateTime::class;
    }
}

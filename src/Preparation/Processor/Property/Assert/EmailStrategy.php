<?php

declare(strict_types=1);


namespace Micro\Library\DTO\Preparation\Processor\Property\Assert;

use Symfony\Component\Validator\Constraints\Email;

class EmailStrategy extends AbstractConstraintStrategy
{
    protected function generateArguments(array $config): array
    {
        $parentArgs = parent::generateArguments($config);

        return [
            ...$parentArgs,
            'mode'  => $config['mode'] ?? 'html5',
        ];
    }

    protected function getValidatorProperty(): string
    {
        return 'email';
    }

    protected function getAttributeClassName(): string
    {
        return Email::class;
    }
}

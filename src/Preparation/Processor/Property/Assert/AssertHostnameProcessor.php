<?php

declare(strict_types=1);


namespace Micro\Library\DTO\Preparation\Processor\Property\Assert;

use Symfony\Component\Validator\Constraints\Hostname;

class AssertHostnameProcessor extends AbstractConstraintProcessor
{

    protected function generateArguments(array $config, string $groupName): array
    {
        $arguments =  parent::generateArguments($config, $groupName);

        return [
            ...$arguments,
            ...[
                'requireTld' => $this->stringToBool($config['ltd_required'] ?? 'false')
            ]
        ];
    }

    protected function getValidatorProperty(): string
    {
        return 'hostname';
    }

    protected function getAttributeClassName(): string
    {
        return Hostname::class;
    }
}

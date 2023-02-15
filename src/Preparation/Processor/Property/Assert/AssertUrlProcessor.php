<?php

declare(strict_types=1);


namespace Micro\Library\DTO\Preparation\Processor\Property\Assert;


use Symfony\Component\Validator\Constraints\Url;

class AssertUrlProcessor extends AbstractConstraintProcessor
{
    protected function generateArguments(array $config, string $groupName): array
    {
        $parentArgs = parent::generateArguments($config, $groupName);
        // TODO: protocols

        return [
            ...$parentArgs,
            'relativeProtocol'  => $this->stringToBool($config['is_relative'] ?? 'false'),
        ];
    }

    protected function getValidatorProperty(): string
    {
        return 'url';
    }

    protected function getAttributeClassName(): string
    {
        return Url::class;
    }
}

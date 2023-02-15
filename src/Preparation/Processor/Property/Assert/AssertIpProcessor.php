<?php

declare(strict_types=1);


namespace Micro\Library\DTO\Preparation\Processor\Property\Assert;


use Symfony\Component\Validator\Constraints\Ip;

class AssertIpProcessor extends AbstractConstraintProcessor
{

    protected function generateArguments(array $config, string $groupName): array
    {
        $parent =  parent::generateArguments($config, $groupName);

        return [
            ...$parent,
            'version'   => $config['version'] ?? '4',
        ];
    }

    protected function getValidatorProperty(): string
    {
        return 'ip';
    }

    protected function getAttributeClassName(): string
    {
        return Ip::class;
    }
}

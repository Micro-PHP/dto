<?php

declare(strict_types=1);


namespace Micro\Library\DTO\Preparation\Processor\Property\Assert;


use Symfony\Component\Validator\Constraints\Ip;

class IpStrategy extends AbstractConstraintStrategy
{

    protected function generateArguments(array $config): array
    {
        $parent =  parent::generateArguments($config);

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

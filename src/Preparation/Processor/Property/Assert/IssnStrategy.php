<?php

declare(strict_types=1);


namespace Micro\Library\DTO\Preparation\Processor\Property\Assert;


use Symfony\Component\Validator\Constraints\Issn;

class IssnStrategy extends AbstractConstraintStrategy
{
    protected function generateArguments(array $config): array
    {
        return array_filter([
            ...parent::generateArguments($config),
            'caseSensitive' => $this->stringToBool($config['case_sensitive'] ?? 'false'),
            'requireHyphen' => $this->stringToBool($config['require_hyphen'] ?? 'false'),
        ]);
    }

    protected function getValidatorProperty(): string
    {
        return 'issn';
    }

    protected function getAttributeClassName(): string
    {
        return Issn::class;
    }
}

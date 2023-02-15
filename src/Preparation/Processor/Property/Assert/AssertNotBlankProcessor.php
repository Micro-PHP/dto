<?php

declare(strict_types=1);


namespace Micro\Library\DTO\Preparation\Processor\Property\Assert;


use Symfony\Component\Validator\Constraints\NotBlank;

class AssertNotBlankProcessor extends AbstractConstraintProcessor
{

    protected function generateArguments(array $config, string $groupName): array
    {
        $parent = parent::generateArguments($config, $groupName);

        return [
            ...$parent,
            'allowNull' => $this->stringToBool($config['allow_null'] ?? 'false')
        ];
    }

    protected function getValidatorProperty(): string
    {
        return 'not_blank';
    }

    protected function getAttributeClassName(): string
    {
        return NotBlank::class;
    }
}

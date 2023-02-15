<?php

declare(strict_types=1);


namespace Micro\Library\DTO\Preparation\Processor\Property\Assert;


use Symfony\Component\Validator\Constraints\Length;

class AssertLengthProcessor extends AbstractConstraintProcessor
{

    protected function generateArguments(array $config, string $groupName): array
    {
        $attributesInteger = ['min', 'max'];
        foreach ($attributesInteger as $attribute) {
            if(!array_key_exists($attribute, $config)) {
                continue;
            }

            $config[$attribute] = (int) $config[$attribute];
        }

        return array_filter([
            'max'  => $config['max'] ?? null,
            'min'  => $config['min'] ?? null,
            'minMessage'    => $config['min_message'] ?? null,
            'maxMessage'    => $config['max_message'] ?? null,
        ]);
    }

    protected function getValidatorProperty(): string
    {
        return 'length';
    }

    protected function getAttributeClassName(): string
    {
        return Length::class;
    }
}

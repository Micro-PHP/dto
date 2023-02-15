<?php

declare(strict_types=1);


namespace Micro\Library\DTO\Preparation\Processor\Property\Assert;


use Symfony\Component\Validator\Constraints\CardScheme;

class CardSchemeStrategy extends AbstractConstraintStrategy
{
    protected function generateArguments(array $config): array
    {
        return array_filter([
            ...parent::generateArguments($config),
            'schemes'   => $this->extractSchemes($config),
        ]);
    }

    protected function extractSchemes(array $config): array|null
    {
        $schemes = $this->explodeString($config['schemes'] ?? '');
        if(!$schemes) {
            return null;
        }

        $result = [];
        foreach ($schemes as $schemaName) {
            $s = constant(sprintf('%s::%s', CardScheme::class, $schemaName));
            $result[] = $s ?: $schemaName;
        }

        return $result;
    }

    protected function getValidatorProperty(): string
    {
        return 'card_scheme';
    }

    protected function getAttributeClassName(): string
    {
        return CardScheme::class;
    }
}

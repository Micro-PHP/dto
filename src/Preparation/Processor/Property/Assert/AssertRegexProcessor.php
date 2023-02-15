<?php

declare(strict_types=1);


namespace Micro\Library\DTO\Preparation\Processor\Property\Assert;


use Symfony\Component\Validator\Constraints\Regex;

class AssertRegexProcessor extends AbstractConstraintProcessor
{

    protected function generateArguments(array $config): array
    {
        $parentArgs = parent::generateArguments($config);

        $match = $config['match'] ?? 'true';

        return [
            ...$parentArgs,
            'pattern'  => $config['pattern'],
            'match' => $this->stringToBool($match),
        ];
    }

    protected function getValidatorProperty(): string
    {
        return 'regex';
    }

    protected function getAttributeClassName(): string
    {
        return Regex::class;
    }
}

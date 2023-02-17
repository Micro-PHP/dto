<?php

declare(strict_types=1);

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Library\DTO\Preparation\Processor\Property\Assert;

use Symfony\Component\Validator\Constraints\Choice;

class ChoiceStrategy extends AbstractComparisonStrategy
{
    protected function generateArguments(array $config): array
    {
        $parent = parent::generateArguments($config);

        $current = [
            'choices' => $this->createChoiceArray($config),
            'callback' => $config['callback'] ?? null,
            'multiple' => $this->sanitize($config['multiple'] ?? false),
            'multipleMessage' => $config['message_multiple'] ?? null,
            'match' => $this->sanitize($config['match'] ?? false),
        ];

        return array_filter(
            array_merge($parent, $current)
        );
    }

    /**
     * @param array<string|mixed> $config
     *
     * @return array<int|string|float|bool|null>|null
     */
    protected function createChoiceArray(array $config): array|null
    {
        $choices = trim($config['choices'] ?? '');
        if (!$choices) {
            return null;
        }

        $values = $this->explodeString($choices);

        return array_map(function (mixed $value) {
            return $this->sanitize($value);
        }, $values);
    }

    protected function getValidatorProperty(): string
    {
        return 'choice';
    }

    protected function getAttributeClassName(): string
    {
        return Choice::class;
    }
}

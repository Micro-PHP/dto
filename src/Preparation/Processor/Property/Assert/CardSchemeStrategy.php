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

use Symfony\Component\Validator\Constraints\CardScheme;

class CardSchemeStrategy extends AbstractConstraintStrategy
{
    protected function generateArguments(array $config): array
    {
        $parent = parent::generateArguments($config);
        $parent['schemes'] = $this->extractSchemes($config);

        return array_filter($parent);
    }

    /**
     * @param array<string, mixed> $config
     *
     * @return array<string>|null
     */
    protected function extractSchemes(array $config): array|null
    {
        $schemes = $this->explodeString($config['schemes'] ?? '');
        if (!$schemes) {
            return null;
        }

        $result = [];
        foreach ($schemes as $schemaName) {
            $s = \constant(sprintf('%s::%s', CardScheme::class, $schemaName));
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

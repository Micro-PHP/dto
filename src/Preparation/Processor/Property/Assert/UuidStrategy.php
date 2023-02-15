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

use Symfony\Component\Validator\Constraints\Uuid;

class UuidStrategy extends AbstractConstraintStrategy
{
    public const ALLOWED_VERSIONS = [
        Uuid::V1_MAC,
        Uuid::V2_DCE,
        Uuid::V3_MD5,
        Uuid::V4_RANDOM,
        Uuid::V5_SHA1,
        Uuid::V6_SORTABLE,
        Uuid::V7_MONOTONIC,
    ];

    protected function generateArguments(array $config): array
    {
        /** @psalm-suppress PossiblyInvalidArgument */
        return array_filter([
            ...parent::generateArguments($config),
            'versions' => $this->parseVersions(trim($config['versions'] ?? '')),
            'strict' => $this->stringToBool($config['strict'] ?? 'true'),
        ]);
    }

    protected function getValidatorProperty(): string
    {
        return 'uuid';
    }

    protected function getAttributeClassName(): string
    {
        return Uuid::class;
    }

    /**
     * @param array<int|string>|string $original
     *
     * @return array<int>
     */
    private function parseVersions(array|string $original): array
    {
        if ('' === $original) {
            return self::ALLOWED_VERSIONS;
        }

        $versions = $original;
        if (\is_string($versions)) {
            $versions = $this->explodeString($versions);
        }

        $versions = array_map('intval', $versions);
        $isValid = !array_diff($versions, self::ALLOWED_VERSIONS);
        if ($isValid) {
            return $versions;
        }

        throw new \InvalidArgumentException(sprintf('UUID versions is not allowed. Actual: `%s`, Available: `%s`', \is_array($original) ? implode(', ', $original) : $original, implode(',', self::ALLOWED_VERSIONS)));
    }
}

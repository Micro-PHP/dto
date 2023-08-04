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
    /**
     * @return array<int>
     */
    public function getAvailableVersions(): array
    {
        // Supports 5.4 version
        $constants = [
            'V1_MAC', 'V2_DCE', 'V3_MD5', 'V4_RANDOM', 'V5_SHA1', 'V6_SORTABLE', 'V7_MONOTONIC',
        ];

        return array_filter(array_map(function (string $constName) {
            $cName = sprintf('%s::%s', Uuid::class, $constName);

            return \defined($cName) ? \constant($cName) : null;
        }, $constants));
    }

    protected function generateArguments(array $config): array
    {
        /** @psalm-suppress PossiblyInvalidArgument */
        return array_filter(
            array_merge(
                parent::generateArguments($config),
                [
                    'versions' => $this->parseVersions(trim($config['versions'] ?? '')),
                    'strict' => $this->stringToBool($config['strict'] ?? 'true'),
                ]
            )
        );
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
        $availableVersions = $this->getAvailableVersions();
        if ('' === $original) {
            return $availableVersions;
        }

        $versions = $original;
        if (\is_string($versions)) {
            $versions = $this->explodeString($versions);
        }

        $versions = array_map('intval', $versions);
        $isValid = !array_diff($versions, $availableVersions);
        if ($isValid) {
            return $versions;
        }

        throw new \InvalidArgumentException(sprintf('UUID versions is not allowed. Actual: `%s`, Available: `%s`', \is_array($original) ? implode(', ', $original) : $original, implode(',', $availableVersions)));
    }
}

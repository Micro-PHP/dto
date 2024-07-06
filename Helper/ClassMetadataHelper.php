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

namespace Micro\Library\DTO\Helper;

use Micro\Library\DTO\Object\AbstractDto;

readonly class ClassMetadataHelper implements ClassMetadataHelperInterface
{
    public function __construct(
        private string $namespaceGeneral,
        private string $classSuffix
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function generateNamespace(string $className): string
    {
        $exploded = explode('\\', $className);
        if (1 === \count($exploded)) {
            return $this->namespaceGeneral;
        }

        $namespaceExploded = [];
        $shouldAddGeneralNamespace = $this->shouldAddGeneralNamespace($className);

        if ($shouldAddGeneralNamespace && $this->namespaceGeneral) {
            $namespaceExploded[] = $this->namespaceGeneral;
        }

        $namespaceExploded = array_merge($namespaceExploded, $exploded);

        array_pop($namespaceExploded);

        return implode('\\', $namespaceExploded);
    }

    /**
     * {@inheritDoc}
     */
    public function generateClassname(string $className): string
    {
        if (!$this->shouldAddGeneralNamespace($className)) {
            return $className;
        }

        return $this->generateNamespace($className).'\\'.$this->generateClassnameShort($className);
    }

    /**
     * {@inheritDoc}
     */
    public function generateClassnameShort(string $className): string
    {
        $shouldAddSuffix = $this->shouldAddGeneralNamespace($className);
        $exploded = explode('\\', $className);

        if (!$shouldAddSuffix) {
            return array_pop($exploded);
        }

        if (1 === \count($exploded)) {
            return $className.ucfirst($this->classSuffix);
        }

        return array_pop($exploded).ucfirst($this->classSuffix);
    }

    protected function shouldAddGeneralNamespace(string $classname): bool
    {
        if (self::PROPERTY_TYPE_ABSTRACT === mb_strtolower($classname)) {
            return false;
        }

        if (!class_exists($classname)) {
            return true;
        }

        if (str_starts_with($classname, $this->namespaceGeneral)) {
            return false;
        }

        if (is_a($classname, AbstractDto::class, true)) {
            return false;
        }

        if (is_a($classname, \DateTimeInterface::class, true)) {
            return false;
        }

        return true;
    }
}

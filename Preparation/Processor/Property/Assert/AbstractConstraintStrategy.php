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

use Micro\Library\DTO\ClassDef\ClassDefinition;
use Micro\Library\DTO\ClassDef\PropertyDefinition;
use Micro\Library\DTO\Preparation\Processor\Property\PropertyProcessorInterface;

abstract class AbstractConstraintStrategy implements PropertyProcessorInterface
{
    public function process(PropertyDefinition $propertyDefinition, ClassDefinition $classDefinition, array $propertyData, array $classList): void
    {
        $validatorProperty = $this->getValidatorProperty();
        if (!isset($propertyData[$validatorProperty])) {
            return;
        }

        $validatorData = $propertyData[$validatorProperty] ?? [];

        $this->addAttribute($propertyDefinition, $this->generateArguments($validatorData));
    }

    protected function stringToBool(string $boolValue): bool
    {
        return 'true' === mb_strtolower($boolValue);
    }

    /**
     * @return array<string>
     */
    protected function explodeString(string $string, string $separator = ','): array
    {
        if (!$separator) {
            $separator = ',';
        }

        $exploded = explode($separator, $string);

        return array_filter(array_map('trim', $exploded));
    }

    /**
     * @param array<string|mixed> $arguments
     */
    protected function addAttribute(PropertyDefinition $propertyDefinition, array $arguments): void
    {
        $propertyDefinition->addAttribute($this->getAttributeClassName(), $arguments);
    }

    /**
     * @param array<string|mixed> $config
     *
     * @return array<string, mixed>
     */
    protected function generateArguments(array $config): array
    {
        return array_filter([
            'message' => $config['message'] ?? null,
            'groups' => $this->explodeString($config['groups'] ?? 'Default'),
        ]);
    }

    /**
     * @param mixed $value
     *
     * @return string|int|bool|float|null
     */
    protected function sanitize(mixed $value): string|int|bool|float|null
    {
        if ('string' !== \gettype($value)) {
            return $value;
        }

        $boolValues = ['true', 'false'];
        $valueLowercase = mb_strtolower($value);
        if (\in_array($valueLowercase, $boolValues)) {
            return 'true' === $valueLowercase;
        }

        if (is_numeric($value)) {
            $double = (float) $value;
            $int = (int) $value;

            return $int == $double ? $int : $double;
        }

        return $value;
    }

    abstract protected function getValidatorProperty(): string;

    /**
     * @return class-string
     */
    abstract protected function getAttributeClassName(): string;
}

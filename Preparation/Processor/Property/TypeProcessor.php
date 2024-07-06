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

namespace Micro\Library\DTO\Preparation\Processor\Property;

use Micro\Library\DTO\ClassDef\ClassDefinition;
use Micro\Library\DTO\ClassDef\PropertyDefinition;
use Micro\Library\DTO\Preparation\PreparationProcessorInterface;

class TypeProcessor implements PropertyProcessorInterface
{
    public const SCALAR_TYPES = [
        'string', 'int', 'float', 'bool',
        'array', 'null',
    ];

    public function process(
        PropertyDefinition $propertyDefinition,
        ClassDefinition $classDefinition,
        array $propertyData,
        array $classList
    ): void {
        $propTypeSource = $propertyData[PreparationProcessorInterface::PROP_TYPE] ?? 'mixed';
        $exploded = explode('|', $propTypeSource);
        $isRequired = $propertyData[PreparationProcessorInterface::PROP_REQUIRED] ?? false;

        if (\in_array('mixed', $exploded) && \count($exploded) > 1) {
            $this->throwException(
                $propertyDefinition,
                $classDefinition,
                sprintf('Invalid type "%s"', $propTypeSource)
            );
        }

        foreach ($exploded as $pos => $tmpType) {
            $tmpType = mb_strtolower($tmpType);
            if (\in_array($tmpType, static::SCALAR_TYPES) || 'mixed' === $tmpType) {
                $exploded[$pos] = $tmpType;

                continue;
            }

            // TODO: DTO Generate
        }

        if (\count(array_unique($exploded)) !== \count($exploded)) {
            $this->throwException(
                $propertyDefinition,
                $classDefinition,
                sprintf('Invalid type "%s"', $propTypeSource)
            );
        }

        if (!$isRequired && !\in_array('mixed', $exploded)) {
            $exploded[] = 'null';
        }

        $propertyDefinition->setTypes($exploded);
    }

    /**
     * @param PropertyDefinition $propertyDefinition
     * @param ClassDefinition    $classDefinition
     * @param string             $message
     *
     * @return string
     */
    protected function throwException(PropertyDefinition $propertyDefinition, ClassDefinition $classDefinition, string $message): string
    {
        throw new \RuntimeException(sprintf('Class "%s\%s" property "%s": %s', $classDefinition->getNamespace(), $classDefinition->getName(), $propertyDefinition->getName(), $message));
    }
}

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

class AttributeValidationProcessor implements PropertyProcessorInterface
{
    /**
     * @param iterable<PropertyProcessorInterface> $validatorProcessor
     */
    public function __construct(
        private iterable $validatorProcessor
    ) {
    }

    public function process(PropertyDefinition $propertyDefinition, ClassDefinition $classDefinition, array $propertyData, array $classList): void
    {
        if (!\array_key_exists('validation', $propertyData)) {
            return;
        }

        $propertyValidationConstraints = $propertyData['validation'];
        foreach ($propertyValidationConstraints as $constraint) {
            $this->processAddConstraints($propertyDefinition, $classDefinition, $constraint, $classList);
        }
    }

    /**
     * @param PropertyDefinition          $propertyDefinition
     * @param ClassDefinition             $classDefinition
     * @param array<array<string, mixed>> $constraints
     * @param string[]                    $classList
     *
     * @return void
     */
    protected function processAddConstraints(PropertyDefinition $propertyDefinition, ClassDefinition $classDefinition, array $constraints, array $classList): void
    {
        foreach ($constraints as $constraintName => $constraintConfig) {
            foreach ($this->validatorProcessor as $processor) {
                /**
                 * @phpstan-ignore-next-line
                 *
                 * @psalm-suppress InvalidArrayOffset
                 */
                $processor->process($propertyDefinition, $classDefinition, [$constraintName => $constraintConfig[0]], $classList);
            }
        }
    }
}

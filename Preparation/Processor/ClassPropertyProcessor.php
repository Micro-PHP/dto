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

namespace Micro\Library\DTO\Preparation\Processor;

use Micro\Library\DTO\ClassDef\ClassDefinition;
use Micro\Library\DTO\ClassDef\PropertyDefinition;
use Micro\Library\DTO\Preparation\PreparationProcessorInterface;
use Micro\Library\DTO\Preparation\Processor\Property\PropertyProcessorInterface;

readonly class ClassPropertyProcessor implements PreparationProcessorInterface
{
    /**
     * @param iterable<PropertyProcessorInterface> $propertyProcessorCollection
     */
    public function __construct(private iterable $propertyProcessorCollection)
    {
    }

    public function process(array $classDef, ClassDefinition $classDefinition, array $classList): void
    {
        foreach ($classDef[self::SECTION_PROPERTIES] as $property) {
            $this->processProperty($classDefinition, $property, $classList);
        }
    }

    /**
     * @param array<string, mixed> $propertyData
     * @param array<string>        $classList
     */
    protected function processProperty(ClassDefinition $classDefinition, array $propertyData, array $classList): void
    {
        $property = new PropertyDefinition();
        $classDefinition->addProperty($property);

        foreach ($this->propertyProcessorCollection as $processor) {
            $processor->process($property, $classDefinition, $propertyData, $classList);
        }
    }
}

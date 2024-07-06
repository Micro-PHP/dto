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
use Micro\Library\DTO\Object\Collection;
use Micro\Library\DTO\Preparation\PreparationProcessorInterface;

class PropertyCollectionProcessor implements PropertyProcessorInterface
{
    /**
     * @param array<string, mixed> $propertyData
     * @param array<string>        $classList
     */
    public function process(
        PropertyDefinition $propertyDefinition,
        ClassDefinition $classDefinition,
        array $propertyData,
        array $classList
    ): void {
        $isCollection = $propertyData[PreparationProcessorInterface::PROP_TYPE_IS_COLLECTION] ?? false;
        $isRequired = $propertyDefinition->isRequired();
        if (!$isCollection) {
            return;
        }

        // $propTypes = $propertyDefinition->getTypes();
        $types = [
            'iterable',
        ];

        if (!$isRequired) {
            $types[] = 'null';
        }

        $propertyDefinition->setTypes($types);
        $propertyDefinition->setIsCollection(true);

        $classDefinition->addUseStatement(Collection::class);
    }
}

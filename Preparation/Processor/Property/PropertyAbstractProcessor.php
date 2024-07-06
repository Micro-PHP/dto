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
use Micro\Library\DTO\Helper\ClassMetadataHelperInterface;

class PropertyAbstractProcessor implements PropertyProcessorInterface
{
    public function process(
        PropertyDefinition $propertyDefinition,
        ClassDefinition $classDefinition,
        array $propertyData,
        array $classList
    ): void {
        $types = $propertyDefinition->getTypes();

        foreach ($types as $pos => $type) {
            if (mb_strtolower($type) !== mb_strtolower(ClassMetadataHelperInterface::PROPERTY_TYPE_ABSTRACT)) {
                continue;
            }

            $types[$pos] = ClassMetadataHelperInterface::PROPERTY_TYPE_ABSTRACT_CLASS;
            $classDefinition->addUseStatement(ClassMetadataHelperInterface::PROPERTY_TYPE_ABSTRACT_CLASS);
        }

        $propertyDefinition->setTypes(array_unique($types));
    }
}

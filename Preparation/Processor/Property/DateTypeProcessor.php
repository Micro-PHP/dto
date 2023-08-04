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

class DateTypeProcessor implements PropertyProcessorInterface
{
    public const DATE_TYPES = [
        'date', 'datetime',
    ];

    public function process(PropertyDefinition $propertyDefinition, ClassDefinition $classDefinition, array $propertyData, array $classList): void
    {
        $types = $propertyDefinition->getTypes();

        foreach ($types as $pos => $type) {
            if (!\in_array($type, self::DATE_TYPES)) {
                continue;
            }

            $types[$pos] = \DateTimeInterface::class;
        }

        $propertyDefinition->setTypes(array_unique($types));
        $classDefinition->addUseStatement('\DateTimeInterface');
    }
}

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

interface PropertyProcessorInterface
{
    /**
     * @param PropertyDefinition   $propertyDefinition
     * @param ClassDefinition      $classDefinition
     * @param array<string, mixed> $propertyData
     * @param string[]             $classList
     *
     * @return void
     */
    public function process(PropertyDefinition $propertyDefinition, ClassDefinition $classDefinition, array $propertyData, array $classList): void;
}

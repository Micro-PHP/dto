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
use Micro\Library\DTO\Helper\ClassMetadataHelperInterface;
use Micro\Library\DTO\Preparation\PreparationProcessorInterface;

readonly class ClassNameProcessor implements PreparationProcessorInterface
{
    public function __construct(
        private ClassMetadataHelperInterface $classMetadataHelper
    ) {
    }

    public function process(array $classDef, ClassDefinition $classDefinition, array $classList): void
    {
        $className = $classDef[self::CLASS_NAME];

        $classDefinition->setName($this->classMetadataHelper->generateClassnameShort($className));
        $classDefinition->setNamespace($this->classMetadataHelper->generateNamespace($className));
    }
}

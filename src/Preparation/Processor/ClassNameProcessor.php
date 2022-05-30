<?php

namespace Micro\Library\DTO\Preparation\Processor;

use Micro\Library\DTO\ClassDef\ClassDefinition;
use Micro\Library\DTO\Helper\ClassMetadataHelperInterface;
use Micro\Library\DTO\Preparation\PreparationProcessorInterface;

class ClassNameProcessor implements PreparationProcessorInterface
{
    public function __construct(private readonly ClassMetadataHelperInterface $classMetadataHelper)
    {

    }

    public function process(iterable $classDef, ClassDefinition $classDefinition, array $classList): void
    {
        $className = $classDef[self::CLASS_NAME];

        $classDefinition->setName($this->classMetadataHelper->generateClassnameShort($className));
        $classDefinition->setNamespace($this->classMetadataHelper->generateNamespace($className));
    }
}
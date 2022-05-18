<?php

namespace Micro\Library\DTO\Preparation\Processor;

use Micro\Library\DTO\Helper\ClassMetadataHelper;
use Micro\Library\DTO\Preparation\PreparationProcessorInterface;

class NamespaceProcessor implements PreparationProcessorInterface
{
    public function __construct(private readonly ClassMetadataHelper $classMetaHelper)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function processClassCollection(iterable &$classDef): void
    {
        $className = $classDef['name'];

        $classDef['name'] = $this->classMetaHelper->generateClassnameShort($className);
        $classDef['namespace'] = $this->classMetaHelper->generateNamespace($className);
        $classDef['fullName'] = $this->classMetaHelper->generateClassname($className);
    }
}
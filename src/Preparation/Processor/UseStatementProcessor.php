<?php

namespace Micro\Library\DTO\Preparation\Processor;

use Micro\Library\DTO\Helper\ClassMetadataHelper;
use Micro\Library\DTO\Preparation\PreparationProcessorInterface;

class UseStatementProcessor implements PreparationProcessorInterface
{
    /**
     * @param ClassMetadataHelper $classMetadataHelper
     */
    public function __construct(private readonly ClassMetadataHelper $classMetadataHelper)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function processClassCollection(iterable &$classDef): void
    {
        if(!is_array($classDef) || !array_key_exists('properties', $classDef)) {
            return;
        }

        $useStatements = [];

        foreach ($classDef['properties'] as &$propDef) {
            $propType = $propDef['type'];
            if(!preg_match('%^\p{Lu}%u', $propType)) {
                continue;
            }

            $propNamespace = $this->classMetadataHelper->generateNamespace($propType);
            $useStatement = $this->classMetadataHelper->generateClassname($propType);
            $propDef['type'] = $this->classMetadataHelper->generateClassnameShort($propType);
            $propDef['dto'] = $useStatement;

            if($classDef['namespace'] === $propNamespace) {
                continue;
            }

            $useStatements[] = $useStatement;
        }

        $classDef['useStatements'] = array_unique($useStatements);
    }
}
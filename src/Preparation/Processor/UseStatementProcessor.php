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
     * @param array $classCollection
     *
     * @return array
     */
    public function processClassCollection(array $classCollection): array
    {
        $result = [];

        foreach ($classCollection as $classDef) {
            $result[] = $this->resolveUseStatements($classDef);
        }

        return $result;
    }

    /**
     * @param array $classDef
     *
     * @return array
     */
    protected function resolveUseStatements(array $classDef): array
    {
        if(!array_key_exists('properties', $classDef)) {
            return $classDef;
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

            if($classDef['namespace'] === $propNamespace) {
                continue;
            }

            $useStatements[] = $useStatement;
        }

        $classDef['useStatements'] = array_unique($useStatements);

        return $classDef;
    }
}
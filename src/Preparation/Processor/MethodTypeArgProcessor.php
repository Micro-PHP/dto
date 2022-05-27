<?php

namespace Micro\Library\DTO\Preparation\Processor;

use Micro\Library\DTO\Preparation\PreparationProcessorInterface;

class MethodTypeArgProcessor implements PreparationProcessorInterface
{

    public function processClassCollection(iterable &$classDef): void
    {
        foreach ($classDef[self::SECTION_PROPERTIES] as &$propDef) {
            $isCollection = $propDef[self::PROP_TYPE_IS_COLLECTION] ?? false;
            $methodType = $propDef[self::PROP_TYPE_FULLNAME];
            $methodTypeArg = $isCollection ? 'array' : $methodType;
            $isRequired = $propDef[self::PROP_REQUIRED] ?? false;
            if($isRequired && $propDef[self::PROP_TYPE_FULLNAME] !== 'mixed') {
                $methodTypeArg .= '|null';
            }

            $propDef[self::METHOD_GET_RETURN_TYPE] = $methodTypeArg;
            $propDef[self::METHOD_TYPE_ARG] = $methodTypeArg;
        }
    }
}
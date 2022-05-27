<?php

namespace Micro\Library\DTO\Preparation\Processor;

use Micro\Library\DTO\Preparation\PreparationProcessorInterface;

class MethodsBodyProcessor implements PreparationProcessorInterface
{

    public function processClassCollection(iterable &$classDef): void
    {
        foreach ($classDef[self::SECTION_PROPERTIES] as &$propDef) {
            $propertyName = $propDef[self::PROP_NAME];
            $propDef[self::METHOD_GET_BODY] = sprintf('return $this->%s;', $propertyName);
            $propDef[self::METHOD_SET_BODY] = sprintf("\$this->%s = \$%s;\r\n\r\n return \$this;", $propertyName, $propertyName);
        }
    }
}
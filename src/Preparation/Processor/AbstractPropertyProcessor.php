<?php

namespace Micro\Library\DTO\Preparation\Processor;

use Micro\Library\DTO\Helper\ClassMetadataHelperInterface;
use Micro\Library\DTO\Preparation\PreparationProcessorInterface;

class AbstractPropertyProcessor implements PreparationProcessorInterface
{
    /**
     * {@inheritDoc}
     */
    public function processClassCollection(iterable &$classDef): void
    {
        foreach ($classDef['properties'] as &$property) {
            $propType = mb_strtolower(trim($property['type']));
            if($propType !== ClassMetadataHelperInterface::PROPERTY_TYPE_ABSTRACT) {
                continue;
            }

            $property['type'] = ClassMetadataHelperInterface::PROPERTY_TYPE_ABSTRACT_CLASS;
            $property['dto'] = ClassMetadataHelperInterface::PROPERTY_TYPE_ABSTRACT_CLASS;
        }
    }
}
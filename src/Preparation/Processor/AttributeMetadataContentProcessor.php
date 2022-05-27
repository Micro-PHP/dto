<?php

namespace Micro\Library\DTO\Preparation\Processor;

use Micro\Library\DTO\Preparation\PreparationProcessorInterface;

class AttributeMetadataContentProcessor implements PreparationProcessorInterface
{
    /**
     * {@inheritDoc}
     */
    public function processClassCollection(iterable &$classDef): void
    {
        $meta = [];
        foreach ($classDef[self::SECTION_PROPERTIES] as $propDef) {
            $propertyMeta = [];
            $propertyMeta[self::PROP_TYPE_IS_COLLECTION] = $propDef[self::PROP_TYPE_IS_COLLECTION] ?? false;
            $propertyMeta[self::PROP_TYPE] = $propDef[self::PROP_TYPE];
            $propertyMeta[self::PROP_ACTION_NAME] = $propDef[self::PROP_ACTION_NAME];
            $propertyMeta[self::PROP_REQUIRED] = $propDef[self::PROP_REQUIRED] ?? false;

            $meta[$propDef[self::PROP_NAME]] = $propertyMeta;
        }

        $classDef[self::CLASS_PROPS_META] = $meta;
    }
}
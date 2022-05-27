<?php

namespace Micro\Library\DTO\Preparation\Processor;

use Micro\Library\DTO\Preparation\PreparationProcessorInterface;

class DateTimePropertyProcessor implements PreparationProcessorInterface
{
    /**
     * {@inheritDoc}
     */
    public function processClassCollection(iterable &$classDef): void
    {
        foreach ($classDef[self::SECTION_PROPERTIES] as &$property) {
            $propType = $property[self::PROP_TYPE];

            if(!$this->isDateTimeProperty($propType)) {
                continue;
            }

            $property[self::PROP_TYPE] = \DateTime::class;
            $classDef[self::CLASS_USE_STATEMENTS][] = '\DateTime';
        }

        $classDef[self::CLASS_USE_STATEMENTS] = array_unique($classDef[self::CLASS_USE_STATEMENTS]);
    }

    /**
     * @param string $propertyType
     *
     * @return bool
     */
    protected function isDateTimeProperty(string $propertyType)
    {
        return in_array(mb_strtolower($propertyType), [
            'date', 'datetime'
        ]);
    }
}
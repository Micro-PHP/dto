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
        foreach ($classDef['properties'] as &$property) {
            $propType = $property['type'];

            if(!$this->isDateTimeProperty($propType)) {
                continue;
            }

            $property['type'] = \DateTime::class;
            $property['dto'] = \DateTime::class;
            $classDef['useStatements'][] = '\DateTime';
        }

        $classDef['useStatements'] = array_unique($classDef['useStatements']);

        var_dump($classDef);
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
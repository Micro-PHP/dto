<?php

namespace Micro\Library\DTO\Preparation\Processor;

use Micro\Library\DTO\Preparation\PreparationProcessorInterface;

class MergerClassProcessor implements PreparationProcessorInterface
{
    /**
     * {@inheritDoc}
     */
    public function processClassCollection(array $classCollection): array
    {
        $preparedClassCollection = $this->sortClassCollectionByName($classCollection);
        $response = [];

        foreach ($preparedClassCollection as $className => $classData) {
            if(count($classData) === 1) {
                $response[] = $classData[0];

                continue;
            }

            $response[] = $this->mergeClass($className, $classData);
        }


        return $response;
    }

    /**
     * @param string $className
     * @param array $classData
     *
     * @return array
     */
    protected function mergeClass(string $className, array $classData): array
    {
        $properties = [];

        foreach ($classData as $declaration) {
            if(!array_key_exists('properties', $declaration)) {
                continue;
            }

            foreach ($declaration['properties'] as $propName => $propertyDef) {
                if(!in_array($propName, $properties)) {
                    $properties[$propName] = $propertyDef;

                    continue;
                }

                throw new \RuntimeException(sprintf('Property "%s" already declared in %s', $propName, $className));
            }
        }

        return [
            'name'  => $className,
            'properties' => $properties,
        ];
    }

    /**
     * @param array $classCollection
     * @return array
     */
    protected function sortClassCollectionByName(array $classCollection): array
    {
        $collectionPrepared = [];

        foreach ($classCollection as $item) {
            $className = $item['name'];

            if(!array_key_exists($className, $collectionPrepared)) {
                $collectionPrepared[$className] = [];
            }

            $collectionPrepared[$className][] = $item;
        }

        return $collectionPrepared;
    }
}
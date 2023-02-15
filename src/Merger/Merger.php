<?php

namespace Micro\Library\DTO\Merger;

class Merger implements MergerInterface
{
    /**
     * @param iterable $classCollection
     */
    public function __construct(private readonly iterable $classCollection)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function merge(): iterable
    {
        $preparedClassCollection = $this->sortClassCollectionByName($this->classCollection);

        foreach ($preparedClassCollection as $className => $classData) {
            if(count($classData) === 1) {
                yield $classData[0];

                continue;
            }

            yield $this->mergeClass($className, $classData);
        }
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
                if(!array_key_exists($propName, $properties)) {
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
     * @param iterable $classCollection
     * @return array
     */
    protected function sortClassCollectionByName(iterable $classCollection): array
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
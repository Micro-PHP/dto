<?php

declare(strict_types=1);

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Library\DTO\Merger;

class Merger implements MergerInterface
{
    /**
     * @param array<int, mixed> $classCollection
     */
    public function __construct(private array $classCollection)
    {
    }

    public function merge(): \Generator
    {
        $preparedClassCollection = $this->sortClassCollectionByName($this->classCollection);

        foreach ($preparedClassCollection as $className => $classData) {
            if (1 === \count($classData)) {
                yield $classData[0];

                continue;
            }

            yield $this->mergeClass($className, $classData);
        }
    }

    /**
     * @param string               $className
     * @param array<string, mixed> $classData
     *
     * @return array<string, mixed>
     */
    protected function mergeClass(string $className, array $classData): array
    {
        $properties = [];

        foreach ($classData as $declaration) {
            if (!\array_key_exists('properties', $declaration)) {
                continue;
            }

            foreach ($declaration['properties'] as $propName => $propertyDef) {
                if (!\array_key_exists($propName, $properties)) {
                    $properties[$propName] = $propertyDef;

                    continue;
                }

                throw new \RuntimeException(sprintf('Property "%s" already declared in %s', $propName, $className));
            }
        }

        return [
            'name' => $className,
            'properties' => $properties,
        ];
    }

    /**
     * @param iterable<int, mixed> $classCollection
     *
     * @return array<string, mixed>
     */
    protected function sortClassCollectionByName(iterable $classCollection): array
    {
        $collectionPrepared = [];

        foreach ($classCollection as $item) {
            $className = $item['name'];

            if (!\array_key_exists($className, $collectionPrepared)) {
                $collectionPrepared[$className] = [];
            }

            $collectionPrepared[$className][] = $item;
        }

        return $collectionPrepared; // @phpstan-ignore-line
    }
}

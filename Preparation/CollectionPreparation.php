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

namespace Micro\Library\DTO\Preparation;

use Micro\Library\DTO\ClassDef\ClassDefinition;
use Micro\Library\DTO\Reader\ReaderInterface;

readonly class CollectionPreparation implements CollectionPreparationInterface
{
    /**
     * @param iterable<PreparationProcessorInterface> $preparationProcessor
     */
    public function __construct(
        private iterable $preparationProcessor
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function process(ReaderInterface $reader): iterable
    {
        $classCollection = $reader->read();
        if ($classCollection instanceof \Traversable) {
            $classCollection = iterator_to_array($classCollection);
        }

        $classList = $this->createClassList($classCollection);

        foreach ($classCollection as $classDef) {
            $classDefObj = new ClassDefinition();
            foreach ($this->preparationProcessor as $processor) {
                $processor->process($classDef, $classDefObj, $classList);
            }

            yield $classDefObj;
        }
    }

    /**
     * @param array<string, mixed> $classes
     *
     * @return array<class-string>
     */
    protected function createClassList(array $classes): array
    {
        $result = [];
        foreach ($classes as $classDef) {
            $result[] = $classDef[PreparationProcessorInterface::CLASS_NAME];
        }

        return $result;
    }
}

<?php

namespace Micro\Library\DTO\Preparation;

use Micro\Library\DTO\Reader\ReaderInterface;

class ClassCollectionPreparation implements ClassCollectionPreparationInterface
{
    /**
     * @param iterable<PreparationProcessorInterface> $preparationProcessor
     */
    public function __construct(private readonly iterable $preparationProcessor)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function process(ReaderInterface $reader): iterable
    {
        $classCollection = $reader->read();
        foreach ($classCollection as $className => $classDef) {
            foreach ($this->preparationProcessor as $processor) {
                $processor->processClassCollection($classDef);
            }

            yield $classDef;
        }
    }
}
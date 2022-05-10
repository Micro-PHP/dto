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

        foreach ($this->preparationProcessor as $processor) {
            $classCollection = $processor->processClassCollection($classCollection);
        }

        return $classCollection;
    }
}
<?php

namespace Micro\Library\DTO\Preparation;

use Micro\Library\DTO\ClassDef\ClassDefinition;
use Micro\Library\DTO\Reader\ReaderInterface;

class CollectionPreparation implements CollectionPreparationInterface
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
        $classCollection = iterator_to_array($reader->read());
        $classList = $this->createClassList($classCollection);

        foreach ($classCollection as $className => $classDef) {
            $classDefObj = new ClassDefinition();
            foreach ($this->preparationProcessor as $processor) {
                $processor->process($classDef, $classDefObj, $classList);
            }

            yield $classDefObj;
        }
    }

    protected function createClassList(array $classes): array
    {
        $result = [];
        foreach ($classes as $classDef) {
            $result[] = $classDef[PreparationProcessorInterface::CLASS_NAME];
        }

        return $result;
    }
}
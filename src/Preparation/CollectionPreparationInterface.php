<?php

namespace Micro\Library\DTO\Preparation;

use Micro\Library\DTO\ClassDef\ClassDefinition;
use Micro\Library\DTO\Reader\ReaderInterface;

interface CollectionPreparationInterface
{
    /**
     * @param ReaderInterface $reader
     * @return iterable<ClassDefinition>
     */
    public function process(ReaderInterface $reader): iterable;
}
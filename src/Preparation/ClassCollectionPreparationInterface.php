<?php

namespace Micro\Library\DTO\Preparation;

use Micro\Library\DTO\Definition\DefinitionClass;
use Micro\Library\DTO\Reader\ReaderInterface;

interface ClassCollectionPreparationInterface
{
    /**
     * @param ReaderInterface $reader
     * @return iterable<DefinitionClass>
     */
    public function process(ReaderInterface $reader): iterable;
}
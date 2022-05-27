<?php

namespace Micro\Library\DTO\Preparation;

use Micro\Library\DTO\Reader\ReaderInterface;

interface ClassCollectionPreparationInterface
{
    /**
     * @param ReaderInterface $reader
     * @return iterable<array>
     */
    public function process(ReaderInterface $reader): iterable;
}
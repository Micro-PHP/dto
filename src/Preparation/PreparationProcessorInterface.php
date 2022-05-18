<?php

namespace Micro\Library\DTO\Preparation;

interface PreparationProcessorInterface
{
    /**
     * @param iterable $classDef
     *
     * @return void
     */
    public function processClassCollection(iterable &$classDef): void;
}
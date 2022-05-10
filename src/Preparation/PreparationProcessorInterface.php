<?php

namespace Micro\Library\DTO\Preparation;

interface PreparationProcessorInterface
{
    /**
     * @param array $classCollection
     *
     * @return array
     */
    public function processClassCollection(array $classCollection): array;
}
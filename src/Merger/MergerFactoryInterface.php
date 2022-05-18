<?php

namespace Micro\Library\DTO\Merger;


interface MergerFactoryInterface
{
    /**
     * @param iterable $classCollection
     *
     * @return MergerInterface
     */
    public function create(iterable $classCollection): MergerInterface;
}
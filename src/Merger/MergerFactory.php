<?php

namespace Micro\Library\DTO\Merger;

class MergerFactory implements MergerFactoryInterface
{
    /**
     * @param iterable $classCollection
     *
     * @return MergerInterface
     */
    public function create(iterable $classCollection): MergerInterface
    {
        return new Merger($classCollection);
    }
}
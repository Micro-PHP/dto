<?php

namespace Micro\Library\DTO\Merger;

interface MergerInterface
{
    /**
     * @return array
     */
    public function merge(): iterable;
}
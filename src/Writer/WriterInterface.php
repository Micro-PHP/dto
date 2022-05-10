<?php

namespace Micro\Library\DTO\Writer;

interface WriterInterface
{
    /**
     * @param string $classnameFull
     * @param string $renderedClassData
     *
     * @return void
     */
    public function write(string $classnameFull, string $renderedClassData): void;
}
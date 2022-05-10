<?php

namespace Micro\Library\DTO\View;

interface RendererInterface
{
    /**
     * @param array $classData
     *
     * @return string
     */
    public function render(array $classData): string;
}
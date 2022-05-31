<?php

namespace Micro\Library\DTO\View;

use Micro\Library\DTO\ClassDef\ClassDefinition;

interface RendererInterface
{
    /**
     * @param ClassDefinition $classDefinition
     *
     * @return string
     */
    public function render(ClassDefinition $classDefinition): string;
}
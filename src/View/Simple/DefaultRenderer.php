<?php

namespace Micro\Library\DTO\View\Simple;

use Micro\Library\DTO\View\RendererInterface;

class DefaultRenderer implements RendererInterface
{
    public function __toString(): string
    {
    }

    public function render(array $classData): string
    {
        // TODO: Implement render() method.
    }
}
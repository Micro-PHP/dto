<?php

namespace Micro\Library\DTO\Generator;

use Micro\Library\DTO\Preparation\ClassCollectionPreparationInterface;
use Micro\Library\DTO\Reader\ReaderInterface;
use Micro\Library\DTO\View\RendererInterface;
use Micro\Library\DTO\Writer\WriterInterface;

class Generator
{
    public function __construct(
        private readonly ReaderInterface $reader,
        private readonly WriterInterface $writer,
        private readonly RendererInterface $renderer,
        private readonly ClassCollectionPreparationInterface $classCollectionPreparation
    )
    {
    }

    /**
     * Generate class
     *
     * @return void
     */
    public function generate(): void
    {
        foreach ($this->classCollectionPreparation->process($this->reader) as $classDef) {
            $classRendered = $this->renderer->render($classDef);

            $this->writer->write($classDef['fullName'], $classRendered);
        }
    }
}
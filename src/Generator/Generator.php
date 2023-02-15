<?php

namespace Micro\Library\DTO\Generator;

use Micro\Library\DTO\ClassDef\ClassDefinition;
use Micro\Library\DTO\Preparation\CollectionPreparationInterface;
use Micro\Library\DTO\Reader\ReaderInterface;
use Micro\Library\DTO\View\RendererInterface;
use Micro\Library\DTO\Writer\WriterInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

class Generator
{
    public function __construct(
        private readonly ReaderInterface                $reader,
        private readonly WriterInterface                $writer,
        private readonly RendererInterface              $renderer,
        private readonly CollectionPreparationInterface $classCollectionPreparation,
        private readonly LoggerInterface                $logger
    )
    {
    }

    /**
     * @return void
     */
    public function generate(): void
    {
        /** @var ClassDefinition $classDef */
        foreach ($this->classCollectionPreparation->process($this->reader) as $classDef) {
            $classRendered = $this->renderer->render($classDef);
            $classname = $classDef->getNamespace() . '\\' . $classDef->getName();

            $this->writer->write($classname, $classRendered);
            $this->logger->debug(sprintf('Generated class "%s"', $classname));
        }
    }
}
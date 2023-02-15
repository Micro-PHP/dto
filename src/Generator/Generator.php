<?php

namespace Micro\Library\DTO\Generator;

use Micro\Library\DTO\ClassDef\ClassDefinition;
use Micro\Library\DTO\Preparation\CollectionPreparationInterface;
use Micro\Library\DTO\Reader\ReaderInterface;
use Micro\Library\DTO\View\RendererInterface;
use Micro\Library\DTO\Writer\WriterInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

readonly class Generator
{
    public function __construct(
        private ReaderInterface                $reader,
        private WriterInterface                $writer,
        private RendererInterface              $renderer,
        private CollectionPreparationInterface $classCollectionPreparation,
        private LoggerInterface                $logger
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
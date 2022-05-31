<?php

namespace Micro\Library\DTO;

use Micro\Library\DTO\Helper\ClassMetadataHelper;
use Micro\Library\DTO\Preparation\CollectionPreparationInterface;
use Micro\Library\DTO\Reader\ReaderInterface;
use Micro\Library\DTO\View\RendererInterface;
use Micro\Library\DTO\Writer\WriterInterface;
use Psr\Log\LoggerInterface;

interface DependencyInjectionInterface
{
    /**
     * @return LoggerInterface
     */
    public function getLogger(): LoggerInterface;

    /**
     * @return CollectionPreparationInterface
     */
    public function createClassPreparationProcessor(): CollectionPreparationInterface;

    /**
     * @return ClassMetadataHelper
     */
    public function createClassMetadataHelper(): ClassMetadataHelper;

    /**
     * @return WriterInterface
     */
    public function createWriter(): WriterInterface;

    /**
     * @return ReaderInterface
     */
    public function createReader(): ReaderInterface;

    /**
     * @return RendererInterface
     */
    public function createRenderer(): RendererInterface;
}
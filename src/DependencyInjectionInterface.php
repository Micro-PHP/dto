<?php

namespace Micro\Library\DTO;

use Micro\Library\DTO\Helper\ClassMetadataHelper;
use Micro\Library\DTO\Preparation\ClassCollectionPreparationInterface;
use Micro\Library\DTO\Reader\ReaderInterface;
use Micro\Library\DTO\View\RendererInterface;
use Micro\Library\DTO\Writer\WriterInterface;

interface DependencyInjectionInterface
{
    /**
     * @return ClassCollectionPreparationInterface
     */
    public function createClassPreparationProcessor(): ClassCollectionPreparationInterface;

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
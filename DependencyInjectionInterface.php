<?php

declare(strict_types=1);

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Library\DTO;

use Micro\Library\DTO\Helper\ClassMetadataHelper;
use Micro\Library\DTO\Preparation\CollectionPreparationInterface;
use Micro\Library\DTO\Reader\ReaderInterface;
use Micro\Library\DTO\View\RendererInterface;
use Micro\Library\DTO\Writer\WriterInterface;
use Psr\Log\LoggerInterface;

interface DependencyInjectionInterface
{
    public function getLogger(): LoggerInterface;

    public function createClassPreparationProcessor(): CollectionPreparationInterface;

    public function createClassMetadataHelper(): ClassMetadataHelper;

    public function createWriter(): WriterInterface;

    public function createReader(): ReaderInterface;

    public function createRenderer(): RendererInterface;
}

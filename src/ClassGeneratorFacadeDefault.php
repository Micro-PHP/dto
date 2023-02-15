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

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

class ClassGeneratorFacadeDefault extends GeneratorFacade
{
    /**
     * @param array<string>        $filesSchemeCollection
     * @param string               $outputPath
     * @param string               $namespaceGeneral
     * @param string               $classSuffix
     * @param LoggerInterface|null $logger
     */
    public function __construct(
        private readonly array $filesSchemeCollection,
        private readonly string $outputPath,
        private readonly string $namespaceGeneral = '',
        private readonly string $classSuffix = 'Transfer',
        private readonly null|LoggerInterface $logger = new NullLogger(),
    ) {
        parent::__construct($this->createDefaultDependencyInjectionObject());
    }

    /**
     * @return DependencyInjectionInterface
     */
    protected function createDefaultDependencyInjectionObject(): DependencyInjectionInterface
    {
        return new DependencyInjection(
            $this->filesSchemeCollection,
            $this->namespaceGeneral,
            $this->classSuffix,
            $this->outputPath,
            $this->logger
        );
    }
}

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
        private array $filesSchemeCollection,
        private string $outputPath,
        private string $namespaceGeneral = '',
        private string $classSuffix = 'Transfer',
        private null|LoggerInterface $logger = null
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

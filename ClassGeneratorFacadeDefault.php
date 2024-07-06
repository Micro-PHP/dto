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
     * @param array<string>    $filesSchemeCollection
     */
    public function __construct(
        private readonly array $filesSchemeCollection,
        private readonly string $outputPath,
        private readonly string $namespaceGeneral = '',
        private readonly string $classSuffix = 'Transfer',
        private readonly ?LoggerInterface $logger = null
    ) {
        parent::__construct($this->createDefaultDependencyInjectionObject());
    }

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

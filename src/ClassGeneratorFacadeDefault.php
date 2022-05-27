<?php

namespace Micro\Library\DTO;


use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

class ClassGeneratorFacadeDefault extends GeneratorFacade
{
    /**
     * @param array $filesSchemeCollection
     * @param string $outputPath
     * @param string $namespaceGeneral
     * @param string $classSuffix
     * @param LoggerInterface|null $logger
     */
    public function __construct(
        private readonly array $filesSchemeCollection,
        private readonly string $outputPath,
        private readonly string $namespaceGeneral = '',
        private readonly string $classSuffix = 'Transfer',
        private readonly null|LoggerInterface $logger = new NullLogger(),
    )
    {
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
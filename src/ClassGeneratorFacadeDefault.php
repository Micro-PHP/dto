<?php

namespace Micro\Library\DTO;


class ClassGeneratorFacadeDefault extends GeneratorFacade
{
    /**
     * @param string $outputPath
     *
     * @param string $namespaceGeneral
     */
    public function __construct(
        private readonly array $filesSchemeCollection,
        private readonly string $outputPath,
        private readonly string $namespaceGeneral = ''
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
            $this->outputPath
        );
    }
}
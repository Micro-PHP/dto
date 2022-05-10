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
        private readonly string $namespaceGeneral = '',
        private readonly string $templatePath = __DIR__ .  DIRECTORY_SEPARATOR . 'Resource' . DIRECTORY_SEPARATOR . 'view',
        private readonly string $templateName = 'class.php.twig',
        private readonly string $classSuffix = 'Transfer'
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
            $this->templatePath,
            $this->templateName
        );
    }
}
<?php

namespace Micro\Library\DTO;

use Micro\Library\DTO\Helper\ClassMetadataHelper;
use Micro\Library\DTO\Merger\MergerFactory;
use Micro\Library\DTO\Preparation\ClassCollectionPreparation;
use Micro\Library\DTO\Preparation\ClassCollectionPreparationInterface;
use Micro\Library\DTO\Preparation\Processor\DateTimePropertyProcessor;
use Micro\Library\DTO\Preparation\Processor\NamespaceProcessor;
use Micro\Library\DTO\Preparation\Processor\PropertyProcessor;
use Micro\Library\DTO\Preparation\Processor\UseStatementProcessor;
use Micro\Library\DTO\Reader\ReaderInterface;
use Micro\Library\DTO\Reader\XmlReader;
use Micro\Library\DTO\View\RendererInterface;
use Micro\Library\DTO\View\Twig\TwigRenderer;
use Micro\Library\DTO\Writer\WriterFilesystem;
use Micro\Library\DTO\Writer\WriterInterface;
use Twig\Environment;

class DependencyInjection implements DependencyInjectionInterface
{
    /**
     * @param string $namespaceGeneral
     */
    public function __construct(
        private readonly array $filesSchemeCollection,
        private readonly string $namespaceGeneral,
        private readonly string $classSuffix,
        private readonly string $outputPath,
        private readonly string $templatePath,
        private readonly string $classTemplateName
    )
    {
    }



    /**
     * {@inheritDoc}
     */
    public function createClassPreparationProcessor(): ClassCollectionPreparationInterface
    {
        return new ClassCollectionPreparation($this->createPreparationProcessorCollection());
    }

    /**
     * {@inheritDoc}
     */
    public function createReader(): ReaderInterface
    {
        return new XmlReader(
            $this->filesSchemeCollection,
            new MergerFactory()
        );
    }

    /**
     * {@inheritDoc}
     */
    public function createClassMetadataHelper(): ClassMetadataHelper
    {
        return new ClassMetadataHelper($this->namespaceGeneral, $this->classSuffix);
    }

    /**
     * {@inheritDoc}
     */
    protected function createPreparationProcessorCollection(): iterable
    {
        $classMetadataHelper = $this->createClassMetadataHelper();

        return [
            new NamespaceProcessor($classMetadataHelper),
            new UseStatementProcessor($classMetadataHelper),
            new PropertyProcessor(),
            new DateTimePropertyProcessor(),
        ];
    }
    /**
     * {@inheritDoc}
     */
    public function createWriter(): WriterInterface
    {
        return new WriterFilesystem(
            $this->outputPath,
            $this->namespaceGeneral
        );
    }

    /**
     * @return RendererInterface
     */
    public function createRenderer(): RendererInterface
    {
        $loader = new \Twig\Loader\FilesystemLoader($this->templatePath);

        $twig = new Environment($loader);

        return new TwigRenderer($twig, $this->classTemplateName);
    }
}
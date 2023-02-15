<?php

namespace Micro\Library\DTO;

use Micro\Library\DTO\Helper\CamelCaseNormalizer;
use Micro\Library\DTO\Helper\ClassMetadataHelper;
use Micro\Library\DTO\Helper\NameNormalizerInterface;
use Micro\Library\DTO\Merger\MergerFactory;
use Micro\Library\DTO\Preparation\CollectionPreparation;
use Micro\Library\DTO\Preparation\CollectionPreparationInterface;
use Micro\Library\DTO\Preparation\Processor\ClassCommentProcessor;
use Micro\Library\DTO\Preparation\Processor\ClassNameProcessor;
use Micro\Library\DTO\Preparation\Processor\ClassPropertyProcessor;
use Micro\Library\DTO\Preparation\Processor\MethodAttributesMetadataProcessor;
use Micro\Library\DTO\Preparation\Processor\MethodGetProcessor;
use Micro\Library\DTO\Preparation\Processor\MethodSetProcessor;
use Micro\Library\DTO\Preparation\Processor\Property\Assert\AssertBlankProcessor;
use Micro\Library\DTO\Preparation\Processor\Property\Assert\AssertEmailProcessor;
use Micro\Library\DTO\Preparation\Processor\Property\Assert\AssertHostnameProcessor;
use Micro\Library\DTO\Preparation\Processor\Property\Assert\AssertIpProcessor;
use Micro\Library\DTO\Preparation\Processor\Property\Assert\AssertJsonProcessor;
use Micro\Library\DTO\Preparation\Processor\Property\Assert\AssertLengthProcessor;
use Micro\Library\DTO\Preparation\Processor\Property\Assert\AssertNotBlankProcessor;
use Micro\Library\DTO\Preparation\Processor\Property\Assert\AssertRegexProcessor;
use Micro\Library\DTO\Preparation\Processor\Property\Assert\AssertUrlProcessor;
use Micro\Library\DTO\Preparation\Processor\Property\Assert\AssertUuidProcessor;
use Micro\Library\DTO\Preparation\Processor\Property\AttributeValidationProcessor;
use Micro\Library\DTO\Preparation\Processor\Property\CommentProcessor;
use Micro\Library\DTO\Preparation\Processor\Property\DateTypeProcessor;
use Micro\Library\DTO\Preparation\Processor\Property\DtoPropertyProcessor;
use Micro\Library\DTO\Preparation\Processor\Property\NameProcessor;
use Micro\Library\DTO\Preparation\Processor\Property\PropertyAbstractProcessor;
use Micro\Library\DTO\Preparation\Processor\Property\PropertyCollectionProcessor;
use Micro\Library\DTO\Preparation\Processor\Property\PropertyProcessorInterface;
use Micro\Library\DTO\Preparation\Processor\Property\PropertyRequiredProcessor;
use Micro\Library\DTO\Preparation\Processor\Property\TypeProcessor;
use Micro\Library\DTO\Preparation\Processor\Property\ValueProcessor;
use Micro\Library\DTO\Reader\ReaderInterface;
use Micro\Library\DTO\Reader\XmlReader;
use Micro\Library\DTO\View\Nette\NetteRenderer;
use Micro\Library\DTO\View\RendererInterface;
use Micro\Library\DTO\Writer\WriterFilesystem;
use Micro\Library\DTO\Writer\WriterInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

class DependencyInjection implements DependencyInjectionInterface
{
    /**
     * @param array $filesSchemeCollection
     * @param string $namespaceGeneral
     * @param string $classSuffix
     * @param string $outputPath
     * @param LoggerInterface|null $logger
     */
    public function __construct(
        private readonly array $filesSchemeCollection,
        private readonly string $namespaceGeneral,
        private readonly string $classSuffix,
        private readonly string $outputPath,
        private readonly ?LoggerInterface $logger
    )
    {
    }

    /**
     * {@inheritDoc}
     */
    public function getLogger(): LoggerInterface
    {
        return $this->logger ?? new NullLogger();
    }

    /**
     * {@inheritDoc}
     */
    public function createClassPreparationProcessor(): CollectionPreparationInterface
    {
        return new CollectionPreparation($this->createPreparationProcessorCollection());
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
     * @return NameNormalizerInterface
     */
    public function createCamelCaseProcessor(): NameNormalizerInterface
    {
        return new CamelCaseNormalizer();
    }

    /**
     * {@inheritDoc}
     */
    protected function createPreparationProcessorCollection(): iterable
    {
        $classMetadataHelper = $this->createClassMetadataHelper();
        $camelCaseHelper = $this->createCamelCaseProcessor();

        return [
            new ClassNameProcessor($classMetadataHelper),
            new ClassCommentProcessor(),
            new ClassPropertyProcessor([
                new NameProcessor(),
                new PropertyRequiredProcessor(),
                new TypeProcessor(),
                new DateTypeProcessor(),
                new DtoPropertyProcessor($classMetadataHelper),
                new PropertyAbstractProcessor(),
                new PropertyCollectionProcessor(),
                new ValueProcessor(),
                new CommentProcessor(),
                new AttributeValidationProcessor(
                    $this->createPropertyValidationProcessorCollection(),
                ),
            ]),
            new MethodGetProcessor($camelCaseHelper),
            new MethodSetProcessor($camelCaseHelper),
            new MethodAttributesMetadataProcessor($camelCaseHelper)
        ];
    }

    /**
     * @return iterable<PropertyProcessorInterface>
     */
    protected function createPropertyValidationProcessorCollection(): iterable
    {
        return [
            new AssertEmailProcessor(),
            new AssertIpProcessor(),
            new AssertHostnameProcessor(),
            new AssertRegexProcessor(),
            new AssertUrlProcessor(),
            new AssertLengthProcessor(),
            new AssertBlankProcessor(),
            new AssertNotBlankProcessor(),
            new AssertJsonProcessor(),
            new AssertUuidProcessor(),
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
        return new NetteRenderer(); //new TwigRenderer($twig, $this->classTemplateName);
    }
}
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

use Micro\Library\DTO\Helper\CamelCaseNormalizer;
use Micro\Library\DTO\Helper\ClassMetadataHelper;
use Micro\Library\DTO\Helper\NameNormalizerInterface;
use Micro\Library\DTO\Merger\MergerFactory;
use Micro\Library\DTO\Preparation\CollectionPreparation;
use Micro\Library\DTO\Preparation\CollectionPreparationInterface;
use Micro\Library\DTO\Preparation\PreparationProcessorInterface;
use Micro\Library\DTO\Preparation\Processor\ClassCommentProcessor;
use Micro\Library\DTO\Preparation\Processor\ClassNameProcessor;
use Micro\Library\DTO\Preparation\Processor\ClassPropertyProcessor;
use Micro\Library\DTO\Preparation\Processor\MethodAttributesMetadataProcessor;
use Micro\Library\DTO\Preparation\Processor\MethodGetProcessor;
use Micro\Library\DTO\Preparation\Processor\MethodSetProcessor;
use Micro\Library\DTO\Preparation\Processor\Property\Assert\BicStrategy;
use Micro\Library\DTO\Preparation\Processor\Property\Assert\BlankStrategy;
use Micro\Library\DTO\Preparation\Processor\Property\Assert\CardSchemeStrategy;
use Micro\Library\DTO\Preparation\Processor\Property\Assert\ChoiceStrategy;
use Micro\Library\DTO\Preparation\Processor\Property\Assert\CurrencyStrategy;
use Micro\Library\DTO\Preparation\Processor\Property\Assert\DateStrategy;
use Micro\Library\DTO\Preparation\Processor\Property\Assert\DateTimeStrategy;
use Micro\Library\DTO\Preparation\Processor\Property\Assert\EmailStrategy;
use Micro\Library\DTO\Preparation\Processor\Property\Assert\EqualToStrategy;
use Micro\Library\DTO\Preparation\Processor\Property\Assert\ExpressionStrategy;
use Micro\Library\DTO\Preparation\Processor\Property\Assert\GreaterThanOrEqualStrategy;
use Micro\Library\DTO\Preparation\Processor\Property\Assert\GreaterThanStrategy;
use Micro\Library\DTO\Preparation\Processor\Property\Assert\HostnameStrategy;
use Micro\Library\DTO\Preparation\Processor\Property\Assert\IbanStrategy;
use Micro\Library\DTO\Preparation\Processor\Property\Assert\IdenticalToStrategy;
use Micro\Library\DTO\Preparation\Processor\Property\Assert\IpStrategy;
use Micro\Library\DTO\Preparation\Processor\Property\Assert\IsbnStrategy;
use Micro\Library\DTO\Preparation\Processor\Property\Assert\IsinStrategy;
use Micro\Library\DTO\Preparation\Processor\Property\Assert\IssnStrategy;
use Micro\Library\DTO\Preparation\Processor\Property\Assert\JsonStrategy;
use Micro\Library\DTO\Preparation\Processor\Property\Assert\LengthStrategy;
use Micro\Library\DTO\Preparation\Processor\Property\Assert\LessThanOrEqualStrategy;
use Micro\Library\DTO\Preparation\Processor\Property\Assert\LessThanStrategy;
use Micro\Library\DTO\Preparation\Processor\Property\Assert\LuhnStrategy;
use Micro\Library\DTO\Preparation\Processor\Property\Assert\NegativeOrZeroStrategy;
use Micro\Library\DTO\Preparation\Processor\Property\Assert\NegativeStrategy;
use Micro\Library\DTO\Preparation\Processor\Property\Assert\NotBlankStrategy;
use Micro\Library\DTO\Preparation\Processor\Property\Assert\NotEqualToStrategy;
use Micro\Library\DTO\Preparation\Processor\Property\Assert\NotIdenticalToStrategy;
use Micro\Library\DTO\Preparation\Processor\Property\Assert\PositiveOrZeroStrategy;
use Micro\Library\DTO\Preparation\Processor\Property\Assert\PositiveStrategy;
use Micro\Library\DTO\Preparation\Processor\Property\Assert\RangeStrategy;
use Micro\Library\DTO\Preparation\Processor\Property\Assert\RegexStrategy;
use Micro\Library\DTO\Preparation\Processor\Property\Assert\TimeStrategy;
use Micro\Library\DTO\Preparation\Processor\Property\Assert\TimeZoneStrategy;
use Micro\Library\DTO\Preparation\Processor\Property\Assert\UrlStrategy;
use Micro\Library\DTO\Preparation\Processor\Property\Assert\UuidStrategy;
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

readonly class DependencyInjection implements DependencyInjectionInterface
{
    /**
     * @param string[] $filesSchemeCollection
     */
    public function __construct(
        private array $filesSchemeCollection,
        private string $namespaceGeneral,
        private string $classSuffix,
        private string $outputPath,
        private ?LoggerInterface $logger
    ) {
    }

    public function getLogger(): LoggerInterface
    {
        return $this->logger ?? new NullLogger();
    }

    public function createClassPreparationProcessor(): CollectionPreparationInterface
    {
        return new CollectionPreparation($this->createPreparationProcessorCollection());
    }

    public function createReader(): ReaderInterface
    {
        return new XmlReader(
            $this->filesSchemeCollection,
            new MergerFactory()
        );
    }

    public function createClassMetadataHelper(): ClassMetadataHelper
    {
        return new ClassMetadataHelper($this->namespaceGeneral, $this->classSuffix);
    }

    public function createCamelCaseProcessor(): NameNormalizerInterface
    {
        return new CamelCaseNormalizer();
    }

    public function createWriter(): WriterInterface
    {
        return new WriterFilesystem(
            $this->outputPath,
            $this->namespaceGeneral
        );
    }

    public function createRenderer(): RendererInterface
    {
        return new NetteRenderer(); // new TwigRenderer($twig, $this->classTemplateName);
    }

    /**
     * @return iterable<PreparationProcessorInterface>
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
            new MethodAttributesMetadataProcessor($camelCaseHelper),
        ];
    }

    /**
     * @return iterable<PropertyProcessorInterface>
     */
    protected function createPropertyValidationProcessorCollection(): iterable
    {
        return [
            new EmailStrategy(),
            new IpStrategy(),
            new HostnameStrategy(),
            new RegexStrategy(),
            new UrlStrategy(),
            new LengthStrategy(),
            new BlankStrategy(),
            new NotBlankStrategy(),
            new JsonStrategy(),
            new UuidStrategy(),
            new DateStrategy(),
            new TimeStrategy(),
            new DateTimeStrategy(),
            new TimeZoneStrategy(),
            new NegativeStrategy(),
            new NegativeOrZeroStrategy(),
            new PositiveStrategy(),
            new PositiveOrZeroStrategy(),
            new EqualToStrategy(),
            new GreaterThanStrategy(),
            new GreaterThanOrEqualStrategy(),
            new LessThanStrategy(),
            new LessThanOrEqualStrategy(),
            new NotEqualToStrategy(),
            new NotIdenticalToStrategy(),
            new IdenticalToStrategy(),
            new RangeStrategy(),
            new CardSchemeStrategy(),
            new BicStrategy(),
            new CurrencyStrategy(),
            new LuhnStrategy(),
            new IbanStrategy(),
            new IsbnStrategy(),
            new IsinStrategy(),
            new IssnStrategy(),
            new ChoiceStrategy(),
            new ExpressionStrategy(),
        ];
    }
}

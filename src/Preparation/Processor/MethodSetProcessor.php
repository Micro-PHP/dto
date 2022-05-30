<?php

namespace Micro\Library\DTO\Preparation\Processor;

use Micro\Library\DTO\ClassDef\ClassDefinition;
use Micro\Library\DTO\ClassDef\MethodDefinition;
use Micro\Library\DTO\ClassDef\PropertyDefinition;
use Micro\Library\DTO\Helper\NameNormalizerInterface;
use Micro\Library\DTO\Preparation\PreparationProcessorInterface;

class MethodSetProcessor implements PreparationProcessorInterface
{
    /**
     * @param NameNormalizerInterface $nameNormalizer
     */
    public function __construct(private readonly NameNormalizerInterface $nameNormalizer)
    {
    }

    public function process(iterable $classDef, ClassDefinition $classDefinition, array $classList): void
    {
        foreach ($classDefinition->getProperties() as $property) {
            $this->provideMethod($classDefinition, $property);
        }
    }

    protected function provideMethod(ClassDefinition $classDefinition, PropertyDefinition $propertyDefinition): void
    {
        $propertyName = $propertyDefinition->getName();
        $methodSuffix = $this->nameNormalizer->normalize($propertyName);

        $methodDef = new MethodDefinition();
        $methodDef->setName('set' . ucfirst($methodSuffix));
        $methodDef->setBody(sprintf("\$this->%s = $%s;\r\n\r\nreturn \$this;", $propertyName, $propertyName));
        $methodDef->setArgs([$propertyDefinition]);
        $methodDef->setTypesReturn(['self']);

        $classDefinition->addMethod($methodDef);
    }
}
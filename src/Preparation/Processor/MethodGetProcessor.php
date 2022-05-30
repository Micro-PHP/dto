<?php

namespace Micro\Library\DTO\Preparation\Processor;

use Micro\Library\DTO\ClassDef\ClassDefinition;
use Micro\Library\DTO\ClassDef\MethodDefinition;
use Micro\Library\DTO\ClassDef\PropertyDefinition;
use Micro\Library\DTO\Helper\NameNormalizerInterface;
use Micro\Library\DTO\Preparation\PreparationProcessorInterface;

class MethodGetProcessor implements PreparationProcessorInterface
{
    public function __construct(private readonly NameNormalizerInterface $nameNormalizer)
    {

    }

    public function process(iterable $classDef, ClassDefinition $classDefinition, array $classList): void
    {
        $properties = $classDefinition->getProperties();
        foreach ($properties as $property) {
            $this->provideGetMethod($classDefinition, $property);
        }
    }

    protected function provideGetMethod(ClassDefinition $classDefinition, PropertyDefinition $propertyDefinition)
    {
        $propertyName = $propertyDefinition->getName();
        $methodSuffix = $this->nameNormalizer->normalize($propertyName);
        $methodDefinition = new MethodDefinition();
        $methodDefinition->setName('get' . ucfirst($methodSuffix));
        $methodDefinition->setTypesReturn($propertyDefinition->getTypes());
        $methodDefinition->setVisibility('public');
        $methodDefinition->setBody(sprintf('return $this->%s;', $propertyName));
        //$methodDefinition->addComment(sprintf('@return %s', implode('|', $propertyDefinition->getTypes())));

        $classDefinition->addMethod($methodDefinition);
    }
}
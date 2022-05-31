<?php

namespace Micro\Library\DTO\Preparation\Processor;

use Micro\Library\DTO\ClassDef\ClassDefinition;
use Micro\Library\DTO\ClassDef\MethodDefinition;
use Micro\Library\DTO\ClassDef\PropertyDefinition;
use Micro\Library\DTO\Helper\NameNormalizerInterface;
use Micro\Library\DTO\Object\Collection;
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
        //$methodDef->setBody(sprintf("\$this->%s = $%s;\r\n\r\nreturn \$this;", $propertyName, $propertyName));

        if($propertyDefinition->isCollection()) {
            $this->createCollectionSetterBody($methodDef, $propertyName);
        } else {
            $this->createDefaultSetterBody($methodDef, $propertyName);
        }

        $methodDef->setArgs([$propertyDefinition]);
        $methodDef->setTypesReturn(['self']);
        $classDefinition->addMethod($methodDef);

    }

    protected function createCollectionSetterBody(MethodDefinition $methodDefinition, string $propertyName) : void
    {
        $methodDefinition->setBody(
            sprintf('
            if(!$%s) {
                $this->%s = null;
                
                return $this;
            }
            
            if(!$this->%s) {
                $this->%s = new %s();
            }
            
            foreach($%s as $item) {
                $this->%s->add($item);
            }
            
            return $this;',
                $propertyName,
                $propertyName,
                $propertyName,
                $propertyName,
                'Collection',
                $propertyName,
                $propertyName)
        );
    }

    protected function createDefaultSetterBody(MethodDefinition $methodDefinition, string $propertyName): void
    {
        $methodDefinition->setBody(sprintf("\$this->%s = $%s;\r\n\r\nreturn \$this;", $propertyName, $propertyName));
    }
}
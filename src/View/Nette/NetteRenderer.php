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

namespace Micro\Library\DTO\View\Nette;

use Micro\Library\DTO\ClassDef\ClassDefinition;
use Micro\Library\DTO\ClassDef\MethodDefinition;
use Micro\Library\DTO\ClassDef\PropertyDefinition;
use Micro\Library\DTO\View\RendererInterface;
use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\Method;
use Nette\PhpGenerator\PhpFile;
use Nette\PhpGenerator\PhpNamespace;
use Nette\PhpGenerator\Property;
use Nette\PhpGenerator\PsrPrinter;

class NetteRenderer implements RendererInterface
{
    public function render(ClassDefinition $classDefinition): string
    {
        $phpFile = $this->createPhpFileType($classDefinition);
        $class = array_values($phpFile->getClasses());
        /** @var ClassType $class */
        $class = $class[0];

        $class
            ->setExtends($classDefinition->getExtends())
            ->setFinal()
        ;

        foreach ($classDefinition->getComments() as $comment) {
            $class->addComment($comment);
        }

        $this->provideProperties($class, $classDefinition);
        $this->provideMethods($class, $classDefinition);
        // $this->provideMeta($class, $classData);

        return $this->printClass($phpFile);
    }

    protected function createPhpFileType(ClassDefinition $classDefinition): PhpFile
    {
        $file = new PhpFile();
        $file->addComment('This file is auto-generated.');
        $file->setStrictTypes();
        $namespaceObj = new PhpNamespace($classDefinition->getNamespace());
        $namespaceObj->addClass($classDefinition->getName());
        $namespace = $file->addNamespace($namespaceObj);

        $this->provideUsages($namespace, $classDefinition);

        return $file;
    }

    protected function provideUsages(PhpNamespace $namespace, ClassDefinition $classDefinition): void
    {
        $usages = $classDefinition->getUseStatements();
        foreach ($usages as $ns => $alias) {
            $namespace->addUse($ns, $alias);
        }
    }

    protected function provideProperties(ClassType $classType, ClassDefinition $classDefinition): void
    {
        foreach ($classDefinition->getProperties() as $property) {
            $this->provideProperty($classType, $property);
        }
    }

    protected function provideProperty(ClassType $classType, PropertyDefinition $propertyDefinition): void
    {
        $property = new Property($propertyDefinition->getName());
        $isRequired = $propertyDefinition->isRequired();
        $property
            ->setProtected()
            ->setType(implode('|', $propertyDefinition->getTypes()));

        if (false === $isRequired) {
            $property->setValue(null);
        }

        foreach ($propertyDefinition->getComments() as $comment) {
            $property->addComment($comment);
        }

        foreach ($propertyDefinition->getAttributes() as $attribute) {
            foreach ($attribute as $attrName => $attrArgs) {
                $property->addAttribute($attrName, $attrArgs);
            }
        }

        $classType->addMember($property);
    }

    protected function printClass(PhpFile $phpFile): string
    {
        $printer = new PsrPrinter();

        return $printer->printFile($phpFile);
    }

    protected function provideMethods(ClassType $classType, ClassDefinition $classDefinition): void
    {
        foreach ($classDefinition->getMethods() as $methodDef) {
            $this->provideMethod($classType, $methodDef);
        }
    }

    protected function provideMethod(ClassType $classType, MethodDefinition $methodDefinition): void
    {
        $method = new Method($methodDefinition->getName());
        $method
            ->setBody($methodDefinition->getBody())
            ->setReturnType(implode(separator: '|', array: $methodDefinition->getTypesReturn()))
            ->setVisibility($methodDefinition->getVisibility())
            ->setStatic($methodDefinition->isStatic())
        ;

        foreach ($methodDefinition->getComments() as $comment) {
            $method->addComment($comment);
        }

        foreach ($methodDefinition->getArgs() as $arg) {
            $parameter = $method->addParameter($arg->getName());
            $parameter->setType(implode('|', $arg->getTypes()));
        }

        $classType->addMember($method);
    }
}

<?php

namespace Micro\Library\DTO\View\Nette;

use Micro\Library\DTO\Object\AbstractDto;
use Micro\Library\DTO\View\RendererInterface;
use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\Method;
use Nette\PhpGenerator\Parameter;
use Nette\PhpGenerator\PhpFile;
use Nette\PhpGenerator\PhpNamespace;
use Nette\PhpGenerator\Property;
use Nette\PhpGenerator\PsrPrinter;
use Micro\Library\DTO\Preparation\PreparationProcessorInterface as PPI;

class NetteRenderer implements RendererInterface
{
    /**
     * @param array $classData
     *
     * @return string
     */
    public function render(array $classData): string
    {
        $phpFile = $this->createPhpFileType($classData);
        $class = array_values($phpFile->getClasses());
        /** @var ClassType $class */
        $class = $class[0];

        $class
            ->setExtends(AbstractDto::class)
            ->setFinal()
            ->setComment($this->createCommentMessage($classData[PPI::DESCRIPTION] ?? ''))
        ;

        $this->provideProperties($class, $classData);
        $this->provideMeta($class, $classData);

        return $this->printClass($phpFile);
    }

    protected function provideMeta(ClassType $classType, array $classData): void
    {
        $returnsContent = var_export($classData[PPI::CLASS_PROPS_META], true);
        $method = new Method(PPI::CLASS_PROPS_META_METHOD);
        $method
            ->setProtected()
            ->setStatic()
            ->setBody('return ' . $returnsContent . ';')
            ->setComment('{@inheritdoc}')
            ->setReturnType('array')
        ;

        $classType->addMember($method);
    }

    protected function createPhpFileType(array $classData): PhpFile
    {
        $file = new PhpFile;
        $file->addComment('This file is auto-generated.');
        $file->setStrictTypes();
        $namespaceObj = new PhpNamespace($classData[PPI::CLASS_NAMESPACE]);
        $namespaceObj->addClass($classData[PPI::CLASS_NAME]);
        $namespace = $file->addNamespace($namespaceObj);
        $this->provideUsages($namespace, $classData);

        return $file;
    }

    protected function provideComments(Method|ClassType|Property|PhpFile $object, array $comments)
    {
        $comments = array_unique($comments);
        foreach ($comments as $comment) {
            $object->addComment($comment ? ($comment . "\n") : '');
        }
    }

    protected function provideUsages(PhpNamespace $namespace, array $classData)
    {
        $usages = $classData[PPI::CLASS_USE_STATEMENTS] ?? [];
        foreach ($usages as $use) {
            $namespace->addUse($use);
        }
    }

    protected function provideProperties(ClassType $classType, array $classData): void
    {
        foreach ($classData[PPI::SECTION_PROPERTIES] as $property) {
            $this->provideProperty($classType, $property);
            $this->provideGetSet($classType, $property);
        }
    }

    protected function provideProperty(ClassType $classType, array $propertyData): void
    {
        $property = new Property($propertyData[PPI::PROP_NAME]);
        $property
            ->setProtected()
            ->setType($propertyData[PPI::METHOD_TYPE_ARG]);

        $comments = $propertyData[PPI::PROP_COMMENTS];
        $this->provideComments($property, $comments);

        $classType->addMember($property);
    }

    /**
     * @param string $message
     * @return string
     */
    protected function createCommentMessage(string $message): string
    {
        return $message ? ($message . "\n") : '';
    }

    protected function printClass(PhpFile $phpFile): string
    {
        $printer = new PsrPrinter();

        return $printer->printFile($phpFile);
    }

    protected function provideGetSet(ClassType $classType, array $propertyData)
    {
        $propertyName = $propertyData[PPI::PROP_NAME];
        $actionName = $propertyData[PPI::PROP_ACTION_NAME];
        $methodTypeArg = $propertyData[PPI::METHOD_TYPE_ARG];
        $getName = 'get' . $actionName;
        $setName = 'set' . $actionName;

        $methodGet = $this->createMethod($getName);
        $methodGet->setBody($propertyData[PPI::METHOD_GET_BODY]);
        $methodGet->setReturnType($methodTypeArg);
        $this->provideComments($methodGet, $propertyData[PPI::METHOD_GET_COMMENTS]);

        $methodSet = $this->createMethod($setName);
        $parameterSet = new Parameter($propertyName);
        $parameterSet->setType($methodTypeArg);
        $methodSet->setParameters([$parameterSet]);
        $methodSet->setBody($propertyData[PPI::METHOD_SET_BODY]);
        $methodSet->setReturnType('self');
        $this->provideComments($methodSet, $propertyData[PPI::METHOD_SET_COMMENTS]);

        $classType
            ->addMember($methodGet)
            ->addMember($methodSet);
    }

    protected function createMethod(string $name): Method
    {
        $method = new Method($name);

        return $method
            ->setPublic();
    }
}
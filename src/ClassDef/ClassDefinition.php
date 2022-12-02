<?php

namespace Micro\Library\DTO\ClassDef;

use Micro\Library\DTO\Helper\ClassMetadataHelperInterface;

class ClassDefinition
{
    /**
     * @var string
     */
    private string $extends = ClassMetadataHelperInterface::PROPERTY_TYPE_ABSTRACT_CLASS;

    /**
     * @var string
     */
    private string $namespace = '';

    /**
     * @var string
     */
    private string $name;

    /**
     * @var array
     */
    private array $useStatements = [];

    /**
     * @var iterable<PropertyDefinition>
     */
    private iterable $properties = [];

    /**
     * @var iterable<MethodDefinition>
     */
    private iterable $methods = [];

    /**
     * @var iterable<string>
     */
    private iterable $comments = [];

    /**
     * @var bool
     */
    private bool $usePrefix = true;

    /**
     * @return string
     */
    public function getExtends(): string
    {
        return $this->extends;
    }

    /**
     * @param string $extends
     */
    public function setExtends(string $extends): void
    {
        $this->extends = $extends;
    }

    /**
     * @return string
     */
    public function getNamespace(): string
    {
        return $this->namespace;
    }

    /**
     * @param string $namespace
     */
    public function setNamespace(string $namespace): void
    {
        $this->namespace = $namespace;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return PropertyDefinition[]
     */
    public function getProperties(): iterable
    {
        return $this->properties;
    }

    /**
     * @param PropertyDefinition[] $properties
     */
    public function setProperties(iterable $properties): void
    {
        $this->properties = $properties;
    }

    /**
     * @param PropertyDefinition $propertyDefinition
     *
     * @return $this
     */
    public function addProperty(PropertyDefinition $propertyDefinition): self
    {
        $this->properties[] = $propertyDefinition;

        return $this;
    }

    /**
     * @return MethodDefinition[]
     */
    public function getMethods(): iterable
    {
        return $this->methods;
    }

    public function addMethod(MethodDefinition $methodDefinition): self
    {
        $this->methods[] = $methodDefinition;

        return $this;
    }

    /**
     * @param MethodDefinition[] $methods
     */
    public function setMethods(iterable $methods): void
    {
        $this->methods = $methods;
    }

    /**
     * @return string[]
     */
    public function getComments(): iterable
    {
        return $this->comments;
    }

    /**
     * @param string[] $comments
     */
    public function setComments(array $comments): void
    {
        $this->comments = $comments;
    }

    /**
     * @param string $comment
     *
     * @return $this
     */
    public function addComment(string $comment): self
    {
        if(!in_array($comment, $this->comments)) {
            $this->comments[] = $comment;
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getUseStatements(): array
    {
        return $this->useStatements;
    }

    /**
     * @param array $useStatements
     */
    public function setUseStatements(array $useStatements): void
    {
        $this->useStatements = $useStatements;
    }

    /**
     * @param string $useStatement
     *
     * @return $this
     */
    public function addUseStatement(string $useStatement): self
    {
        if(!in_array($useStatement, $this->useStatements)) {
            $this->useStatements[] = $useStatement;
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function isUsePrefix(): bool
    {
        return $this->usePrefix;
    }

    /**
     * @param bool $usePrefix
     *
     * @return $this
     */
    public function setUsePrefix(bool $usePrefix): self
    {
        $this->usePrefix = $usePrefix;

        return $this;
    }
}
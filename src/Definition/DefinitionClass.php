<?php

namespace Micro\Library\DTO\Definition;

class DefinitionClass
{
    /**
     * @var string
     */
    private string $className;

    /**
     * @var string
     */
    private string $namespace;

    /**
     * @var string
     */
    private string $description;

    /**
     * @var string
     */
    private string $deprecated;

    /**
     * @var iterable<string>
     */
    private iterable $useStatements;

    /**
     * @var iterable<DefinitionProperty>
     */
    private iterable $properties;

    /**
     * @return string
     */
    public function getClassName(): string
    {
        return $this->className;
    }

    /**
     * @param string $className
     */
    public function setClassName(string $className): void
    {
        $this->className = $className;
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
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getDeprecated(): string
    {
        return $this->deprecated;
    }

    /**
     * @param string $deprecated
     */
    public function setDeprecated(string $deprecated): void
    {
        $this->deprecated = $deprecated;
    }

    /**
     * @return iterable<string>
     */
    public function getUseStatements(): iterable
    {
        return $this->useStatements;
    }

    /**
     * @param iterable<string> $useStatements
     */
    public function setUseStatements(iterable $useStatements): void
    {
        $this->useStatements = $useStatements;
    }

    /**
     * @return iterable<DefinitionProperty>
     */
    public function getProperties(): iterable
    {
        return $this->properties;
    }

    /**
     * @param iterable<DefinitionProperty> $properties
     */
    public function setProperties(iterable $properties): void
    {
        $this->properties = $properties;
    }
}
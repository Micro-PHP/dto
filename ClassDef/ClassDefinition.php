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

namespace Micro\Library\DTO\ClassDef;

use Micro\Library\DTO\Helper\ClassMetadataHelperInterface;

class ClassDefinition
{
    private string $extends = ClassMetadataHelperInterface::PROPERTY_TYPE_ABSTRACT_CLASS;

    private string $namespace = '';

    private string $name = '';

    /**
     * @var array<string, string|null>
     */
    private array $useStatements = [];

    /**
     * @var array<PropertyDefinition>
     */
    private array $properties = [];

    /**
     * @var array<MethodDefinition>
     */
    private array $methods = [];

    /**
     * @var array<string>
     */
    private array $comments = [];

    public function getExtends(): string
    {
        return $this->extends;
    }

    public function setExtends(string $extends): void
    {
        $this->extends = $extends;
    }

    public function getNamespace(): string
    {
        return $this->namespace;
    }

    public function setNamespace(string $namespace): void
    {
        $this->namespace = $namespace;
    }

    public function getName(): string
    {
        return $this->name;
    }

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
        if (!\in_array($methodDefinition, $this->methods)) {
            $this->methods[] = $methodDefinition;
        }

        return $this;
    }

    /**
     * @return string[]
     */
    public function getComments(): iterable
    {
        return $this->comments;
    }

    public function addComment(string $comment): self
    {
        if (!\in_array($comment, $this->comments)) {
            $this->comments[] = $comment;
        }

        return $this;
    }

    /**
     * @return array<string, null>|array<string, string>
     */
    public function getUseStatements(): array
    {
        return $this->useStatements;
    }

    public function addUseStatement(string $useStatement, string $alias = null): self
    {
        if (!\array_key_exists($useStatement, $this->useStatements)) {
            $this->useStatements[$useStatement] = $alias;
        }

        return $this;
    }
}

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

class PropertyDefinition
{
    private string $name;

    /**
     * @var string[]
     */
    private array $comments = [];
    /**
     * @var string[]
     */
    private array $types = [];

    /**
     * @var array<array<string, mixed>>
     */
    private array $attributes = [];

    private bool $isRequired = false;
    private bool $isCollection = false;

    public function __construct()
    {
        $this->name = '';
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
     * @return string[]
     */
    public function getComments(): array
    {
        return $this->comments;
    }

    public function addComment(string $comment): self
    {
        $this->comments[] = $comment;

        return $this;
    }

    /**
     * @return string[]
     */
    public function getTypes(): array
    {
        return $this->types;
    }

    /**
     * @param string[] $types
     */
    public function setTypes(array $types): void
    {
        $this->types = $types;
    }

    /**
     * @return bool
     */
    public function isRequired(): bool
    {
        return $this->isRequired;
    }

    /**
     * @param bool $isRequired
     */
    public function setIsRequired(bool $isRequired): void
    {
        $this->isRequired = $isRequired;
    }

    /**
     * @return bool
     */
    public function isCollection(): bool
    {
        return $this->isCollection;
    }

    /**
     * @param bool $isCollection
     */
    public function setIsCollection(bool $isCollection): void
    {
        $this->isCollection = $isCollection;
    }

    /**
     * @param string               $attributeName
     * @param array<string, mixed> $arguments
     *
     * @return $this
     */
    public function addAttribute(string $attributeName, array $arguments): self
    {
        $this->attributes[] = [
            $attributeName => $arguments,
        ];

        return $this;
    }

    /**
     * @return array<string, mixed>
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }
}

<?php

namespace Micro\Library\DTO\ClassDef;

class PropertyDefinition
{
    private string $name;
    private iterable $comments = [];
    private iterable $types = [];
    private bool $isRequired = false;
    private bool $isCollection = false;

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
     * @return iterable
     */
    public function getComments(): iterable
    {
        return $this->comments;
    }

    /**
     * @param iterable $comments
     */
    public function setComments(iterable $comments): void
    {
        $this->comments = $comments;
    }

    public function addComment(string $comment): self
    {
        $this->comments[] = $comment;

        return $this;
    }

    /**
     * @return array
     */
    public function getTypes(): array
    {
        return $this->types;
    }

    /**
     * @param iterable $types
     */
    public function setTypes(iterable $types): void
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
}
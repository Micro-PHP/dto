<?php

namespace Micro\Library\DTO\ClassDef;

class MethodDefinition
{
    private string $visibility = 'public';
    private string $name;
    private iterable $typesReturn = [];
    private iterable $args = [];
    private string $body;
    private iterable $comments = [];

    /**
     * @return string
     */
    public function getVisibility(): string
    {
        return $this->visibility;
    }

    /**
     * @param string $visibility
     */
    public function setVisibility(string $visibility): void
    {
        $this->visibility = $visibility;
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
     * @return iterable
     */
    public function getTypesReturn(): iterable
    {
        return $this->typesReturn;
    }

    /**
     * @param iterable $typesReturn
     */
    public function setTypesReturn(iterable $typesReturn): void
    {
        $this->typesReturn = $typesReturn;
    }

    /**
     * @return iterable<PropertyDefinition>
     */
    public function getArgs(): iterable
    {
        return $this->args;
    }

    /**
     * @param iterable<PropertyDefinition> $args
     */
    public function setArgs(iterable $args): void
    {
        $this->args = $args;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @param string $body
     */
    public function setBody(string $body): void
    {
        $this->body = $body;
    }

    /**
     * @return array|iterable
     */
    public function getComments(): array
    {
        return $this->comments;
    }

    /**
     * @param array $comments
     */
    public function setComments(array $comments): void
    {
        $this->comments = $comments;
    }

    public function addComment(string $comment): self
    {
        if(!in_array($comment, $this->comments)) {
            $this->comments[] = $comment;
        }

        return $this;
    }
}
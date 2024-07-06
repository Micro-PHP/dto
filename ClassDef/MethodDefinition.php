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

class MethodDefinition
{
    private string $visibility = 'public';

    private string $name = '';

    /**
     * @var string[]
     */
    private array $typesReturn = [];

    /**
     * @var PropertyDefinition[]
     */
    private array $args = [];

    private string $body = '';

    /**
     * @var string[]
     */
    private array $comments = [];

    private bool $isStatic = false;

    public function getVisibility(): string
    {
        return $this->visibility;
    }

    public function setVisibility(string $visibility): void
    {
        $this->visibility = $visibility;
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
     * @return string[]
     */
    public function getTypesReturn(): array
    {
        return $this->typesReturn;
    }

    /**
     * @param array<string> $typesReturn
     */
    public function setTypesReturn(array $typesReturn): void
    {
        $this->typesReturn = $typesReturn;
    }

    /**
     * @return PropertyDefinition[]
     */
    public function getArgs(): array
    {
        return $this->args;
    }

    /**
     * @param PropertyDefinition[] $args
     */
    public function setArgs(array $args): void
    {
        $this->args = $args;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function setBody(string $body): void
    {
        $this->body = $body;
    }

    /**
     * @return array<string>
     */
    public function getComments(): array
    {
        return $this->comments;
    }

    public function isStatic(): bool
    {
        return $this->isStatic;
    }

    public function setIsStatic(bool $isStatic): void
    {
        $this->isStatic = $isStatic;
    }
}

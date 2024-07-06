<?php

/**
 * This file is auto-generated.
 */

declare(strict_types=1);

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Library\DTO\Tests;

use Micro\Library\DTO\Object\AbstractDto;
use Micro\Library\DTO\Object\Collection;

/**
 * @deprecated Please, use gSON
 * Example class description
 */
final class UserTransfer extends AbstractDto
{
    /**
     * Username.
     *
     * @deprecated Deprecation  message
     */
    protected string|int|null $username = null;
    protected iterable|null $books = null;
    protected string|int $first_name;
    protected \DateTimeInterface|null $updatedAt = null;
    protected AbstractDto|null $someclass = null;
    protected mixed $testMixed = null;

    public function getUsername(): string|int|null
    {
        return $this->username;
    }

    public function getBooks(): iterable|null
    {
        return $this->books;
    }

    public function getFirstName(): string|int
    {
        return $this->first_name;
    }

    public function getUpdatedAt(): \DateTimeInterface|null
    {
        return $this->updatedAt;
    }

    public function getSomeclass(): AbstractDto|null
    {
        return $this->someclass;
    }

    public function getTestMixed(): mixed
    {
        return $this->testMixed;
    }

    public function setUsername(string|int|null $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function setBooks(iterable|null $books): self
    {
        if (!$books) {
            $this->books = null;

            return $this;
        }

        if (!$this->books) {
            $this->books = new Collection();
        }

        foreach ($books as $item) {
            $this->books->add($item);
        }

        return $this;
    }

    public function setFirstName(string|int $first_name): self
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function setUpdatedAt(\DateTimeInterface|null $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function setSomeclass(AbstractDto|null $someclass): self
    {
        $this->someclass = $someclass;

        return $this;
    }

    public function setTestMixed(mixed $testMixed): self
    {
        $this->testMixed = $testMixed;

        return $this;
    }

    protected static function attributesMetadata(): array
    {
        return [
            'username' => [
                'type' => [
                    0 => 'string',
                    1 => 'int',
                    2 => 'null',
                ],
                'required' => false,
                'actionName' => 'username',
            ],
            'books' => [
                'type' => [
                    0 => 'iterable',
                    1 => 'null',
                ],
                'required' => false,
                'actionName' => 'books',
            ],
            'first_name' => [
                'type' => [
                    0 => 'string',
                    1 => 'int',
                ],
                'required' => true,
                'actionName' => 'firstName',
            ],
            'updatedAt' => [
                'type' => [
                    0 => 'DateTimeInterface',
                    1 => 'null',
                ],
                'required' => false,
                'actionName' => 'updatedAt',
            ],
            'someclass' => [
                'type' => [
                    0 => 'Micro\\Library\\DTO\\Object\\AbstractDto',
                    1 => 'null',
                ],
                'required' => false,
                'actionName' => 'someclass',
            ],
            'testMixed' => [
                'type' => [
                    0 => 'mixed',
                ],
                'required' => false,
                'actionName' => 'testMixed',
            ],
        ];
    }
}

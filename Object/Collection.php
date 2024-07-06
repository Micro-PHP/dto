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

namespace Micro\Library\DTO\Object;

/**
 * @template-implements \IteratorAggregate<mixed>
 * @template-implements \ArrayAccess<string, mixed>
 */
class Collection implements \ArrayAccess, \IteratorAggregate, \Countable
{
    private array $items;

    public function __construct()
    {
        $this->items = [];
    }

    public function add(mixed $item): self
    {
        $this->validateItem($item);

        $this->items[] = $item;

        return $this;
    }

    public function remove(mixed $item): self
    {
        foreach ($this as $pos => $currItem) {
            if ($currItem === $item) {
                $this->offsetUnset($pos);

                break;
            }
        }

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getIterator(): \Traversable
    {
        return (function () {
            foreach ($this->items as $item) {
                yield $item;
            }
        })();
    }

    /**
     * {@inheritDoc}
     */
    public function offsetExists(mixed $offset): bool
    {
        return isset($this->items[$offset]);
    }

    /**
     * {@inheritDoc}
     */
    public function offsetGet(mixed $offset): mixed
    {
        return $this->offsetExists($offset) ? $this->items[$offset] : null;
    }

    /**
     * {@inheritDoc}
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        if (null === $offset) {
            throw new \InvalidArgumentException();
        }

        $this->items[$offset] = $value;
    }

    /**
     * {@inheritDoc}
     */
    public function offsetUnset(mixed $offset): void
    {
        unset($this->items[$offset]);
    }

    /**
     * {@inheritDoc}
     */
    public function count(): int
    {
        return \count($this->items);
    }

    protected function validateItem(mixed $item): void
    {
    }
}

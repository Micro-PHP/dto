<?php

namespace Micro\Library\DTO\Object;

use Traversable;

class Collection implements \ArrayAccess, \IteratorAggregate, \Countable
{
    /**
     * @var iterable
     */
    private iterable $items;

    /**
     * @param iterable $items
     */
    public function __construct(private readonly array $typesRequired = [])
    {
        $this->items = [];
    }

    /**
     * @param mixed $item
     *
     * @return $this
     */
    public function add($item): self
    {
        $this->validateItem($item);

        $this->items[] = $item;

        return $this;
    }

    /**
     * @param mixed $item
     *
     * @return self
     */
    public function remove($item): self
    {
        foreach ($this as $pos => $currItem) {
            if($currItem === $item) {
                $this->offsetUnset($pos);

                break;
            }
        }

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getIterator(): Traversable
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
        return $this->offsetExists($offset) ? $this->items[$offset]: null;
    }

    /**
     * {@inheritDoc}
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
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
        return count($this->items);
    }

    protected function validateItem(mixed $item): void
    {
    }
}
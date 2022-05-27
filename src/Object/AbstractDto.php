<?php

namespace Micro\Library\DTO\Object;

use Traversable;

abstract class AbstractDto implements \ArrayAccess, \IteratorAggregate
{
    /**
     * @return array
     */
    protected static abstract function attributesMetadata(): array;

    /**
     * @param string $attribute
     *
     * @return array|null
     */
    protected function getAttributeMetadata(string $attribute): ?array
    {
       $meta = static::attributesMetadata();

       return $meta[$attribute] ?? null;
    }

    /**
     * {@inheritDoc}
     */
    public function offsetExists(mixed $offset): bool
    {
        return !!$this->getAttributeMetadata($offset);
    }

    /**
     * {@inheritDoc}
     */
    public function offsetGet(mixed $offset): mixed
    {
        return $this->executeAction('get', $offset, null);
    }

    /**
     * {@inheritDoc}
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->executeAction('set', $offset, $value);
    }

    /**
     * {@inheritDoc}
     */
    public function offsetUnset(mixed $offset): void
    {
        $this->offsetSet($offset, null);
    }

    /**
     * @return Traversable
     */
    public function getIterator(): Traversable
    {
        return (function () {
            foreach ($this->attributesMetadata() as $attributeName => $meta) {
                yield $attributeName => $this->offsetGet($attributeName);
            }
        })();
    }

    /**
     * @param string $action
     * @param string $property
     * @param mixed $value
     * @return mixed
     */
    protected function executeAction(string $action, string $property, mixed $value): mixed
    {
        $meta = $this->getAttributeMetadata($property);
        if(!$meta) {
            throw new \InvalidArgumentException(
                sprintf('Property "%s" is not declared in the class "%s".', $property, get_class($this))
            );
        }

        $actionName = $meta['actionName'];

        return $this->{$action . $actionName}($value);
    }
}
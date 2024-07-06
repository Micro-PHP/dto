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
 * @template-implements \ArrayAccess<string, mixed>
 * @template-implements \IteratorAggregate<string, mixed>
 */
abstract class AbstractDto implements \ArrayAccess, \IteratorAggregate
{
    /**
     * {@inheritDoc}
     */
    public function offsetExists(mixed $offset): bool
    {
        return (bool) $this->getAttributeMetadata($offset);
    }

    /**
     * {@inheritDoc}
     */
    public function offsetGet(mixed $offset): mixed
    {
        return $this->executeMethod('get', $offset, null);
    }

    /**
     * {@inheritDoc}
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        if (!$offset) {
            throw new \InvalidArgumentException();
        }

        $this->executeMethod('set', $offset, $value);
    }

    /**
     * {@inheritDoc}
     */
    public function offsetUnset(mixed $offset): void
    {
        $this->offsetSet($offset, null);
    }

    /**
     * @return \Traversable<string, mixed>
     */
    public function getIterator(): \Traversable
    {
        return (function () {
            foreach ($this->attributesMetadata() as $attributeName => $meta) {
                yield $attributeName => $this->offsetGet($attributeName);
            }
        })();
    }

    /**
     * @return array<string, mixed>
     */
    abstract protected static function attributesMetadata(): array;

    protected function getAttributeMetadata(string $attribute): ?array
    {
        $meta = static::attributesMetadata();

        return $meta[$attribute] ?? null;
    }

    protected function executeMethod(string $method, string $property, mixed $value): mixed
    {
        $meta = $this->getAttributeMetadata($property);
        if (!$meta) {
            throw new \InvalidArgumentException(sprintf('Property "%s" is not declared in the class "%s".', $property, static::class));
        }

        $actionName = $meta['actionName'];

        return $this->{$method.$actionName}($value);
    }
}

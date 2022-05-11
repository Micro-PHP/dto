<?php

namespace Micro\Library\DTO\Object;

use Traversable;

abstract class AbstractDto implements \ArrayAccess, \IteratorAggregate, \JsonSerializable
{
    /**
     * @param array|null $sourceData
     */
    public function __construct(?array $sourceData = [])
    {
        $this->fromArray($sourceData);
    }

    /**
     * @return array
     */
    protected abstract function attributesMetadata(): array;

    /**
     * @return array
     */
    public abstract function toArray(): array;

    /**
     * @param string $attribute
     *
     * @return array|null
     */
    protected function getAttributeMetadata(string $attribute): ?array
    {
       $meta = $this->attributesMetadata();

       return $meta[$attribute] ?? null;
    }

    /**
     * @param array|null $sourceData
     * @return void
     */
    protected function fromArray(?array $sourceData): void
    {
        if($sourceData === null) {
            return;
        }

        $attributesMetadata = $this->attributesMetadata();
        foreach ($sourceData as $attributeName => $value) {
            if(!array_key_exists($attributeName, $attributesMetadata)) {
                throw new \RuntimeException(sprintf('Property "%s" is not registered in the %s', $attributeName, get_class($this)));
            }

            $meta = $attributesMetadata[$attributeName];
            $dtoClass = $meta['dto'];
            $resultValue = $value;
            if($dtoClass) {
                $resultValue = new $dtoClass($value);
            }

            $this->{$attributeName} = $resultValue;
        }
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
     * {@inheritDoc}
     */
    public function jsonSerialize(): mixed
    {
        return json_encode($this->toArray());
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
<?php

namespace Micro\Library\DTO\Object;

abstract class AbstractDto
{
    /**
     * @param array|null $sourceData
     */
    public function __construct(?array $sourceData)
    {
        $this->fromArray($sourceData);
    }

    /**
     * @return array
     */
    public abstract function toArray(): array;

    /**
     * @param array|null $sourceData
     * @return void
     */
    protected function fromArray(?array $sourceData): void
    {
        if($sourceData === null) {
            return;
        }
    }

    /**
     * @return array
     */
    protected abstract function attributesMetadata(): array;
}
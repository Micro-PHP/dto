<?php

namespace Micro\Library\DTO\Object;

abstract class AbstractDto
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

        $attributesMetadata = $this->attributesMetadata();
        foreach ($sourceData as $attributeName => $value) {
            if(!array_key_exists($attributeName, $attributesMetadata)) {
                throw new \RuntimeException(sprintf('Property "%s" is not registered in the %s', $attributeName, __CLASS__));
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
     * @return array
     */
    protected abstract function attributesMetadata(): array;
}
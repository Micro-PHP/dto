<?php

namespace Micro\Library\DTO\Serializer;

use Micro\Library\DTO\Exception\UnserializeException;
use Micro\Library\DTO\Object\AbstractDto;
use Micro\Library\DTO\Object\Collection;
use Micro\Library\DTO\Preparation\PreparationProcessorInterface;

class Serializer implements SerializerInterface
{
    /**
     * {@inheritDoc}
     */
    public function fromJsonTransfer(string $jsonDto): AbstractDto
    {
        $dtoArray = json_decode($jsonDto);
        if(!$dtoArray) {
            throw new UnserializeException(sprintf('Invalid type. Data %s', $jsonDto));
        }

        return $this->fromArrayTransfer($dtoArray);
    }

    /**
     * {@inheritDoc}
     */
    public function fromArrayTransfer(array $itemData): AbstractDto
    {
        $t = $itemData[self::SECTION_TYPE] ?? false;
        if(!$t || !is_a($t, AbstractDto::class, true)) {
            throw new UnserializeException(sprintf('Invalid type. Data %s', json_encode($itemData, JSON_PRETTY_PRINT)));
        }
        /** @var AbstractDto $object */
        $object = new $t();

        $d = $itemData[self::SECTION_D] ?? [];
        foreach ($d as $propertyName => $propertyMeta) {
            $propertyType = $propertyMeta[self::SECTION_TYPE] ?? false;
            $propertyData = $propertyMeta[self::SECTION_D] ?? null;
            $isPropertyObject = class_exists($propertyType);
            if(!$propertyType) {
                throw new UnserializeException(sprintf('Invalid type. Data %s', json_encode($itemData, JSON_PRETTY_PRINT)));
            }

            if($isPropertyObject && is_a($propertyType, AbstractDto::class, true)) {
                $tmpV = $this->createSelf()->fromArrayTransfer($propertyData);
                $object->offsetSet($propertyName, $tmpV);

                continue;
            }

            if($isPropertyObject && is_a($propertyType,Collection::class, true)) {
                $collectionItems = [];

                foreach ($propertyData as $collectionItem) {
                    $collectionItemType = $collectionItem[self::SECTION_TYPE] ?? false;
                    if(!$collectionItemType) {
                        throw new UnserializeException(sprintf('Invalid collection item type "%s"', $propertyType));
                    }

                    if(is_a($collectionItemType, AbstractDto::class, true)) {
                        $collectionItems[] = $this->createSelf()->fromArrayTransfer($collectionItem);

                        continue;
                    }
                    $collectionItems[] = $collectionItem[self::SECTION_D];
                }

                $propertyData = $collectionItems;
            }

            $object->offsetSet($propertyName, $propertyData);
        }

        return $object;
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(AbstractDto $abstractDto, bool $serializeEmptyValues = true): array
    {
        $reflectionDto = new \ReflectionClass($abstractDto);
        $attributesMetadataReflection = $reflectionDto->getMethod(PreparationProcessorInterface::CLASS_PROPS_META_METHOD);
        $metadata = $attributesMetadataReflection->invoke($abstractDto);
        $resultArray = [];
        foreach ($metadata as $propertyName => $propertyMeta) {
            $value = $abstractDto->offsetGet($propertyName);
            $tmp = $value;
            if($value instanceof Collection) {
                $tmpColVal = null;
                foreach ($value as $item) {
                    if(!$tmpColVal) {
                        $tmpColVal = [];
                    }

                    if($item instanceof AbstractDto) {
                        $tmpColVal[] = $this->createSelf()->toArray($item, $serializeEmptyValues);

                        continue;
                    }

                    $tmpColVal []= $item;
                }

                $tmp = $tmpColVal;
            }

            if($value instanceof AbstractDto) {
                $tmp = $this->createSelf()->toArray($value, $serializeEmptyValues);
            }

            $resultArray[$propertyName] = $tmp;
        }

        return $resultArray;
    }

    /**
     * {@inheritDoc}
     */
    public function toJson(AbstractDto $abstractDto, bool $serializeEmptyValues = true, int $flags = 0): string
    {
        return json_encode($this->toArray($abstractDto, $serializeEmptyValues), $flags);
    }

    /**
     * {@inheritDoc}
     */
    public function toArrayTransfer(AbstractDto $abstractDto): array
    {
        $reflectionDto = new \ReflectionClass($abstractDto);
        $attributesMetadataReflection = $reflectionDto->getMethod(PreparationProcessorInterface::CLASS_PROPS_META_METHOD);

        $result = $attributesMetadataReflection->invoke($abstractDto);
        $resultProperties = [];

        foreach ($result as $propName => $meta) {
            $propertyConfig = [];
            $reflectionProperty = $reflectionDto->getProperty($propName);
            $value = $reflectionProperty->getValue($abstractDto);

            $propertyConfig[self::SECTION_TYPE] = $this->getPropertyType($value);
            if($value instanceof AbstractDto) {
                $value = $this->createSelf()->toArrayTransfer($value);
            }

            if($value instanceof Collection) {
                $tmpValue = null;

                foreach ($value as $item) {
                    if(!$tmpValue) {
                        $tmpValue = [];
                    }

                    if($item instanceof AbstractDto) {
                        $tmpValue[] = $this->createSelf()->toArrayTransfer($item);

                        continue;
                    }

                    $tmpValue[] = [
                        self::SECTION_TYPE => $this->getPropertyType($item),
                        self::SECTION_D => $item,
                    ];
                }

                $value = $tmpValue;
            }

            $propertyConfig[self::SECTION_D] = $value;
            $resultProperties[$propName] = $propertyConfig;
        }

        $resultArray = [
            self::SECTION_TYPE    => $reflectionDto->getName(),
            self::SECTION_D => $resultProperties,
        ];

        return $resultArray;
    }

    /**
     * {@inheritDoc}
     */
    public function toJsonTransfer(AbstractDto $abstractDto,int $flags = 0): string
    {
        return json_encode($this->toArrayTransfer($abstractDto), $flags);
    }

    protected function createSelf(): self
    {
        return new self();
    }

    protected function getPropertyType(mixed $value)
    {
        return is_scalar($value) || is_array($value) || is_null($value)? gettype($value) : get_class($value);
    }
}
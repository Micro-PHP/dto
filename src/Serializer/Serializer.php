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

namespace Micro\Library\DTO\Serializer;

use Micro\Library\DTO\Exception\SerializeException;
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
        $arrayDto = json_decode($jsonDto, true);
        if (!$arrayDto) {
            throw new UnserializeException(sprintf('Invalid DTO JSON data: %s', $jsonDto));
        }

        return $this->fromArrayTransfer($arrayDto);
    }

    /**
     * {@inheritDoc}
     */
    public function fromArrayTransfer(array $itemData): AbstractDto
    {
        /** @var class-string<AbstractDto>|null $t */
        $t = $itemData[self::SECTION_TYPE] ?? false;
        if (!$t || !is_a($t, AbstractDto::class, true)) {
            throw new UnserializeException(sprintf('Invalid type. Data %s', json_encode($itemData, \JSON_PRETTY_PRINT)));
        }
        /**
         * @var AbstractDto $object
         *
         * @psalm-suppress UnsafeInstantiation
         */
        $object = new $t();

        $d = $itemData[self::SECTION_D] ?? [];
        foreach ($d as $propertyName => $propertyMeta) {
            $propertyType = $propertyMeta[self::SECTION_TYPE] ?? false;
            $propertyData = $propertyMeta[self::SECTION_D] ?? null;
            $isPropertyObject = !(false === $propertyType) && class_exists($propertyType);
            if (!$propertyType) {
                throw new UnserializeException(sprintf('Invalid type. Data %s', json_encode($itemData, \JSON_PRETTY_PRINT)));
            }

            if ($isPropertyObject && is_a($propertyType, \DateTimeInterface::class, true)) {
                $tmpV = new $propertyType($propertyData);
                $object->offsetSet($propertyName, $tmpV);

                continue;
            }

            if ($propertyData && $isPropertyObject && is_a($propertyType, AbstractDto::class, true)) {
                $tmpV = $this->createSelf()->fromArrayTransfer($propertyData);
                $object->offsetSet($propertyName, $tmpV);

                continue;
            }

            if ($propertyData && $isPropertyObject && is_a($propertyType, Collection::class, true)) {
                $collectionItems = [];

                foreach ($propertyData as $collectionItem) {
                    $collectionItemType = $collectionItem[self::SECTION_TYPE] ?? false;
                    if (!$collectionItemType) {
                        throw new UnserializeException(sprintf('Invalid collection item type "%s"', \is_object($propertyType) ? \get_class($propertyType) : $propertyType));
                    }

                    if (is_a($collectionItemType, \DateTimeInterface::class, true)) {
                        $collectionItems[] = new $collectionItemType($collectionItem);

                        continue;
                    }

                    if (is_a($collectionItemType, AbstractDto::class, true)) {
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

    public function toArray(AbstractDto $abstractDto, bool $serializeEmptyValues = true): array
    {
        $reflectionDto = new \ReflectionClass($abstractDto);
        $attributesMetadataReflection = $reflectionDto->getMethod(PreparationProcessorInterface::CLASS_PROPS_META_METHOD);
        $attributesMetadataReflection->setAccessible(true);
        $metadata = $attributesMetadataReflection->invoke($reflectionDto);
        $attributesMetadataReflection->setAccessible(false);
        $resultArray = [];
        foreach ($metadata as $propertyName => $propertyMeta) {
            $value = $abstractDto->offsetGet($propertyName);
            $tmp = $value;
            if ($value instanceof Collection) {
                $tmpColVal = null;
                foreach ($value as $item) {
                    if (!$tmpColVal) {
                        $tmpColVal = [];
                    }

                    if ($item instanceof AbstractDto) {
                        $tmpColVal[] = $this->createSelf()->toArray($item, $serializeEmptyValues);

                        continue;
                    }

                    $tmpColVal[] = $item;
                }

                $tmp = $tmpColVal;
            }

            if ($value instanceof AbstractDto) {
                $tmp = $this->createSelf()->toArray($value, $serializeEmptyValues);
            }

            $resultArray[$propertyName] = $tmp;
        }

        return $resultArray;
    }

    public function toJson(AbstractDto $abstractDto, bool $serializeEmptyValues = true, int $flags = 0): string
    {
        $json = json_encode($this->toArray($abstractDto, $serializeEmptyValues), $flags);
        if (!$json) {
            throw new SerializeException();
        }

        return $json;
    }

    public function toArrayTransfer(AbstractDto $abstractDto): array
    {
        $reflectionDto = new \ReflectionClass($abstractDto);
        $attributesMetadataReflection = $reflectionDto->getMethod(PreparationProcessorInterface::CLASS_PROPS_META_METHOD);
        $attributesMetadataReflection->setAccessible(true);
        $result = $attributesMetadataReflection->invoke($abstractDto);
        $attributesMetadataReflection->setAccessible(false);
        $resultProperties = [];

        foreach ($result as $propName => $meta) {
            $propertyConfig = [];
            $reflectionProperty = $reflectionDto->getProperty($propName);
            $reflectionProperty->setAccessible(true);
            $value = $reflectionProperty->getValue($abstractDto);
            $reflectionProperty->setAccessible(false);

            $propertyConfig[self::SECTION_TYPE] = $this->getPropertyType($value);
            if ($value instanceof AbstractDto) {
                $value = $this->createSelf()->toArrayTransfer($value);
            }

            if ($value instanceof \DateTimeInterface) {
                $value = $this->serializeDateTimeObject($value);
            }

            if ($value instanceof Collection) {
                $tmpValue = null;

                foreach ($value as $item) {
                    if (!$tmpValue) {
                        $tmpValue = [];
                    }

                    if ($item instanceof \DateTimeInterface) {
                        $item = $this->serializeDateTimeObject($item);
                    }

                    if ($item instanceof AbstractDto) {
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

        return [
            self::SECTION_TYPE => $reflectionDto->getName(),
            self::SECTION_D => $resultProperties,
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function toJsonTransfer(AbstractDto $abstractDto, int $flags = 0): string
    {
        $result = json_encode($this->toArrayTransfer($abstractDto), $flags);
        if (!$result) {
            throw new SerializeException();
        }

        return $result;
    }

    /**
     * @param \DateTimeInterface $dateTime
     *
     * @return string
     */
    protected function serializeDateTimeObject(\DateTimeInterface $dateTime): string
    {
        return $dateTime->format('c');
    }

    protected function createSelf(): self
    {
        return new self();
    }

    protected function getPropertyType(mixed $value): string
    {
        if (\is_object($value)) {
            return \get_class($value);
        }

        return \gettype($value);
    }
}

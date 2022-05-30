<?php

namespace Micro\Library\DTO\Serializer;

use Micro\Library\DTO\Object\AbstractDto;
use Micro\Library\DTO\Preparation\PreparationProcessorInterface;

class Serializer implements SerializerInterface
{

    const CLASS_NAME = 'c';
    const CLASS_ATTRIBUTES = 'd';
    /**
     * @param AbstractDto $abstractDto
     */
    public function __construct(private readonly AbstractDto $abstractDto)
    {

    }

    /**
     * {@inheritDoc}
     */
    public function toArray(bool $serializeEmptyValues = true): array
    {
        $reflectionDto = new \ReflectionClass($this->abstractDto);
        $attributesMetadataReflection = $reflectionDto->getMethod(PreparationProcessorInterface::CLASS_PROPS_META_METHOD);

        $result = $attributesMetadataReflection->invoke($this->abstractDto);
        $resultProperties = [];

        foreach ($result as $propName => $meta) {
            $propertyConfig = [];
            $reflectionProperty = $reflectionDto->getProperty($propName);
            $value = $reflectionProperty->getValue($this->abstractDto);

            $propertyConfig['t'] = is_scalar($value) || is_array($value) ? gettype($value) : get_class($value);
            if($value instanceof AbstractDto) {
                $value = (new self($value))->toArray($serializeEmptyValues);
            }

            $propertyConfig['v'] = $value;
            $resultProperties[$propName] = $propertyConfig;
        }

        $resultArray = [
            self::CLASS_NAME    => $reflectionDto->getName(),
            self::CLASS_ATTRIBUTES => $resultProperties,
        ];

        return $result;
    }

    /**
     * {@inheritDoc}
     */
    public function toJson(bool $serializeEmptyValues = true): string
    {
        // TODO: Implement toJson() method.
    }
}
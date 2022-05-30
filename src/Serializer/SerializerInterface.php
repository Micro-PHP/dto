<?php

namespace Micro\Library\DTO\Serializer;

use Micro\Library\DTO\Object\AbstractDto;

interface SerializerInterface
{
    /**
     * @param bool $serializeEmptyValues
     *
     * @return array
     */
    public function toArray(bool $serializeEmptyValues = true): array;

    /**
     * @param bool $serializeEmptyValues
     *
     * @return string
     */
    public function toJson(bool $serializeEmptyValues = true): string;
}
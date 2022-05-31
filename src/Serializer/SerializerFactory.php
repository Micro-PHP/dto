<?php

namespace Micro\Library\DTO\Serializer;

use Micro\Library\DTO\Object\AbstractDto;

class SerializerFactory implements SerializerFactoryInterface
{
    /**
     * @param AbstractDto $abstractDto
     *
     * @return SerializerInterface
     */
    public function create(AbstractDto $abstractDto): SerializerInterface
    {
        return new Serializer($abstractDto);
    }
}
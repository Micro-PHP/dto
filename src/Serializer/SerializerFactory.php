<?php

namespace Micro\Library\DTO\Serializer;

class SerializerFactory implements SerializerFactoryInterface
{
    /**
     * @return SerializerInterface
     */
    public function create(): SerializerInterface
    {
        return new Serializer();
    }
}
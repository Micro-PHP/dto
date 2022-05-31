<?php

namespace Micro\Library\DTO\Serializer;


class SerializerFactory implements SerializerFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function create(): SerializerInterface
    {
        return new Serializer();
    }
}
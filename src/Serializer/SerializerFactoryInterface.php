<?php

namespace Micro\Library\DTO\Serializer;

interface SerializerFactoryInterface
{
    /**
     * @return SerializerInterface
     */
    public function create(): SerializerInterface;
}
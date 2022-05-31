<?php

namespace Micro\Library\DTO\Serializer;

use Micro\Library\DTO\Object\AbstractDto;

interface SerializerFactoryInterface
{
    /**
     * @param AbstractDto $abstractDto
     * @return SerializerInterface
     */
    public function create(AbstractDto $abstractDto): SerializerInterface;
}
<?php

namespace Micro\Library\DTO;

use Micro\Library\DTO\Serializer\SerializerFactory;

class SerializerFacadeDefault extends SerializerFacade
{
    public function __construct()
    {
        parent::__construct(new SerializerFactory());
    }
}
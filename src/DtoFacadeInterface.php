<?php

namespace Micro\Library\DTO;

interface DtoFacadeInterface
{
    /**
     * @return GeneratorFacadeInterface
     */
    public function createGenerator(): GeneratorFacadeInterface;

    /**
     * @return SerializerFacadeInterface
     */
    public function createSerializer(): SerializerFacadeInterface;
}
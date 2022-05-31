<?php

namespace Micro\Library\DTO;

use Micro\Library\DTO\Object\AbstractDto;

interface SerializerFacadeInterface
{
    /**
     * @param AbstractDto $dto
     * @param bool $serializeEmptyValues
     *
     * @return array
     */
    public function toArray(AbstractDto $dto, bool $serializeEmptyValues = true): array;

    /**
     * @param AbstractDto $dto
     *
     * @return array
     */
    public function toArrayTransfer(AbstractDto $dto): array;

    /**
     * @param AbstractDto $dto
     * @param int $flags JSON_* serialization parameters.
     *
     * @return string
     */
    public function toJsonTransfer(AbstractDto $dto, int $flags = 0): string;

    /**
     * @param AbstractDto $dto
     * @param bool $serializeEmptyValues
     * @param int $flags
     *
     * @return string
     */
    public function toJson(AbstractDto $dto, bool $serializeEmptyValues = true, int $flags = 0): string;
}
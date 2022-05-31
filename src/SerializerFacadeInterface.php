<?php

namespace Micro\Library\DTO;

use Micro\Library\DTO\Exception\SerializeException;
use Micro\Library\DTO\Exception\UnserializeException;
use Micro\Library\DTO\Object\AbstractDto;

interface SerializerFacadeInterface
{
    /**
     * @param array $itemData
     *
     * @return AbstractDto
     *
     * @throws UnserializeException
     */
    public function fromArrayTransfer(array $itemData): AbstractDto;

    /**
     * @param string $jsonDto
     *
     * @return AbstractDto
     *
     * @throws UnserializeException
     */
    public function fromJsonTransfer(string $jsonDto): AbstractDto;

    /**
     * @param AbstractDto $dto
     * @param bool $serializeEmptyValues
     *
     * @return array
     *
     * @throws SerializeException
     */
    public function toArray(AbstractDto $dto, bool $serializeEmptyValues = true): array;

    /**
     * @param AbstractDto $dto
     *
     * @return array
     *
     * @throws SerializeException
     */
    public function toArrayTransfer(AbstractDto $dto): array;

    /**
     * @param AbstractDto $dto
     * @param int $flags JSON_* serialization parameters.
     *
     * @return string
     *
     * @throws SerializeException
     */
    public function toJsonTransfer(AbstractDto $dto, int $flags = 0): string;

    /**
     * @param AbstractDto $dto
     * @param bool $serializeEmptyValues
     * @param int $flags
     *
     * @return string
     *
     * @throws SerializeException
     */
    public function toJson(AbstractDto $dto, bool $serializeEmptyValues = true, int $flags = 0): string;
}
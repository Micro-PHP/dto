<?php

namespace Micro\Library\DTO\Serializer;

use Micro\Library\DTO\Exception\SerializeException;
use Micro\Library\DTO\Exception\UnserializeException;
use Micro\Library\DTO\Object\AbstractDto;

interface SerializerInterface
{
    const SECTION_TYPE = 't';
    const SECTION_D = 'd';

    /**
     * @param AbstractDto $abstractDto
     * @param bool $serializeEmptyValues
     *
     * @return array
     *
     * @throws SerializeException
     */
    public function toArray(AbstractDto $abstractDto, bool $serializeEmptyValues = true): array;

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
     * @param AbstractDto $abstractDto
     * @return array
     *
     * @throws SerializeException
     */
    public function toArrayTransfer(AbstractDto $abstractDto): array;

    /**
     * @param AbstractDto $abstractDto
     * @param int $flags JSON_* serialization parameters.
     *
     * @return string
     *
     * @throws SerializeException
     */
    public function toJsonTransfer(AbstractDto $abstractDto, int $flags = 0): string;

    /**
     * @param AbstractDto $abstractDto
     * @param bool $serializeEmptyValues
     * @param int $flags
     *
     * @return string
     *
     * @throws SerializeException
     */
    public function toJson(AbstractDto $abstractDto, bool $serializeEmptyValues = true, int $flags = 0): string;
}
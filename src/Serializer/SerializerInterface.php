<?php

declare(strict_types=1);

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Library\DTO\Serializer;

use Micro\Library\DTO\Exception\SerializeException;
use Micro\Library\DTO\Exception\UnserializeException;
use Micro\Library\DTO\Object\AbstractDto;

interface SerializerInterface
{
    public const SECTION_TYPE = 't';
    public const SECTION_D = 'd';

    /**
     * @param AbstractDto $abstractDto
     * @param bool        $serializeEmptyValues
     *
     * @throws SerializeException
     *
     * @return array<string|int, mixed>
     */
    public function toArray(AbstractDto $abstractDto, bool $serializeEmptyValues = true): array;

    /**
     * @param array<string, mixed> $itemData
     *
     * @throws UnserializeException
     *
     * @return AbstractDto
     */
    public function fromArrayTransfer(array $itemData): AbstractDto;

    /**
     * @param string $jsonDto
     *
     * @throws UnserializeException
     *
     * @return AbstractDto
     */
    public function fromJsonTransfer(string $jsonDto): AbstractDto;

    /**
     * @param AbstractDto $abstractDto
     *
     * @throws SerializeException
     *
     * @return array<string, mixed>
     */
    public function toArrayTransfer(AbstractDto $abstractDto): array;

    /**
     * @param AbstractDto $abstractDto
     * @param int         $flags       JSON_* serialization parameters.
     *
     * @throws SerializeException
     *
     * @return string
     */
    public function toJsonTransfer(AbstractDto $abstractDto, int $flags = 0): string;

    /**
     * @param AbstractDto $abstractDto
     * @param bool        $serializeEmptyValues
     * @param int         $flags
     *
     * @throws SerializeException
     *
     * @return string
     */
    public function toJson(AbstractDto $abstractDto, bool $serializeEmptyValues = true, int $flags = 0): string;
}

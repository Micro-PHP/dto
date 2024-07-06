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
     * @throws SerializeException
     *
     * @return array<string|int, mixed>
     */
    public function toArray(AbstractDto $abstractDto, bool $serializeEmptyValues = true): array;

    /**
     * @param array<string, mixed> $itemData
     *
     * @throws UnserializeException
     */
    public function fromArrayTransfer(array $itemData): AbstractDto;

    /**
     * @throws UnserializeException
     */
    public function fromJsonTransfer(string $jsonDto): AbstractDto;

    /**
     * @throws SerializeException
     *
     * @return array<string, mixed>
     */
    public function toArrayTransfer(AbstractDto $abstractDto): array;

    /**
     * @param int $flags JSON_* serialization parameters.
     *
     * @throws SerializeException
     */
    public function toJsonTransfer(AbstractDto $abstractDto, int $flags = 0): string;

    /**
     * @throws SerializeException
     */
    public function toJson(AbstractDto $abstractDto, bool $serializeEmptyValues = true, int $flags = 0): string;
}

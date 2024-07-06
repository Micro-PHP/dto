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

namespace Micro\Library\DTO;

use Micro\Library\DTO\Exception\UnserializeException;
use Micro\Library\DTO\Object\AbstractDto;
use Micro\Library\DTO\Serializer\SerializerFactoryInterface;

class SerializerFacade implements SerializerFacadeInterface
{
    public function __construct(
        private readonly SerializerFactoryInterface $serializerFactory
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(AbstractDto $abstractDto, bool $serializeEmptyValues = true): array
    {
        return $this->serializerFactory->create()->toArray($abstractDto, $serializeEmptyValues);
    }

    public function toArrayTransfer(AbstractDto $abstractDto): array
    {
        return $this->serializerFactory->create()->toArrayTransfer($abstractDto);
    }

    /**
     * {@inheritDoc}
     */
    public function toJsonTransfer(AbstractDto $abstractDto, int $flags = 0): string
    {
        return $this->serializerFactory->create()->toJsonTransfer($abstractDto, $flags);
    }

    public function toJson(AbstractDto $abstractDto, bool $serializeEmptyValues = true, int $flags = 0): string
    {
        return $this->serializerFactory->create()->toJson($abstractDto, $serializeEmptyValues, $flags);
    }

    /**
     * @param array<string, mixed> $itemData
     *
     * @throws UnserializeException
     */
    public function fromArrayTransfer(array $itemData): AbstractDto
    {
        return $this->serializerFactory->create()->fromArrayTransfer($itemData);
    }

    /**
     * {@inheritDoc}
     */
    public function fromJsonTransfer(string $jsonDto): AbstractDto
    {
        return $this->serializerFactory->create()->fromJsonTransfer($jsonDto);
    }
}

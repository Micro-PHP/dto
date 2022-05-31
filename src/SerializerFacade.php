<?php

namespace Micro\Library\DTO;

use Micro\Library\DTO\Object\AbstractDto;
use Micro\Library\DTO\Serializer\SerializerFactoryInterface;

class SerializerFacade implements SerializerFacadeInterface
{
    /**
     * @param SerializerFactoryInterface $serializerFactory
     */
    public function __construct(private readonly SerializerFactoryInterface $serializerFactory)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(AbstractDto $dto, bool $serializeEmptyValues = true): array
    {
        return $this->serializerFactory->create($dto)->toArray($serializeEmptyValues);
    }

    /**
     * {@inheritDoc}
     */
    public function toArrayTransfer(AbstractDto $dto): array
    {
        return $this->serializerFactory->create($dto)->toArrayTransfer();
    }

    /**
     * {@inheritDoc}
     */
    public function toJsonTransfer(AbstractDto $dto, int $flags = 0): string
    {
        return $this->serializerFactory->create($dto)->toJsonTransfer($flags);
    }

    /**
     * {@inheritDoc}
     */
    public function toJson(AbstractDto $dto, bool $serializeEmptyValues = true, int $flags = 0): string
    {
        return $this->serializerFactory->create($dto)->toJson($serializeEmptyValues, $flags);
    }
}
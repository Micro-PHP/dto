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
        return $this->serializerFactory->create()->toArray($dto, $serializeEmptyValues);
    }

    /**
     * {@inheritDoc}
     */
    public function toArrayTransfer(AbstractDto $dto): array
    {
        return $this->serializerFactory->create()->toArrayTransfer($dto);
    }

    /**
     * {@inheritDoc}
     */
    public function toJsonTransfer(AbstractDto $dto, int $flags = 0): string
    {
        return $this->serializerFactory->create()->toJsonTransfer($dto, $flags);
    }

    /**
     * {@inheritDoc}
     */
    public function toJson(AbstractDto $dto, bool $serializeEmptyValues = true, int $flags = 0): string
    {
        return $this->serializerFactory->create()->toJson($dto, $serializeEmptyValues, $flags);
    }

    /**
     * {@inheritDoc}
     */
    public function fromArrayTransfer(array $itemData): AbstractDto
    {
        return $this->serializerFactory->create()->fromArrayTransfer($itemData);
    }
}
<?php

declare(strict_types=1);


namespace Micro\Library\DTO\Preparation\Processor\Property\Assert;


use Symfony\Component\Validator\Constraints\Isbn;

class IsbnStrategy extends AbstractConstraintStrategy
{
    protected function generateArguments(array $config): array
    {
        return array_filter([
            ...parent::generateArguments($config),
            'type'  => $config['type'] ?? null,
            'isbn10Message'    => $config['message_isbn_10'] ?? null,
            'isbn13Message' => $config['message_isbn_13'] ?? null,
            'bothIsbnMessage' => $config['message_isbn_both'] ?? null,
        ]);
    }

    protected function getValidatorProperty(): string
    {
        return 'isbn';
    }

    protected function getAttributeClassName(): string
    {
        return Isbn::class;
    }
}

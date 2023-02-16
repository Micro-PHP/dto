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

namespace Micro\Library\DTO\Preparation\Processor\Property\Assert;

use Symfony\Component\Validator\Constraints\Isbn;

class IsbnStrategy extends AbstractConstraintStrategy
{
    protected function generateArguments(array $config): array
    {
        $parent = parent::generateArguments($config);
        $current = [
            'type' => $config['type'] ?? null,
            'isbn10Message' => $config['message_isbn_10'] ?? null,
            'isbn13Message' => $config['message_isbn_13'] ?? null,
            'bothIsbnMessage' => $config['message_isbn_both'] ?? null,
        ];

        return array_filter(array_merge($parent, $current));
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

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

use Symfony\Component\Validator\Constraints\Url;

class UrlStrategy extends AbstractConstraintStrategy
{
    protected function generateArguments(array $config): array
    {
        $parentArgs = parent::generateArguments($config);
        // TODO: protocols

        return [
            ...$parentArgs,
            'relativeProtocol' => $this->stringToBool($config['is_relative'] ?? 'false'),
        ];
    }

    protected function getValidatorProperty(): string
    {
        return 'url';
    }

    protected function getAttributeClassName(): string
    {
        return Url::class;
    }
}

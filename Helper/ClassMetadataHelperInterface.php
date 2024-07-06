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

namespace Micro\Library\DTO\Helper;

use Micro\Library\DTO\Object\AbstractDto;

interface ClassMetadataHelperInterface
{
    public const PROPERTY_TYPE_ABSTRACT = 'abstract';
    public const PROPERTY_TYPE_ABSTRACT_CLASS = AbstractDto::class;

    public function generateNamespace(string $className): string;

    public function generateClassname(string $className): string;

    public function generateClassnameShort(string $className): string;
}

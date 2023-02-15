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

namespace Micro\Library\DTO\Reader;

interface ReaderInterface
{
    public const TAG_CLASS_DEFINITION = 'class';
    public const PROP_CLASS_NAME = 'className';
    public const PROP_CLASS_DESCRIPTION = 'description';
    public const PROP_CLASS_DEPRECATED = 'deprecated';
    public const PROP_CLASS_MODULE = 'deprecated';
    public const PROP_PROP_TYPE = 'type';
    public const PATH_PROP = 'properties';
    public const PROP_PROP_NAME = 'name';

    /**
     * @return iterable<mixed>
     */
    public function read(): iterable;
}

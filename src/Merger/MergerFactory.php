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

namespace Micro\Library\DTO\Merger;

class MergerFactory implements MergerFactoryInterface
{
    public function create(array $classCollection): MergerInterface
    {
        return new Merger($classCollection);
    }
}

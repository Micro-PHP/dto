<?php

/**
 * This file is auto-generated.
 */

declare(strict_types=1);

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Library\DTO\Tests\Simple;

use Micro\Library\DTO\Object\AbstractDto;

final class SimpleUserTransfer extends AbstractDto
{
    protected SimpleObjectTransfer|null $parent = null;

    public function getParent(): SimpleObjectTransfer|null
    {
        return $this->parent;
    }

    public function setParent(SimpleObjectTransfer|null $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    protected static function attributesMetadata(): array
    {
        return [
            'parent' => [
                'type' => [
                    0 => 'Transfer\\Simple\\SimpleObjectTransfer',
                    1 => 'null',
                ],
                'required' => false,
                'actionName' => 'parent',
            ],
        ];
    }
}

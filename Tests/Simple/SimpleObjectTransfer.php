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

final class SimpleObjectTransfer extends AbstractDto
{
    protected int|null $weight = null;
    protected int|null $height = null;
    protected SimpleObjectTransfer|null $parent = null;

    public function getWeight(): int|null
    {
        return $this->weight;
    }

    public function getHeight(): int|null
    {
        return $this->height;
    }

    public function getParent(): self|null
    {
        return $this->parent;
    }

    public function setWeight(int|null $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    public function setHeight(int|null $height): self
    {
        $this->height = $height;

        return $this;
    }

    public function setParent(self|null $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    protected static function attributesMetadata(): array
    {
        return [
            'weight' => [
                'type' => [
                    0 => 'int',
                    1 => 'null',
                ],
                'required' => false,
                'actionName' => 'weight',
            ],
            'height' => [
                'type' => [
                    0 => 'int',
                    1 => 'null',
                ],
                'required' => false,
                'actionName' => 'height',
            ],
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

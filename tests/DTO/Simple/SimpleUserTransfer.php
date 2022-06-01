<?php

/**
 * This file is auto-generated.
 */

declare(strict_types=1);

namespace TransferTest\Simple;

use DateTimeInterface;

final class SimpleUserTransfer extends \Micro\Library\DTO\Object\AbstractDto
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
        return array (
          'parent' =>
          array (
            'type' =>
            array (
              0 => 'Transfer\\Simple\\SimpleObjectTransfer',
              1 => 'null',
            ),
            'required' => false,
            'actionName' => 'parent',
          ),
        );
    }
}

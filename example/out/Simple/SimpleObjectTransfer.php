<?php

/**
 * This file is auto-generated.
 */

declare(strict_types=1);

namespace Transfer\Simple;

use DateTimeInterface;
use Transfer\Simple\SimpleObjectTransfer as SimpleObjectTransfer1;

final class SimpleObjectTransfer extends \Micro\Library\DTO\Object\AbstractDto
{
    #[\Symfony\Component\Validator\Constraints\LessThan(groups: ['Default'], value: 10)]
    protected int|null $weight = null;

    #[\Symfony\Component\Validator\Constraints\LessThan(groups: ['Default'], propertyPath: 'weight')]
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

    public function getParent(): SimpleObjectTransfer|null
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

    public function setParent(SimpleObjectTransfer|null $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    protected static function attributesMetadata(): array
    {
        return array (
          'weight' =>
          array (
            'type' =>
            array (
              0 => 'int',
              1 => 'null',
            ),
            'required' => false,
            'actionName' => 'weight',
          ),
          'height' =>
          array (
            'type' =>
            array (
              0 => 'int',
              1 => 'null',
            ),
            'required' => false,
            'actionName' => 'height',
          ),
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

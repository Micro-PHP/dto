<?php

namespace Micro\Library\DTO\Helper;

interface NameNormalizerInterface
{
    /**
     * @param string $name
     *
     * @return string
     */
    public function normalize(string $name): string;
}
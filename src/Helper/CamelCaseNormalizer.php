<?php

namespace Micro\Library\DTO\Helper;

class CamelCaseNormalizer implements NameNormalizerInterface
{
    public function normalize(string $name): string
    {
        return lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $name))));
    }
}
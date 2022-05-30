<?php

namespace Micro\Library\DTO\ClassDef;

class MethodArgDefinition
{
    private string $name;
    private iterable $types = [];
    private iterable $returnTypes = [];
    private bool $isRequired = false;
}
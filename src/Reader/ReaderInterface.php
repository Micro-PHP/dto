<?php

namespace Micro\Library\DTO\Reader;

use Micro\Library\DTO\Definition\DefinitionClass;


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
     * @return array<string, array>
     */
    public function read(): iterable;
}
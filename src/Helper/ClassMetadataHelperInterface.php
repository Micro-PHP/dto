<?php

namespace Micro\Library\DTO\Helper;

use Micro\Library\DTO\Object\AbstractDto;

interface ClassMetadataHelperInterface
{

    public const PROPERTY_TYPE_ABSTRACT = 'abstract';
    public const PROPERTY_TYPE_ABSTRACT_CLASS = AbstractDto::class;

    /**
     * @param string $className
     *
     * @return string
     */
    public function generateNamespace(string $className): string;

    /**
     * @param string $className
     *
     * @return string
     */
    public function generateClassname(string $className): string;

    /**
     * @param string $className
     *
     * @return string
     */
    public function generateClassnameShort(string $className): string;
}
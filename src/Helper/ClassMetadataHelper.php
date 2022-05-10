<?php

namespace Micro\Library\DTO\Helper;

class ClassMetadataHelper
{
    /**
     * @param string $namespaceGeneral
     */
    public function __construct(private readonly string $namespaceGeneral)
    {
    }

    /**
     * @return string
     */
    public function getNamespaceGeneral(): string
    {
        return $this->namespaceGeneral;
    }

    /**
     * @param string $className
     *
     * @return string
     */
    public function generateNamespace(string $className): string
    {
        $exploded = explode('\\', $className);
        if(count($exploded) === 1) {
            return $this->namespaceGeneral;
        }

        $namespaceExploded = [];
        if($this->namespaceGeneral) {
            $namespaceExploded[] = $this->namespaceGeneral;
        }

        $namespaceExploded = array_merge($namespaceExploded, $exploded);

        array_pop($namespaceExploded);

        return implode('\\', $namespaceExploded);
    }

    /**
     * @param string $className
     *
     * @return string
     */
    public function generateClassname(string $className)
    {
        return $this->generateNamespace($className) . '\\' . $this->generateClassnameShort($className);
    }

    /**
     * @param string $className
     *
     * @return string
     */
    public function generateClassnameShort(string $className): string
    {
        $exploded = explode('\\', $className);
        if(count($exploded) === 1) {
            return $className;
        }

        return array_pop($exploded);
    }
}
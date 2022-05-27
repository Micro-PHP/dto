<?php

namespace Micro\Library\DTO\Helper;

use Micro\Library\DTO\Object\AbstractDto;

class ClassMetadataHelper implements ClassMetadataHelperInterface
{
    /**
     * @param string $namespaceGeneral
     * @param string $classSuffix
     */
    public function __construct(
        private readonly string $namespaceGeneral,
        private readonly string $classSuffix
    )
    {
    }

    /**
     * {@inheritDoc}
     */
    public function generateNamespace(string $className): string
    {
        $exploded = explode('\\', $className);
        if(count($exploded) === 1) {
            return $this->namespaceGeneral;
        }

        $namespaceExploded = [];
        $shouldAddGeneralNamespace = $this->shouldAddGeneralNamespace($className);

        if($shouldAddGeneralNamespace && $this->namespaceGeneral) {
            $namespaceExploded[] = $this->namespaceGeneral;
        }

        $namespaceExploded = array_merge($namespaceExploded, $exploded);

        array_pop($namespaceExploded);

        return implode('\\', $namespaceExploded);
    }

    /**
     * {@inheritDoc}
     */
    public function generateClassname(string $className): string
    {
        if(!$this->shouldAddGeneralNamespace($className)) {
            return $className;
        }

        return $this->generateNamespace($className) . '\\' . $this->generateClassnameShort($className);
    }

    /**
     * {@inheritDoc}
     */
    public function generateClassnameShort(string $className): string
    {
        $shouldAddSuffix = $this->shouldAddGeneralNamespace($className);
        $exploded = explode('\\', $className);

        if(!$shouldAddSuffix) {
            return array_pop($exploded);
        }

        if(count($exploded) === 1) {
            return $className. ucfirst($this->classSuffix);
        }

        return array_pop($exploded) . ucfirst($this->classSuffix);
    }

    /**
     * @param string $classname
     *
     * @return bool
     */
    protected function shouldAddGeneralNamespace(string $classname): bool
    {
        if(mb_strtolower($classname) === self::PROPERTY_TYPE_ABSTRACT) {
            return false;
        }

        if(!class_exists($classname)) {
            return true;
        }

        if(str_starts_with($classname, $this->namespaceGeneral)) {
            return false;
        }

        if(is_a($classname, AbstractDto::class, true)) {
            return false;
        }

        if(is_a($classname, \DateTimeInterface::class, true)) {
            return false;
        }

        return true;
    }
}
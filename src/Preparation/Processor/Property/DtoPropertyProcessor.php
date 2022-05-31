<?php

namespace Micro\Library\DTO\Preparation\Processor\Property;

use Micro\Library\DTO\ClassDef\ClassDefinition;
use Micro\Library\DTO\ClassDef\PropertyDefinition;
use Micro\Library\DTO\Helper\ClassMetadataHelperInterface;

class DtoPropertyProcessor implements PropertyProcessorInterface
{
    public function __construct(private readonly ClassMetadataHelperInterface $classMetadataHelper)
    {
    }

    public function process(PropertyDefinition $propertyDefinition, ClassDefinition $classDefinition, array $propertyData, array $classList): void
    {
        $types = $propertyDefinition->getTypes();
        foreach ($types as $pos => $type) {
            if(!in_array($type, $classList, true)) {
                continue;
            }

            $classType = $this->classMetadataHelper->generateClassname($type);
            $classDefinition->addUseStatement($classType);
            $types[$pos] = $classType;
        }

        $propertyDefinition->setTypes(array_unique($types));
    }
}
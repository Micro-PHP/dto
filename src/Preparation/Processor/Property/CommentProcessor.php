<?php

namespace Micro\Library\DTO\Preparation\Processor\Property;

use Micro\Library\DTO\ClassDef\ClassDefinition;
use Micro\Library\DTO\ClassDef\PropertyDefinition;
use Micro\Library\DTO\Preparation\PreparationProcessorInterface;

class CommentProcessor implements PropertyProcessorInterface
{

    public function process(PropertyDefinition $propertyDefinition, ClassDefinition $classDefinition, array $propertyData, array $classList): void
    {
        $isDeprecated = $propertyData[PreparationProcessorInterface::DEPRECATED] ?? false;
        $description = $propertyData[PreparationProcessorInterface::DESCRIPTION] ?? '';

        if($description) {
            $propertyDefinition->addComment($description);
        }
        /*
        $propertyDefinition->addComment(
            sprintf('@var %s', implode(
                separator: '|',
                array: $propertyDefinition->getTypes())
            )
        );
        */

        if($isDeprecated !== false) {
            $propertyDefinition->addComment(sprintf('@deprecated %s', $isDeprecated));
        }
    }
}
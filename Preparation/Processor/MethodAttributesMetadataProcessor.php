<?php

declare(strict_types=1);

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Library\DTO\Preparation\Processor;

use Micro\Library\DTO\ClassDef\ClassDefinition;
use Micro\Library\DTO\ClassDef\MethodDefinition;
use Micro\Library\DTO\Helper\NameNormalizerInterface;
use Micro\Library\DTO\Preparation\PreparationProcessorInterface;

readonly class MethodAttributesMetadataProcessor implements PreparationProcessorInterface
{
    public function __construct(
        private NameNormalizerInterface $nameNormalizer
    ) {
    }

    public function process(array $classDef, ClassDefinition $classDefinition, array $classList): void
    {
        $metadataArray = [];
        foreach ($classDefinition->getProperties() as $property) {
            $meta = [];
            $meta[PreparationProcessorInterface::PROP_TYPE] = $property->getTypes();
            $meta[PreparationProcessorInterface::PROP_REQUIRED] = $property->isRequired();
            $meta[PreparationProcessorInterface::PROP_ACTION_NAME] = $this->nameNormalizer->normalize(ucfirst($property->getName()));

            $propertyName = $property->getName();
            $metadataArray[$propertyName] = $meta;
        }

        $attributesMetaMethod = new MethodDefinition();
        $attributesMetaMethod->setIsStatic(true);
        $attributesMetaMethod->setName('attributesMetadata');
        $attributesMetaMethod->setTypesReturn(['array']);
        $attributesMetaMethod->setVisibility('protected');
        $attributesMetaMethod->setBody(
            'return '.var_export($metadataArray, true).';'
        );

        $classDefinition->addMethod($attributesMetaMethod);
    }
}

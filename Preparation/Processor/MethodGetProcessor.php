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
use Micro\Library\DTO\ClassDef\PropertyDefinition;
use Micro\Library\DTO\Helper\NameNormalizerInterface;
use Micro\Library\DTO\Preparation\PreparationProcessorInterface;

readonly class MethodGetProcessor implements PreparationProcessorInterface
{
    public function __construct(
        private NameNormalizerInterface $nameNormalizer
    ) {
    }

    public function process(array $classDef, ClassDefinition $classDefinition, array $classList): void
    {
        $properties = $classDefinition->getProperties();
        foreach ($properties as $property) {
            $this->provideGetMethod($classDefinition, $property);
        }
    }

    protected function provideGetMethod(ClassDefinition $classDefinition, PropertyDefinition $propertyDefinition): void
    {
        $propertyName = $propertyDefinition->getName();
        $methodSuffix = $this->nameNormalizer->normalize($propertyName);
        $methodDefinition = new MethodDefinition();
        $methodDefinition->setName('get'.ucfirst($methodSuffix));
        $methodDefinition->setTypesReturn($propertyDefinition->getTypes());
        $methodDefinition->setVisibility('public');
        $methodDefinition->setBody(sprintf('return $this->%s;', $propertyName));
        // $methodDefinition->addComment(sprintf('@return %s', implode('|', $propertyDefinition->getTypes())));

        $classDefinition->addMethod($methodDefinition);
    }
}

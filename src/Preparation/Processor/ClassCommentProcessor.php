<?php

namespace Micro\Library\DTO\Preparation\Processor;

use Micro\Library\DTO\ClassDef\ClassDefinition;
use Micro\Library\DTO\Preparation\PreparationProcessorInterface;

class ClassCommentProcessor implements PreparationProcessorInterface
{

    public function process(iterable $classDef, ClassDefinition $classDefinition, array $classList): void
    {
        $opts = [
            self::DEPRECATED => '@deprecated',
            self::DESCRIPTION => null,
        ];

        foreach ($opts as $opt => $prefix) {
            $commentValue = $classDef[$opt] ?? false;
            if(!$commentValue) {
                continue;
            }

            $this->addComment($classDefinition, $commentValue, $prefix);
        }
    }

    /**
     * @param ClassDefinition $classDefinition
     * @param string $comment
     * @param string|null $commentPrefix
     * @return void
     */
    protected function addComment(ClassDefinition $classDefinition, string $comment, ?string $commentPrefix): void
    {
        $text = $commentPrefix ? $commentPrefix . ' ' . $comment: $comment;

        $classDefinition->addComment($text);
    }
}
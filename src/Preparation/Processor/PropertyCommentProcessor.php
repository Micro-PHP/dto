<?php

namespace Micro\Library\DTO\Preparation\Processor;

use Micro\Library\DTO\Preparation\PreparationProcessorInterface;

class PropertyCommentProcessor implements PreparationProcessorInterface
{

    /**
     * {@inheritDoc}
     */
    public function processClassCollection(iterable &$classDef): void
    {
        foreach ($classDef[self::SECTION_PROPERTIES] as &$propDef) {
            $comments = [];

            $this->addComment($comments, ($propDef[self::DESCRIPTION] ?? ''));
            $isCollection = $propDef[self::PROP_TYPE_IS_COLLECTION];
            $deprecated = $propDef[self::DEPRECATED] ?? '';
            if($deprecated) {
                $this->addComment($comments, '@deprecated ' . $deprecated);
            }

            $this->addComment(
                $comments,
                sprintf('@var %s',
                    (
                        $isCollection ? $propDef[self::PROP_TYPE] . '[]' : $propDef[self::PROP_TYPE_ARG]
                    ))
                );

            $propDef[self::PROP_COMMENTS] = $comments;
        }
    }

    protected function addComment(array &$comments, ?string $comment = null): void
    {
        if(!$comment) {
            return;
        }

        $comments[] = $comment;
    }
}
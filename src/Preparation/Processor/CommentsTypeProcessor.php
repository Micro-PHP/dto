<?php

namespace Micro\Library\DTO\Preparation\Processor;

use Micro\Library\DTO\Preparation\PreparationProcessorInterface;

class CommentsTypeProcessor implements PreparationProcessorInterface
{
    /**
     * {@inheritDoc}
     */
    public function processClassCollection(iterable &$classDef): void
    {
        foreach ($classDef[self::SECTION_PROPERTIES] as &$propDef) {
            $commentsMethodGet = [];
            $commentsMethodSet = [];
            $commentsProp = [];
            $commentsCommon = [];
            $isCollection = $propDef[self::PROP_TYPE_IS_COLLECTION] ?? false;

            $msg = $propDef[self::DESCRIPTION] ?? '';
            $this->addComment($commentsCommon, $msg);

            $deprecated = $propDef[self::DEPRECATED] ?? '';
            if($deprecated) {
                $msg = '@deprecated ' . $deprecated;
                $this->addComment($commentsCommon, $msg);
            }

            $this->addComment($commentsProp,
                '@var ' .
                ($isCollection ?
                    $propDef[self::PROP_TYPE] . '[]' :
                    $propDef[self::METHOD_TYPE_ARG]
                )
            );

            $this->addComment($commentsMethodSet, sprintf(
                '@param %s $%s',
                ($isCollection ? ($propDef[self::PROP_TYPE] .  '[]'): $propDef[self::METHOD_TYPE_ARG]),
                $propDef[self::PROP_NAME]
                ));

            $this->addComment($commentsMethodSet, '@return ' . $classDef[self::PROP_NAME]);
            $this->addComment($commentsMethodGet, '@return ' . $propDef[self::METHOD_TYPE_ARG]);

            $propDef[self::PROP_COMMENTS] = $commentsProp;
            $propDef[self::METHOD_SET_COMMENTS] = array_merge($commentsCommon, $commentsMethodSet);
            $propDef[self::METHOD_GET_COMMENTS] = array_merge($commentsCommon, $commentsMethodGet);
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
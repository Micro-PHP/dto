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
            if (!$commentValue) {
                continue;
            }

            $this->addComment($classDefinition, $commentValue, $prefix);
        }
    }

    protected function addComment(ClassDefinition $classDefinition, string $comment, ?string $commentPrefix): void
    {
        $text = $commentPrefix ? $commentPrefix.' '.$comment : $comment;

        $classDefinition->addComment($text);
    }
}

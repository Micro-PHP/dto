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

namespace Micro\Library\DTO\Preparation;

use Micro\Library\DTO\ClassDef\ClassDefinition;

interface PreparationProcessorInterface
{
    public const SECTION_PROPERTIES = 'property';

    public const PROP_ACTION_NAME = 'actionName';
    public const PROP_NAME = 'name';
    public const PROP_TYPE_IS_COLLECTION = 'is_collection';
    public const PROP_TYPE = 'type';
    public const PROP_TYPE_FULLNAME = 'type_full';
    public const PROP_TYPE_ARG = 'prop_type_arg';
    public const PROP_COMMENTS = 'prop_comments';
    public const PROP_REQUIRED = 'required';

    public const METHOD_TYPE_ARG = 'method_type_arg';
    public const METHOD_GET_COMMENTS = 'method_get_comments';
    public const METHOD_SET_COMMENTS = 'method_set_comments';
    public const METHOD_GET_BODY = 'method_get_body';
    public const METHOD_SET_BODY = 'method_set_body';
    public const METHOD_GET_RETURN_TYPE = 'method_get_type_return';

    public const DEPRECATED = 'deprecated';
    public const DESCRIPTION = 'description';

    public const CLASS_USE_STATEMENTS = 'useStatements';
    public const CLASS_NAMESPACE = 'namespace';
    public const CLASS_NAME = 'name';
    public const CLASS_PROPS_META = 'meta';

    public const CLASS_PROPS_META_METHOD = 'attributesMetadata';

    /**
     * @param array<string, mixed> $classDef
     * @param ClassDefinition      $classDefinition
     * @param class-string[]       $classList
     *
     * @return void
     */
    public function process(array $classDef, ClassDefinition $classDefinition, array $classList): void;
}

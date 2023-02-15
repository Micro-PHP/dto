<?php

if (!file_exists(__DIR__.'/src')) {
    exit(0);
}

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__.'/src')
    ->in(__DIR__.'/tests')
;

return (new PhpCsFixer\Config())
    ->setRules(array(
        '@Symfony' => true,
        '@Symfony:risky' => true,
        'protected_to_private' => false,
        'array_indentation' => true,
        'array_syntax' => ['syntax' => 'short'],
        'combine_consecutive_unsets' => true,
        'declare_strict_types' => true,
        'dir_constant' => true,
        'fully_qualified_strict_types' => true,
        'linebreak_after_opening_tag' => true,
        'mb_str_functions' => true,
        'modernize_types_casting' => true,
        'no_alternative_syntax' => true,
        'no_null_property_initialization' => true,
        'no_php4_constructor' => true,
        'no_superfluous_elseif' => true,
        'no_unreachable_default_argument_value' => true,
        'no_useless_else' => true,
        'no_useless_return' => true,
        'ordered_class_elements' => true,
        'ordered_imports' => true,
        'phpdoc_order' => true,
        'phpdoc_to_comment' => false,
        'phpdoc_types_order' => [
            'null_adjustment' => 'always_last',
            'sort_algorithm' => 'none'
        ],
        'php_unit_set_up_tear_down_visibility' => true,
        'pow_to_exponentiation' => true,
        'semicolon_after_instruction' => true,
        'ternary_to_null_coalescing' => true,
        'method_argument_space' => [
            'keep_multiple_spaces_after_comma' => true,
            'on_multiline' => 'ensure_fully_multiline',
            'after_heredoc' => true,
        ],
        'phpdoc_annotation_without_dot' => false,
        'phpdoc_var_without_name' => false,
        'phpdoc_trim' => true,
        'no_superfluous_phpdoc_tags' => false,
        'single_line_throw' => true,
        'header_comment' => [
            'header' => <<<EOF
 This file is part of the Micro framework package.
 
 (c) Stanislau Komar <kost@micro-php.net>
 
 For the full copyright and license information, please view the LICENSE
 file that was distributed with this source code.
EOF
        ]
    ))
    ->setRiskyAllowed(true)
    ->setFinder($finder);
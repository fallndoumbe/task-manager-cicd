<?php

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$finder = Finder::create()
    ->in([
        __DIR__ . '/app',
        __DIR__ . '/config',
        __DIR__ . '/database',
        __DIR__ . '/routes',
        __DIR__ . '/tests',
    ])
    ->name('*.php')
    ->notName('*.blade.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);

return (new Config())
    ->setRiskyAllowed(true)
    ->setRules([
        '@PSR12'                          => true,
        '@PHP82Migration'                 => true,
        'array_syntax'                    => ['syntax' => 'short'],
        'ordered_imports'                 => ['sort_algorithm' => 'alpha'],
        'no_unused_imports'               => true,
        'not_operator_with_successor_space' => true,
        'trailing_comma_in_multiline'     => true,
        'phpdoc_scalar'                   => true,
        'unary_operator_spaces'           => true,
        'binary_operator_spaces'          => ['default' => 'align_single_space_minimal'],
        'blank_line_before_statement'     => ['statements' => ['break', 'continue', 'declare', 'return', 'throw', 'try']],
        'class_attributes_separation'     => ['elements' => ['method' => 'one']],
        'method_argument_space'           => ['on_multiline' => 'ensure_fully_multiline', 'keep_multiple_spaces_after_comma' => true],
        'single_trait_insert_per_statement' => true,
    ])
    ->setFinder($finder)
    ->setCacheFile(__DIR__ . '/.php-cs-fixer.cache');

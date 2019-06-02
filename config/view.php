<?php

return [
    'template' => [
        'commands' => [
            'extends'                   => \App\Builder\Views\Commands\ExtendsCommand::class,
            'var'                       => \App\Builder\Views\Commands\VarCommand::class,
            'section'                   => \App\Builder\Views\Commands\SectionCommand::class,
            'yield'                     => \App\Builder\Views\Commands\YieldCommand::class,
            'show-validation-errors'    => \App\Builder\Views\Commands\ShowValidationErrorCommand::class,
        ],
        'remove_multiple_empty_lines' => true,
    ],
];
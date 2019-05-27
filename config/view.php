<?php

return [
    'template' => [
        'extends'                   => \App\Builder\Views\Commands\ExtendsCommand::class,
        'var'                       => \App\Builder\Views\Commands\VarCommand::class,
        'section'                   => \App\Builder\Views\Commands\SectionCommand::class,
        'yield'                     => \App\Builder\Views\Commands\YieldCommand::class,
        'show-validation-errors'    => \App\Builder\Views\Commands\ShowValidationErrorCommand::class,
    ],
];
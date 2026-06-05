<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Class Namespace
    |--------------------------------------------------------------------------
    |
    */

    'namespace' => 'Livewire',

    /*
    |--------------------------------------------------------------------------
    | View Path
    |--------------------------------------------------------------------------
    |
    */

    'view' => 'resources/views/livewire',

    /*
    |--------------------------------------------------------------------------
    | Custom modules setup
    |--------------------------------------------------------------------------
    |
    */

    'custom_modules' => [
        'Admin' => [
            'path' => base_path('modules/Admin'),
            'module_namespace' => 'Modules\\Admin'
        ],
        'Account' => [
            'path' => base_path('modules/Account'),
            'module_namespace' => 'Modules\\Account'
        ],
        'Donation' => [
            'path' => base_path('modules/Donation'),
            'module_namespace' => 'Modules\\Donation'
        ],
        'Poz' => [
            'path' => base_path('modules/Poz'),
            'module_namespace' => 'Modules\\Poz'
        ],
        'Management' => [
            'path' => base_path('modules/Management'),
            'module_namespace' => 'Modules\\Management'
        ],
        'Web' => [
            'path' => base_path('modules/Web'),
            'module_namespace' => 'Modules\\Web'
        ],
        'Portal' => [
            'path' => base_path('modules/Portal'),
            'module_namespace' => 'Modules\\Portal'
        ],
        'Editor' => [
            'path' => base_path('modules/Editor'),
            'module_namespace' => 'Modules\\Editor'
        ],
        'Cms' => [
            'path' => base_path('modules/Cms'),
            'module_namespace' => 'Modules\\Cms'
        ]
    ],

];

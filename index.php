<?php

use Pagekit\Application;
use Spqr\Redirect\Event\ExceptionListener;

return [
    'name' => 'spqr/redirect',
    'type' => 'extension',
    'main' => function (Application $app) {
    },
    
    'autoload' => [
        'Spqr\\Redirect\\' => 'src',
    ],
    
    'routes' => [],
    
    'widgets' => [],
    
    'menu' => [],
    
    'permissions' => [
        'redirect: manage settings' => [
            'title' => 'Manage settings',
        ],
    ],
    
    'settings' => 'redirect-settings',
    
    'resources' => [
        'spqr/redirect:' => '',
    ],
    
    'config' => [
        'unauthorized' => ['enabled' => false, 'url' => ''],
        'forbidden'    => ['enabled' => false, 'url' => ''],
        'notfound'     => ['enabled' => true, 'url' => ''],
    ],
    
    'events' => [
        'boot'         => function ($event, $app) {
            $app->subscribe(new ExceptionListener);
        },
        'site'         => function ($event, $app) {
        },
        'view.scripts' => function ($event, $scripts) use ($app) {
            $scripts->register('redirect-settings',
                'spqr/redirect:app/bundle/redirect-settings.js',
                ['~extensions', 'input-link']);
        },
    ],
];
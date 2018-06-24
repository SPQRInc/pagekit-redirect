<?php

use Pagekit\Application;
use Spqr\Redirect\Event\ExceptionListener;
use Spqr\Redirect\Event\RequestListener;
use Spqr\Redirect\Event\StatisticListener;

return [
    'name' => 'spqr/redirect',
    'type' => 'extension',
    'main' => function (Application $app) {
    },
    
    'autoload' => [
        'Spqr\\Redirect\\' => 'src',
    ],
    
    'nodes'  => [],
    'routes' => [
        '/redirect'     => [
            'name'       => '@redirect',
            'controller' => [
                'Spqr\\Redirect\\Controller\\RedirectController',
                'Spqr\\Redirect\\Controller\\TargetController',
                'Spqr\\Redirect\\Controller\\StatisticController',
            ],
        ],
        '/api/redirect' => [
            'name'       => '@redirect/api',
            'controller' => [
                'Spqr\\Redirect\\Controller\\TargetApiController',
                'Spqr\\Redirect\\Controller\\StatisticApiController',
            ],
        ],
    ],
    
    'widgets' => [],
    
    'menu' => [
        'redirect'             => [
            'label'  => 'Redirect',
            'url'    => '@redirect/target',
            'active' => '@redirect/target*',
            'icon'   => 'spqr/redirect:icon.svg',
        ],
        'redirect: targets'    => [
            'parent' => 'redirect',
            'label'  => 'Targets',
            'icon'   => 'spqr/redirect:icon.svg',
            'url'    => '@redirect/target',
            'access' => 'redirect: manage targets',
            'active' => '@redirect/target*',
        ],
        'redirect: statistics' => [
            'parent' => 'redirect',
            'label'  => 'Statistics',
            'icon'   => 'spqr/redirect:icon.svg',
            'url'    => '@redirect/statistic',
            'access' => 'redirect: manage statistics',
            'active' => '@redirect/statistic*',
        ],
        'redirect: settings'   => [
            'parent' => 'redirect',
            'label'  => 'Settings',
            'url'    => '@redirect/settings',
            'access' => 'redirect: manage settings',
        ],
    ],
    
    'permissions' => [
        'redirect: manage settings'   => [
            'title' => 'Manage settings',
        ],
        'redirect: manage targets'    => [
            'title' => 'Manage targets',
        ],
        'redirect: manage statistics' => [
            'title' => 'Manage statistics',
        ],
    ],
    
    'settings' => '@redirect/settings',
    
    'resources' => [
        'spqr/redirect:' => '',
    ],
    
    'config' => [
        'unauthorized'   => [
            'enabled'       => false,
            'frontend_only' => true,
            'type'          => 'html',
            'response'      => 401,
            'url'           => '',
            'html'          => '',
        ],
        'forbidden'      => [
            'enabled'       => false,
            'frontend_only' => true,
            'type'          => 'html',
            'response'      => 403,
            'url'           => '',
            'html'          => '',
        ],
        'notfound'       => [
            'enabled'       => false,
            'frontend_only' => true,
            'type'          => 'html',
            'response'      => 404,
            'url'           => '',
            'html'          => '',
        ],
        'statistics'     => [
            'collect_statistics' => true,
            'collect_referrer'   => true,
            'collect_called_url' => true,
            'collect_ip'         => false,
        ],
        'exclusions'     => [
            'ignore_url' => [],
            'ignore_ext' => [],
        ],
        'response'       => 301,
        'items_per_page' => 20,
    ],
    
    'events' => [
        'boot'         => function ($event, $app) {
            $app->subscribe(new ExceptionListener, new RequestListener,
                new StatisticListener);
        },
        'site'         => function ($event, $app) {
        },
        'view.scripts' => function ($event, $scripts) use ($app) {
            $scripts->register('target-url',
                'spqr/redirect:app/bundle/target-url.js', '~target-edit');
        },
    ],
];
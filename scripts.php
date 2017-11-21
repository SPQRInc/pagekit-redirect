<?php

return [
    
    /*
     * Installation hook
     *
     */
    'install'   => function ($app) {
    },
    
    /*
     * Enable hook
     *
     */
    'enable'    => function ($app) {
    },
    
    /*
     * Uninstall hook
     *
     */
    'uninstall' => function ($app) {
        // remove the config
        $app['config']->remove('spqr/redirect');
    },
    
    /*
     * Runs all updates that are newer than the current version.
     *
     */
    'updates'   => [
        '1.0.1' => function ($app) {
            $config = [
                'notfound'     => [
                    'enabled' => true,
                    'url'     => $app['config']->get('spqr/redirect')['url'],
                ],
                'forbidden'    => ['enabled' => false, 'url' => ''],
                'unauthorized' => ['enabled' => false, 'url' => ''],
            ];
            
            $app['config']->set('spqr/redirect', $config);
            
        },
    ],

];
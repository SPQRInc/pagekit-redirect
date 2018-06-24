<?php

return [
    
    /*
     * Installation hook
     *
     */
    'install'   => function ($app) {
        $util = $app['db']->getUtility();
        
        if ($util->tableExists('@redirect_target') === false) {
            $util->createTable('@redirect_target', function ($table) {
                $table->addColumn('id', 'integer', [
                    'unsigned'      => true,
                    'length'        => 10,
                    'autoincrement' => true,
                ]);
                $table->addColumn('title', 'string', ['length' => 255]);
                $table->addColumn('slug', 'string', ['length' => 255]);
                $table->addColumn('status', 'smallint');
                $table->addColumn('target_url', 'string', ['length' => 255]);
                $table->addColumn('redirectcount', 'integer', [
                    'unsigned' => true,
                    'length'   => 10,
                    'default'  => 0,
                    'notnull'  => false,
                ]);
                $table->addColumn('data', 'json_array', ['notnull' => false]);
                $table->addColumn('date', 'datetime', ['notnull' => false]);
                $table->addColumn('modified', 'datetime');
                $table->setPrimaryKey(['id']);
                $table->addUniqueIndex(['slug'], '@REDIRECT_SLUG');
            });
        }
        
        if ($util->tableExists('@redirect_url') === false) {
            $util->createTable('@redirect_url', function ($table) {
                $table->addColumn('id', 'integer', [
                    'unsigned'      => true,
                    'length'        => 10,
                    'autoincrement' => true,
                ]);
                $table->addColumn('target_id', 'integer',
                    ['unsigned' => true, 'length' => 10, 'default' => 0]);
                $table->addColumn('url', 'string', ['length' => 255]);
                $table->setPrimaryKey(['id']);
            });
        }
        
        if ($util->tableExists('@redirect_statistic') === false) {
            $util->createTable('@redirect_statistic', function ($table) {
                $table->addColumn('id', 'integer', [
                    'unsigned'      => true,
                    'length'        => 10,
                    'autoincrement' => true,
                ]);
                $table->addColumn('url_id', 'integer', [
                    'unsigned' => true,
                    'length'   => 10,
                    'default'  => 0,
                    'notnull'  => false,
                ]);
                $table->addColumn('response', 'string', [
                    'length' => 255,
                ]);
                $table->addColumn('ip', 'string',
                    ['length' => 255, 'notnull' => false]);
                $table->addColumn('referrer', 'string',
                    ['length' => 255, 'notnull' => false]);
                $table->addColumn('called_url', 'string',
                    ['length' => 255, 'notnull' => false]);
                $table->addColumn('date', 'datetime', ['notnull' => false]);
                $table->setPrimaryKey(['id']);
            });
        }
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
        
        // remove the tables
        $util = $app['db']->getUtility();
        if ($util->tableExists('@redirect_target')) {
            $util->dropTable('@redirect_target');
        }
        if ($util->tableExists('@redirect_url')) {
            $util->dropTable('@redirect_url');
        }
        if ($util->tableExists('@redirect_statistic')) {
            $util->dropTable('@redirect_statistic');
        }
        
        // remove the config
        $app['config']->remove('spqr/redirect');
    },
    
    /*
     * Runs all updates that are newer than the current version.
     *
     */
    'updates'   => [
        '2.0.0' => function ($app) {
            $config = [
                'unauthorized'   => [
                    'enabled'  => false,
                    'type'     => 'html',
                    'response' => 401,
                    'url'      => '',
                    'html'     => '',
                ],
                'forbidden'      => [
                    'enabled'  => false,
                    'type'     => 'html',
                    'response' => 403,
                    'url'      => '',
                    'html'     => '',
                ],
                'notfound'       => [
                    'enabled'  => false,
                    'type'     => 'html',
                    'response' => 404,
                    'url'      => '',
                    'html'     => '',
                ],
                'statistics'     => [
                    'collect_statistics' => true,
                    'collect_referrer'   => true,
                    'collect_called_url' => true,
                    'collect_ip'         => false,
                    'ignore_url'         => [],
                    'ignore_ext'         => [],
                ],
                'response'       => 301,
                'items_per_page' => 20,
            ];
            
            $old_config = $app['config']->get('spqr/redirect');
            
            if ($old_config['unauthorized']['enabled'] === true) {
                $config['unauthorized']['enabled']       = true;
                $config['unauthorized']['frontend_only'] = true;
                $config['unauthorized']['type']          = 'redirect';
                $config['unauthorized']['response']      = 302;
                $config['unauthorized']['url']
                                                         = $old_config['unauthorized']['url'];
                
            }
            
            if ($old_config['forbidden']['enabled'] === true) {
                $config['forbidden']['enabled']       = true;
                $config['forbidden']['frontend_only'] = true;
                $config['forbidden']['type']          = 'redirect';
                $config['forbidden']['response']      = 302;
                $config['forbidden']['url']
                                                      = $old_config['forbidden']['url'];
            }
            
            if ($old_config['notfound']['enabled'] === true) {
                $config['notfound']['enabled']       = true;
                $config['notfound']['frontend_only'] = true;
                $config['notfound']['type']          = 'redirect';
                $config['notfound']['response']      = 302;
                $config['notfound']['url']
                                                     = $old_config['notfound']['url'];
            }
            
            $app['config']->set('spqr/redirect', $config);
            
            $util = $app['db']->getUtility();
            if ($util->tableExists('@redirect_target') === false) {
                $util->createTable('@redirect_target', function ($table) {
                    $table->addColumn('id', 'integer', [
                        'unsigned'      => true,
                        'length'        => 10,
                        'autoincrement' => true,
                    ]);
                    $table->addColumn('title', 'string', ['length' => 255]);
                    $table->addColumn('slug', 'string', ['length' => 255]);
                    $table->addColumn('status', 'smallint');
                    $table->addColumn('target_url', 'string',
                        ['length' => 255]);
                    $table->addColumn('redirectcount', 'integer', [
                        'unsigned' => true,
                        'length'   => 10,
                        'default'  => 0,
                        'notnull'  => false,
                    ]);
                    $table->addColumn('data', 'json_array',
                        ['notnull' => false]);
                    $table->addColumn('date', 'datetime', ['notnull' => false]);
                    $table->addColumn('modified', 'datetime');
                    $table->setPrimaryKey(['id']);
                    $table->addUniqueIndex(['slug'], '@REDIRECT_SLUG');
                });
            }
            
            if ($util->tableExists('@redirect_url') === false) {
                $util->createTable('@redirect_url', function ($table) {
                    $table->addColumn('id', 'integer', [
                        'unsigned'      => true,
                        'length'        => 10,
                        'autoincrement' => true,
                    ]);
                    $table->addColumn('target_id', 'integer',
                        ['unsigned' => true, 'length' => 10, 'default' => 0]);
                    $table->addColumn('url', 'string', ['length' => 255]);
                    $table->setPrimaryKey(['id']);
                });
            }
            
            if ($util->tableExists('@redirect_statistic') === false) {
                $util->createTable('@redirect_statistic', function ($table) {
                    $table->addColumn('id', 'integer', [
                        'unsigned'      => true,
                        'length'        => 10,
                        'autoincrement' => true,
                    ]);
                    $table->addColumn('url_id', 'integer', [
                        'unsigned' => true,
                        'length'   => 10,
                        'default'  => 0,
                        'notnull'  => false,
                    ]);
                    $table->addColumn('response', 'string', [
                        'length' => 255,
                    ]);
                    $table->addColumn('ip', 'string',
                        ['length' => 255, 'notnull' => false]);
                    $table->addColumn('referrer', 'string',
                        ['length' => 255, 'notnull' => false]);
                    $table->addColumn('called_url', 'string',
                        ['length' => 255, 'notnull' => false]);
                    $table->addColumn('date', 'datetime', ['notnull' => false]);
                    $table->setPrimaryKey(['id']);
                });
            }
            
        },
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
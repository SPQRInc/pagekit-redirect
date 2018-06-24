<?php

namespace Spqr\Redirect\Controller;

use Pagekit\Application as App;

/**
 * @Access(admin=true)
 * @return string
 */
class RedirectController
{
    /**
     * @Access("redirect: manage settings")
     */
    public function settingsAction()
    {
        return [
            '$view' => [
                'title' => __( 'Redirect Settings' ),
                'name'  => 'spqr/redirect:views/admin/settings.php'
            ],
            '$data' => [
                'config' => App::module( 'spqr/redirect' )->config()
            ]
        ];
    }
    
    /**
     * @Request({"config": "array"}, csrf=true)
     * @param array $config
     *
     * @return array
     */
    public function saveAction( $config = [] )
    {
        App::config()->set( 'spqr/redirect', $config );
        
        return [ 'message' => 'success' ];
    }
    
}
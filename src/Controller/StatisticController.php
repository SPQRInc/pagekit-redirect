<?php

namespace Spqr\Redirect\Controller;

use Pagekit\Application as App;
use Spqr\Redirect\Model\Statistic;


/**
 * @Access(admin=true)
 * @return string
 */
class StatisticController
{
    /**
     * @Access("redirect: manage statistics")
     * @Request({"filter": "array", "page":"int"})
     * @param null $filter
     * @param int  $page
     *
     * @return array
     */
    public function statisticAction( $filter = null, $page = 0 )
    {
        return [
            '$view' => [ 'title' => 'Statistics', 'name' => 'spqr/redirect:views/admin/statistic-index.php' ],
            '$data' => [
                'config'   => [
                    'filter' => (object) $filter,
                    'page'   => $page
                ]
            ]
        ];
    }
    
    /**
     * @Route("/statistic/edit", name="statistic/edit")
     * @Access("redirect: manage statistics")
     * @Request({"id": "int"})
     * @param int $id
     *
     * @return array
     */
    public function editAction( $id = 0 )
    {
        try {
            $module = App::module( 'spqr/redirect' );
            
            if ( !$statistic = Statistic::where( compact( 'id' ) )->related( 'url', 'url.target' )->first() ) {
                if ( $id ) {
                    App::abort( 404, __( 'Invalid statistic id.' ) );
                }
                $statistic = Statistic::create(
                    [
                        'date'   => new \DateTime()
                    ]
                );
            }
            
            return [
                '$view' => [
                    'title' => $id ? __( 'Edit Statistic' ) : __( 'Add Statistic' ),
                    'name'  => 'spqr/redirect:views/admin/statistic-edit.php'
                ],
                '$data' => [
                    'statistic'   => $statistic
                ]
            ];
        } catch ( \Exception $e ) {
            App::message()->error( $e->getMessage() );
            
            return App::redirect( '@redirect/statistic' );
        }
    }
}
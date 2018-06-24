<?php

namespace Spqr\Redirect\Controller;

use Pagekit\Application as App;
use Spqr\Redirect\Model\Target;


/**
 * @Access(admin=true)
 * @return string
 */
class TargetController
{
    /**
     * @Access("redirect: manage targets")
     * @Request({"filter": "array", "page":"int"})
     * @param null $filter
     * @param int  $page
     *
     * @return array
     */
    public function targetAction( $filter = null, $page = 0 )
    {
        return [
            '$view' => [ 'title' => 'Targets', 'name' => 'spqr/redirect:views/admin/target-index.php' ],
            '$data' => [
                'statuses' => Target::getStatuses(),
                'config'   => [
                    'filter'     => (object) $filter,
                    'page'       => $page,
                    'statistics' => App::module( 'spqr/redirect' )->config( 'statistics' )
                ]
            ]
        ];
    }
    
    /**
     * @Route("/target/edit", name="target/edit")
     * @Access("redirect: manage targets")
     * @Request({"id": "int"})
     * @param int $id
     *
     * @return array
     */
    public function editAction( $id = 0 )
    {
        try {
            $module = App::module( 'spqr/redirect' );
            
            if ( !$target = Target::where( compact( 'id' ) )->related( 'url' )->first() ) {
                if ( $id ) {
                    App::abort( 404, __( 'Invalid target id.' ) );
                }
                $target = Target::create(
                    [
                        'status' => Target::STATUS_DRAFT,
                        'date'   => new \DateTime(),
                        'url' => []
                    ]
                );
                
                $target->set( 'response', $module->config( 'response' ) );
            }
            
            return [
                '$view' => [
                    'title' => $id ? __( 'Edit Target' ) : __( 'Add Target' ),
                    'name'  => 'spqr/redirect:views/admin/target-edit.php'
                ],
                '$data' => [
                    'target'   => $target,
                    'statuses' => Target::getStatuses()
                ]
            ];
        } catch ( \Exception $e ) {
            App::message()->error( $e->getMessage() );
            
            return App::redirect( '@redirect/target' );
        }
    }
}
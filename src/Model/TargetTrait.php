<?php

namespace Spqr\Redirect\Model;

/**
 * Trait TargetTrait
 * @package Spqr\Redirect\Model
 */
trait TargetTrait
{
    /**
     * @HasMany(targetEntity="Url", keyFrom="id", keyTo="target_id")
     */
    public $url;
    
    /**
     * @return array
     */
    public function getUrl()
    {
        if ( $this->url ) {
            return array_values(
                array_map(
                    function( $url ) {
                        return $url;
                    },
                    $this->url
                )
            );
        }
        
        return [];
    }
    
    /**
     * @param array $urls
     */
    public function saveUrl( array $urls )
    {
        $stored     = Url::where( [ 'target_id' => $this->id ] )->get();
        $urllist = [];
        
        foreach ( $urls as $url ) {
            if ( array_key_exists( 'id', $url ) ) {
                $m        = Url::where( [ 'id' => $url[ 'id' ] ] )->first();
                $m->url = $url[ 'url' ];
                $m->save();
                
                $urllist[ $m->id ] = $m;
            } else {
                $m = Url::create(
                    [ 'target_id' => $this->id,  'url' => $url[ 'url' ] ]
                );
                $m->save();
                
                $urllist[ $m->id ] = $m;
            }
        }
        
        foreach ( $stored as $s ) {
            if ( !array_key_exists( $s->id, $urllist ) ) {
                unset( $urllist[ $s->id ] );
                $s->delete();
            }
        }
    }
}
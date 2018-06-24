<?php

namespace Spqr\Redirect\Model;

use Pagekit\Database\ORM\ModelTrait;

/**
 * Class UrlModelTrait
 * @package Spqr\Redirect\Model
 */
trait UrlModelTrait
{
    use ModelTrait;
    
    /**
     * @HasMany(targetEntity="Statistic", keyFrom="id", keyTo="url_id")
     */
    public $statistic;
    
    /**
     * @return array
     */
    public function getStatistics()
    {
        if ( $this->statistic ) {
            return array_values(
                array_map(
                    function( $statistic ) {
                        return $statistic;
                    },
                    $this->statistic
                )
            );
        }
        
        return [];
    }
    
    /**
     * @Deleting
     */
    public static function deleting($event, Url $url)
    {
        self::getConnection()->delete('@redirect_statistic', ['url_id' => $url->id]);
    }
    
}
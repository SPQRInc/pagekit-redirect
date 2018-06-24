<?php

namespace Spqr\Redirect\Model;

use Pagekit\Database\ORM\ModelTrait;

/**
 * @Entity(tableClass="@redirect_statistic", eventPrefix="redirect.statistic")
 */
class Statistic implements \JsonSerializable
{
    use ModelTrait;
    
    /** @Column(type="integer") @Id */
    public $id;
    
    /** @Column(type="integer") */
    public $url_id;
    
    /** @Column(type="string") */
    public $response;
    
    /** @Column(type="string") */
    public $ip;
    
    /** @Column(type="string") */
    public $referrer;
    
    /** @Column(type="string") */
    public $called_url;
    
    /** @Column(type="datetime") */
    public $date;
    
    /** @BelongsTo(targetEntity="Url", keyFrom="url_id") */
    public $url;
    
    
    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        
        $data = [
            'url' => $this->url,
            'target' => $this->url->target
        ];
        
        return $this->toArray( $data );
    }
}
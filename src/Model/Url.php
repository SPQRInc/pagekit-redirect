<?php

namespace Spqr\Redirect\Model;

/**
 * @Entity(tableClass="@redirect_url", eventPrefix="redirect.url")
 */
class Url implements \JsonSerializable
{
    use UrlModelTrait;
    
    /** @Column(type="integer") @Id */
    public $id;
    
    /** @Column(type="integer") */
    public $target_id;
    
    /** @Column(type="string") */
    public $url;
    
    /** @BelongsTo(targetEntity="Target", keyFrom="target_id") */
    public $target;
    
    
    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        $data = [
            'statistic' => $this->getStatistics()
        ];
        
        return $this->toArray( $data );
    }
}
<?php

namespace Spqr\Redirect\Model;

use Pagekit\Database\ORM\ModelTrait;

/**
 * Class TargetModelTrait
 *
 * @package Spqr\Redirect\Model
 */
trait TargetModelTrait
{
    use ModelTrait;
    
    public static function updateStatistic($id)
    {
        $stats     = [];
        $redirects = 0;
        
        $target = self::query()->related('url')->where('id = ?', [$id])
            ->first();
        
        if ($target && !empty($target->url)) {
            foreach ($target->url as $url) {
                $redirects
                                    = $redirects + Statistic::where([
                        'url_id' => $url->id,
                    ])->count();
                $stats['redirects'] = $redirects;
            }
        }
        
        self::where(compact('id'))->update([
            'redirectcount' => $stats['redirects'],
        ]);
        
    }
    
    /**
     * @Saving
     */
    public static function saving($event, Target $target)
    {
        $target->modified = new \DateTime();
        $i                = 2;
        $id               = $target->id;
        while (self::where('slug = ?', [$target->slug])->where(function ($query
        ) use ($id) {
            if ($id) {
                $query->where('id <> ?', [$id]);
            }
        })->first()) {
            $target->slug = preg_replace('/-\d+$/', '', $target->slug).'-'.$i++;
        }
    }
    
    /**
     * @Deleting
     */
    public static function deleting($event, Target $target)
    {
        self::getConnection()
            ->delete('@redirect_url', ['target_id' => $target->id]);
    }
    
}
<?php

namespace Spqr\Redirect\Helper;

use Pagekit\Application as App;
use Spqr\Redirect\Model\Target;
use Spqr\Redirect\Model\Statistic;
use Spqr\Redirect\Model\Url;


/**
 * Class StatisticHelper
 *
 * @package Spqr\Redirect\Helper
 */
class StatisticHelper
{
    
    
    /**
     * @param \Spqr\Redirect\Model\Target|null $target
     * @param \Spqr\Redirect\Model\Url|null    $url
     * @param null                             $exceptionresponse
     */
    public function addStatistics(
        Target $target = null,
        Url $url = null,
        $exceptionresponse = null
    ) {
        $module = App::module('spqr/redirect');
        
        if ($module->config('statistics.collect_statistics')) {
            $statistic = new Statistic();
            
            if ($target) {
                if (Url::where(['id = ?', 'target_id = ?'], [
                    (int)$url->id,
                    (int)$target->id,
                ])->first()
                ) {
                    $statistic->url_id = (int)$url->id;
                } else {
                    $statistic->url_id = Url::where([
                        'target_id = ?',
                    ], [(int)$target->id])->first()->id;
                }
                
                $statistic->response = $target->get('response');
            } elseif (!empty ($exceptionresponse)) {
                $statistic->response = $exceptionresponse->getStatusCode();
                $statistic->url_id   = null;
            } else {
                return;
            }
            
            $statistic->date = new \DateTime();
            
            if ($module->config('statistics.collect_referrer')) {
                $statistic->referrer
                    = App::request()->headers->get('referer');
            }
            if ($module->config('statistics.collect_ip')) {
                $statistic->ip = App::request()->getClientIp();
            }
            
            if ($module->config('statistics.collect_called_url')) {
                $statistic->called_url = App::url()->current();
            }
            
            $statistic->save();
        }
        
    }
    
}
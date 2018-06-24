<?php

namespace Spqr\Redirect\Event;

use Spqr\Redirect\Model\Url;
use Spqr\Redirect\Model\Target;
use Spqr\Redirect\Model\Statistic;

use Pagekit\Event\EventSubscriberInterface;

class StatisticListener implements EventSubscriberInterface
{
    public function onStatisticsChange($event, Statistic $statistic)
    {
        $url = Url::where(['id' => $statistic->url_id])->first();
        $target_id = $url->target_id;
        Target::updateStatistic($target_id);
    }
    
    /**
     * {@inheritdoc}
     */
    public function subscribe()
    {
        return [
            'model.redirect.statistic.saved' => 'onStatisticsChange',
            'model.redirect.statistic.deleted' => 'onStatisticsChange'
        ];
    }
}
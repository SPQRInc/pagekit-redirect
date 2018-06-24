<?php

namespace Spqr\Redirect\Event;

use Pagekit\Event\EventSubscriberInterface;
use Pagekit\Application as App;
use Spqr\Redirect\Helper\RedirectHelper;
use Spqr\Redirect\Helper\StatisticHelper;


/**
 * Class ExceptionListener
 *
 * @package Spqr\Redirect\Event
 */
class ExceptionListener implements EventSubscriberInterface
{
    /**
     * @param $event
     * @param $request
     */
    public function onException($event, $request)
    {
        $rhelper = new RedirectHelper;
        $shelper = new StatisticHelper;
        $response = $rhelper->process($event);
        
        if ($response) {
            $shelper->addStatistics(null,null, $response);
            $event->setResponse($response);
        }
    }
    
    /**
     * @return array
     */
    public function subscribe()
    {
        return [
            'exception' => ['onException', -100],
        ];
    }
}
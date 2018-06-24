<?php

namespace Spqr\Redirect\Event;

use Pagekit\Event\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Pagekit\Application as App;
use Spqr\Redirect\Model\Target;
use Spqr\Redirect\Helper\StatisticHelper;

/**
 * Class RequestListener
 *
 * @package Spqr\Redirect\Event
 */
class RequestListener implements EventSubscriberInterface
{
    
    /**
     * @param $event
     * @param $request
     */
    public function onRequest($event, $request)
    {
        $query   = Target::where(['status = ?'], [Target::STATUS_PUBLISHED]);
        $targets = $query->related('url')->get();
        $shelper = new StatisticHelper;
        
        foreach ($targets as $target) {
            foreach ($target->url as $url) {
                if (App::url()->current() === $url->url
                    || App::url()->current() === App::url()->getRoute($url->url)
                    || App::request()->getUri() === $url->url
                ) {
                    $response
                        = new RedirectResponse(App::url($target->target_url),
                        $target->get('response'));
                    if ($response) {
                        $shelper->addStatistics($target, $url);
                        $event->setResponse($response);
                    }
                }
            }
        }
    }
    
    /**
     * @return array
     */
    public function subscribe()
    {
        return [
            'request' => ['onRequest', -150],
        ];
    }
}
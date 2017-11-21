<?php

namespace Spqr\Redirect\Event;

use Pagekit\Event\EventSubscriberInterface;
use Pagekit\Kernel\Exception\NotFoundException;
use Pagekit\Kernel\Exception\ForbiddenException;
use Pagekit\Kernel\Exception\UnauthorizedException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Pagekit\Application as App;

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
        $exception = $event->getException();
        $config    = App::module('spqr/redirect')->config();
        
        if ($config['notfound']['enabled'] === true
            && $exception instanceof NotFoundException
        ) {
            $url = $config['notfound']['url'];
            
            if (empty($url) || $url == null) {
                $url = '@page/1';
            }
            
            $response = new RedirectResponse(App::url($url));
            $event->setResponse($response);
        } elseif ($config['forbidden']['enabled'] === true
            && $exception instanceof ForbiddenException
        ) {
            $url = $config['forbidden']['url'];
            
            if (empty($url) || $url == null) {
                $url = '@page/1';
            }
            
            $response = new RedirectResponse(App::url($url));
            $event->setResponse($response);
        } elseif ($config['unauthorized']['enabled'] === true
            && $exception instanceof UnauthorizedException
        ) {
            $url = $config['unauthorized']['url'];
            
            if (empty($url) || $url == null) {
                $url = '@page/1';
            }
            
            $response = new RedirectResponse(App::url($url));
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
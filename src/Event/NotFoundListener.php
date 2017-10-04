<?php

namespace Spqr\Redirect\Event;

use Pagekit\Event\EventSubscriberInterface;
use Pagekit\Kernel\Exception\NotFoundException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Pagekit\Application as App;

/**
 * Class NotFoundListener
 * @package Spqr\Redirect\Event
 */
class NotFoundListener implements EventSubscriberInterface
{
	/**
	 * @param $event
	 * @param $request
	 */
	public function onException( $event, $request)
	{
		$exception = $event->getException();
		
		if( $exception instanceof NotFoundException) {
			$config =  App::module( 'spqr/redirect' )->config();
			$url = $config['url'];
			
			if(empty($url) || $url == NULL ){
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
			'exception' => ['onException', -100]
		];
	}
}
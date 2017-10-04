<?php

use Pagekit\Application;
use Spqr\Redirect\Event\NotFoundListener;

return [
	'name' => 'spqr/redirect',
	'type' => 'extension',
	'main' => function( Application $app ) {
	},
	
	'autoload' => [
		'Spqr\\Redirect\\' => 'src'
	],
	
	'routes' => [],
	
	'widgets' => [],
	
	'menu' => [],
	
	'permissions' => [
		'redirect: manage settings' => [
			'title' => 'Manage settings'
		]
	],
	
	'settings' => 'redirect-settings',
	
	'resources' => [
		'spqr/redirect:' => ''
	],
	
	'config' => [
		'url' => '',
	],
	
	'events' => [
		'boot'         => function( $event, $app ) {
			$app->subscribe(
				new NotFoundListener
			);
		},
		'site'         => function( $event, $app ) {
		},
		'view.scripts' => function( $event, $scripts ) use ( $app ) {
			$scripts->register(
				'redirect-settings',
				'spqr/redirect:app/bundle/redirect-settings.js',
				[ '~extensions', 'input-link' ]
			);
		}
	]
];
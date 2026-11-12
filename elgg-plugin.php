<?php

return [
	'plugin' => [
		'version' => '7.0.1',
	],
	'events' => [
		'setting' => [
			'plugin' => [
				'\ColdTrick\Redirector\Plugin::saveRedirectsSetting' => [],
			],
		],
		'route:match' => [
			'system' => [
				'\ColdTrick\Redirector\Route::redirect' => ['priority' => 9999],
			],
		],
	],
];

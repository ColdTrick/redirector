<?php

return [
	'plugin' => [
		'version' => '6.0',
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

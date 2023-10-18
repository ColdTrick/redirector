<?php

return [
	'plugin' => [
		'version' => '5.0.2',
	],
	'events' => [
		'setting' => [
			'plugin' => [
				'\ColdTrick\Redirector\Plugin::saveRedirectsSetting' => [],
			],
		],
		'view_vars' => [
			'resources/error' => [
				'\ColdTrick\Redirector\Views::viewVars404' => [],
			],
		],
	],
	'view_extensions' => [
		'admin.css' => [
			'plugins/redirector/settings.css' => [],
		],
	],
];

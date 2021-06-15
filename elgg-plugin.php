<?php

return [
	'plugin' => [
		'version' => '2.0',
	],
	'hooks' => [
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

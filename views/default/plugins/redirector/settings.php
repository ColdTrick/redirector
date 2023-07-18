<?php

elgg_require_js('plugins/redirector/settings');

$redirects = elgg_get_plugin_setting('redirects', 'redirector');

echo elgg_view('output/longtext', ['value' => elgg_echo('redirector:settings:info')]);

$body = elgg_view_field([
	'#type' => 'fieldset',
	'align' => 'horizontal',
	'fields' => [
		[
			'#type' => 'text',
			'id' => 'redirect_from',
			'placeholder' => elgg_echo('redirector:settings:redirects:add:placeholder'),
		],
		[
			'#html' => elgg_format_element('div', ['class' => 'elgg-field'], elgg_view_icon('arrow-right', ['class' => 'redirector-settings-arrow'])),
		],
		[
			'#type' => 'text',
			'id' => 'redirect_to',
			'placeholder' => elgg_echo('redirector:settings:redirects:add:placeholder'),
		],
		[
			'#type' => 'button',
			'class' => 'elgg-button-submit',
			'text' => elgg_echo('add'),
			'id' => 'redirector-redirect-add',
		],
	],
]);

echo elgg_view_module('info', elgg_echo('redirector:settings:redirects:add:title'), $body);

echo elgg_view_field([
	'#type' => 'hidden',
	'name' => 'params[redirects]',
]);

$list_items = elgg_format_element('li', [], elgg_echo('notfound'));
if ($redirects) {
	$redirects = json_decode($redirects, true);
	foreach ($redirects as $from => $to) {
		$text = elgg_view_field([
			'#type' => 'hidden',
			'name' => "params[redirects][$from]",
			'value' => $to,
		]);
		
		$text .= $from . ' ' . elgg_view_icon('arrow-right') . ' ' . $to;
		$text .= elgg_view_icon('delete');
		
		$list_items .= elgg_format_element('li', [], $text);
	}
}

$list = elgg_format_element('ul', ['id' => 'redirector-redirects-list'], $list_items);

echo elgg_view_module('info', elgg_echo('redirector:settings:redirects:list:title'), $list);

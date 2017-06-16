<?php

elgg_require_js('plugins/redirector/settings');

$redirects = elgg_get_plugin_setting('redirects', 'redirector');

echo elgg_view('output/longtext', ['value' => elgg_echo('redirector:settings:info')]);

$from = elgg_view_field([
	'#type' => 'text',
	'id' => 'redirect_from',
	'placeholder' => elgg_echo('redirector:settings:redirects:add:placeholder'),
]);

$to = elgg_view_field([
	'#type' => 'text',
	'id' => 'redirect_to',
	'placeholder' => elgg_echo('redirector:settings:redirects:add:placeholder'),
]);

$save = elgg_view_field([
	'#type' => 'button',
	'class' => 'elgg-button-submit',
	'value' => elgg_echo('add'),
	'id' => 'redirector-redirect-add',
]);

$body = '<div class="clearfix elgg-col-1of2">';

$body .= elgg_format_element('div', [
	'class' => 'elgg-col elgg-col-1of3',
], $from);

$body .= elgg_format_element('div', [
	'class' => 'elgg-col elgg-col-1of6 center',
], ' ' . elgg_view_icon('arrow-right') . ' ');

$body .= elgg_format_element('div', [
	'class' => 'elgg-col elgg-col-1of3',
], $to);

$body .= elgg_format_element('div', [
	'class' => 'elgg-col elgg-col-1of6',
], $save);

$body .= '</div>';

echo elgg_view_module('info', elgg_echo('redirector:settings:redirects:add:title'), $body);

echo elgg_view_field([
	'#type' => 'hidden',
	'name' => 'params[redirects]',
	'value' => '',
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

$list = elgg_format_element('ul', [
	'id' => 'redirector-redirects-list',
], $list_items);

echo elgg_view_module('info', elgg_echo('redirector:settings:redirects:list:title'), $list);

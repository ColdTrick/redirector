<?php

elgg_register_event_handler('init', 'system', 'redirector_init');

function redirector_init() {
	elgg_register_plugin_hook_handler('route', 'all', 'redirector_route_all', 9999);
	elgg_register_plugin_hook_handler('setting', 'plugin', 'redirector_save_settings');
	
	elgg_extend_view('admin.css', 'plugins/redirector/settings.css');
}

/**
 * Checks if there is a redirect configured and forwards
 *
 * @param string $hook        hook name
 * @param string $entity_type hook type
 * @param array  $returnvalue current return value
 * @param array  $params      parameters
 *
 * @return array
 */
function redirector_route_all($hook, $entity_type, $returnvalue, $params) {
	if (!is_array($returnvalue)) {
		// someone else is probably handling output in a route hook
		return;
	}
	
	$identifier = elgg_extract('identifier', $returnvalue, elgg_extract('handler', $returnvalue));
	
	if (!$identifier) {
		// nothing to check
		return;
	}
	
	$handlers = _elgg_services()->router->getPageHandlers();
	if (elgg_extract($identifier, $handlers)) {
		// page handler exists
		return;
	}
	
	$settings = elgg_get_plugin_setting('redirects', 'redirector');
	if (!$settings) {
		return;
	}
	
	$redirects = json_decode($settings, true);
	if (empty($redirects)) {
		return;
	}
	
	$url = str_ireplace(elgg_get_site_url(), '', current_page_url());
	$url = parse_url($url, PHP_URL_PATH);
	$url = rtrim($url, '/');
	
	// check if url is configured to be forwarded
	$forward_url = elgg_extract($url, $redirects);
	if (!$forward_url) {
		return;
	}
	
	forward($forward_url);
}

/**
 * Modifies the value of the redirects setting
 *
 * @param string $hook        hook name
 * @param string $entity_type hook type
 * @param array  $returnvalue current return value
 * @param array  $params      parameters
 *
 * @return array
 */
function redirector_save_settings($hook, $entity_type, $returnvalue, $params) {
	$plugin = elgg_extract('plugin', $params);
	if ($plugin->getID() !== 'redirector') {
		return;
	}
	
	$setting = elgg_extract('name', $params);
	if ($setting !== 'redirects') {
		return;
	}
	
	$result = [];
	
	$value = elgg_extract('value', $params);
	foreach ($value as $from => $to) {
	
		$from = str_ireplace(elgg_get_site_url(), '', $from);
		$from = parse_url($from, PHP_URL_PATH);
		$from = rtrim($from, '/');
	
		$to = str_ireplace(elgg_get_site_url(), '', $to);
		
		if ($from == $to) {
			// prevent endless redirects
			continue;
		}
		
		$result[$from] = $to;
	}
	
	return json_encode($result);
}

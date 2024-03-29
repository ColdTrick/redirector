<?php

namespace ColdTrick\Redirector;

/**
 * Views related events
 */
class Views {
	
	/**
	 * Check the 404 resource if we can redirect to different page
	 *
	 * @param \Elgg\Event $event 'view_vars', 'resources/error'
	 *
	 * @return void
	 */
	public static function viewVars404(\Elgg\Event $event) {
		
		$error_type = (int) elgg_extract('type', $event->getValue());
		if ($error_type !== 404) {
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
		
		$url = str_ireplace(elgg_get_site_url(), '', elgg_get_current_url());
		$url = (string) parse_url($url, PHP_URL_PATH);
		$url = rtrim($url, '/');
		
		// check if url is configured to be forwarded
		$forward_url = elgg_extract($url, $redirects);
		if (!$forward_url) {
			return;
		}
		
		_elgg_services()->responseFactory->redirect($forward_url);
		exit;
	}
}

<?php

namespace ColdTrick\Redirector;

/**
 * Route related events
 */
class Route {
	
	/**
	 * Check if we can redirect to different page
	 *
	 * @param \Elgg\Event $event 'route:match', 'system'
	 *
	 * @return void
	 */
	public static function redirect(\Elgg\Event $event) {
		$url = trim($event->getParam('pathinfo'), '/ ');
		if (empty($url)) {
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
		
		// check if url is configured to be forwarded
		$forward_url = elgg_extract($url, $redirects);
		if (!$forward_url) {
			return;
		}
		
		_elgg_services()->responseFactory->redirect($forward_url);
		exit;
	}
}

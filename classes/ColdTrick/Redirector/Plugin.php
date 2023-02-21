<?php

namespace ColdTrick\Redirector;

/**
 * Handles plugin settings
 */
class Plugin {
	
	/**
	 * Modifies the value of the redirects setting
	 *
	 * @param \Elgg\Event $event 'setting', 'plugin'
	 *
	 * @return void|string
	 */
	public static function saveRedirectsSetting(\Elgg\Event $event) {
		
		$plugin = $event->getParam('plugin');
		if (!$plugin instanceof \ElggPlugin || $plugin->getID() !== 'redirector') {
			return;
		}
		
		if ($event->getParam('name') !== 'redirects') {
			return;
		}
		
		$result = [];
		
		$value = $event->getParam('value');
		if (empty($value)) {
			return json_encode($result);
		}
		
		foreach ($value as $from => $to) {
			$from = str_ireplace(elgg_get_site_url(), '', $from);
			$from = parse_url($from, PHP_URL_PATH);
			$from = rtrim($from, '/');
			
			$to = str_ireplace(elgg_get_site_url(), '', $to);
			
			if ($from === $to) {
				// prevent endless redirects
				continue;
			}
			
			$result[$from] = $to;
		}
		
		return json_encode($result);
	}
}

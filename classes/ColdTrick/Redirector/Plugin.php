<?php

namespace ColdTrick\Redirector;

class Plugin {
	
	/**
	 * Modifies the value of the redirects setting
	 *
	 * @param \Elgg\Hook $hook 'setting', 'plugin'
	 *
	 * @return void|string
	 */
	public static function saveRedirectsSetting(\Elgg\Hook $hook) {
		
		$plugin = $hook->getParam('plugin');
		if (!($plugin instanceof \ElggPlugin) || ($plugin->getID() !== 'redirector')) {
			return;
		}
		
		if ($hook->getParam('name') !== 'redirects') {
			return;
		}
		
		$result = [];
		
		$value = $hook->getParam('value');
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
}

<?php

namespace ColdTrick\Redirector;

class Plugin {
	
	/**
	 * Modifies the value of the redirects setting
	 *
	 * @param string $hook        hook name
	 * @param string $entity_type hook type
	 * @param array  $returnvalue current return value
	 * @param array  $params      parameters
	 *
	 * @return void|string
	 */
	public static function saveRedirectsSetting($hook, $entity_type, $returnvalue, $params) {
		
		$plugin = elgg_extract('plugin', $params);
		if (!($plugin instanceof \ElggPlugin) || ($plugin->getID() !== 'redirector')) {
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
}

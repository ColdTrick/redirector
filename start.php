<?php
/**
 * Main plugin file
 */

// register default Elgg events
elgg_register_event_handler('init', 'system', 'redirector_init');

/**
 * Called during system init
 *
 * @return void
 */
function redirector_init() {
	
	// register plugin hooks
	elgg_register_plugin_hook_handler('setting', 'plugin', '\ColdTrick\Redirector\Plugin::saveRedirectsSetting');
	elgg_register_plugin_hook_handler('view_vars', 'resources/error', '\ColdTrick\Redirector\Views::viewVars404');
	
	// extend CSS
	elgg_extend_view('admin.css', 'plugins/redirector/settings.css');
}

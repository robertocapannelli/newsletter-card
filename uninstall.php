<?php

// if uninstall.php is not called by WordPress, die
if (!defined('WP_UNINSTALL_PLUGIN')) {
	die;
}

/**
 * Safe delete the plugin and options in database
 */
function cf7_nc_delete_plugin(){
	//TODO delete all options not just the shortcode
	$option_name = CF7_NC_PLUGIN_TEXT_DOMAIN . '_shortcode';
	delete_option($option_name);
	// for site options in Multisite
	delete_site_option($option_name);
}

cf7_nc_delete_plugin();
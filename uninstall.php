<?php

// if uninstall.php is not called by WordPress, die
if (!defined('WP_UNINSTALL_PLUGIN')) {
	die;
}

function walkap_cf7nc_delete_plugin(){
	$option_name = 'walkap_cf7nc_shortcode';
	delete_option($option_name);
	// for site options in Multisite
	delete_site_option($option_name);
}

walkap_cf7nc_delete_plugin();
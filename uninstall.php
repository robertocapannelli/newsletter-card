<?php
// if uninstall.php is not called by WordPress, die
if (!defined('WP_UNINSTALL_PLUGIN')) {
	exit;
}

/**
 * Safe delete the plugin and options in database
 */

if(!function_exists('')){
	function cf7_nc_delete_plugin(){
		//TODO use just one option row and the a json like string to store options
		//TODO if the first TODO not done -> use a loop to delete all options in the database
		//TODO we also need for delete_site_option() for multisite
		delete_option('newsletter_card_shortcode');
		delete_option('newsletter_card_title');
		delete_option('newsletter_card_description');
		delete_option('newsletter_card_exdays');
	}
}

cf7_nc_delete_plugin();
<?php

define( 'OPTION_GROUP', 'walkap_cf7nc_group' );

define( 'SECTION_ID', 'walkap_cf7nc_section' );

define( 'SECTION_TITLE', 'Settings' );

define( 'PAGE', 'cf7-newsletter-card' );

define( 'FIELD_CB', 'walkap_cf7nc_settings_field_callback' );

/**
 * Add the CF7 newsletter card sub menu to the CF7 main menu
 */
function walkap_cf7nc_options_page() {
	//Check if CF7 is installed
	if ( ! is_plugin_active( 'contact-form-7/wp-contact-form-7.php' ) ) {
		return;
	}
	//Add submenu under CF7 menu
	add_submenu_page(
		'wpcf7',
		PLUGIN_NAME,
		PLUGIN_NAME,
		'manage_options',
		PAGE,
		'walkap_cf7nc_options_page_html'
	);
}

add_action( 'admin_menu', 'walkap_cf7nc_options_page' );

/**
 * Callback function for add_submenu
 */
function walkap_cf7nc_options_page_html() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	// check if the user have submitted the settings
	// wordpress will add the "settings-updated" $_GET parameter to the url
	if ( isset( $_GET['settings-updated'] ) ) {
		// add settings saved message with the class of "updated"
		add_settings_error( 'walkap_cf7nc_messages', 'walkap_cf7nc_message', __( 'Settings Saved', 'walkap_cf7nc' ), 'updated' );
	}

	// show error/update messages
	settings_errors( 'walkap_cf7nc_messages' );

	//Require view.php file that contains admin view
	require_once( CF7NC_PLUGIN_DIR . '/admin/view.php' );
}

require_once( CF7NC_PLUGIN_DIR . '/admin/settings.php' );
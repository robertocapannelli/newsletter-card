<?php

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
	require_once( PLUGIN_DIR . '/admin/view.php' );
}

require_once( PLUGIN_DIR . '/admin/settings.php' );

/**
 * Enqueue scripts and styles
 */
function walkap_cf7nc_scripts() {

	//unset($_COOKIE['is_card_hidden']);

	if ( ! isset( $_COOKIE['is_card_hidden'] ) ) {
		wp_enqueue_style( 'public_style', PLUGIN_PUBLIC_STYLE, null, '1.0.0' );
		wp_enqueue_script( 'script-name', CF7NC_PUBLIC_SCRIPT, array( 'jquery' ), '1.0.0', true );
	}
}

add_action( 'wp_enqueue_scripts', 'walkap_cf7nc_scripts' );

/**
 * Add content to the front-end
 */
function walkap_cf7nc_add_content() {

	$shortcode = get_option( 'walkap_cf7nc_shortcode' );

	//needed to invoke is_plugin_active
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

	$is_active = is_plugin_active( PLUGIN_DIR . '/newsletter-card.php' );

	//check if a CF7 shortcode is provided and if the plugin is active
	if ( ! ( $shortcode || $is_active ) || isset( $_COOKIE['is_card_hidden'] ) ) {
		return;
	}
	require_once plugin_dir_path( __FILE__ ) . '/public/card.php';
}

add_action( 'wp_footer', 'walkap_cf7nc_add_content' );
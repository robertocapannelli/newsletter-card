<?php
/*
Plugin Name: Newsletter Card
Plugin URI: https://github.com/robertocapannelli/newsletter-card
Description: WordPress plugin that works with CF7 plugin to show a fancy subscription form on scrolling page
Version: 1.0
Author: Roberto Capannelli
Author URI: https://walkap.com
Text Domain: walkap_cf7nc
*/

define( 'PLUGIN_NAME', 'CF7 newsletter card' );

define( 'CF7NC_VERSION', '1.0' );

define( 'CF7NC_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

define( 'CF7NC_PUBLIC_STYLE', plugin_dir_url( __FILE__ ) . 'public/css/style.css' );

define( 'CF7NC_PUBLIC_SCRIPT', plugin_dir_url( __FILE__ ) . 'public/js/main.js' );

/**
 *
 * Check if Contect Form 7 exists and is active
 *
 */
function walkap_cf7nc_error() {

	if ( ! file_exists( WP_PLUGIN_DIR . '/contact-form-7/wp-contact-form-7.php' ) ) {

		$walkap_cf7nc_error_out = '<div id="message" class="error is-dismissible"><p>';
		$walkap_cf7nc_error_out .= __( 'The Contact Form 7 plugin must be installed for the <b>Newsletter card plugin</b> to work. <b><a href="' . admin_url( 'plugin-install.php?tab=plugin-information&plugin=contact-form-7&from=plugins&TB_iframe=true&width=600&height=550' ) . '" class="thickbox" title="Contact Form 7">Install Contact Form 7 Now.</a></b>', 'walkap_cf7nc' );
		$walkap_cf7nc_error_out .= '</p></div>';
		echo $walkap_cf7nc_error_out;

	} else if ( ! class_exists( 'WPCF7' ) ) {

		$walkap_cf7nc_error_out = '<div id="message" class="error is-dismissible"><p>';
		$walkap_cf7nc_error_out .= __( 'The Contact Form 7 is installed, but <strong>you must activate Contact Form 7</strong> below for the <b>Newsletter card plugin</b> to work.', 'walkap_cf7nc' );
		$walkap_cf7nc_error_out .= '</p></div>';
		echo $walkap_cf7nc_error_out;

	}

}

add_action( 'admin_notices', 'walkap_cf7nc_error' );

require_once plugin_dir_path( __FILE__ ) . '/settings.php';

//TODO add position left or right
//TODO add style for background and color font
//TODO add custom css field
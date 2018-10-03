<?php
/**
 *
 * Check if Contact Form 7 exists and is active
 *
 */

if(!function_exists('cf7_nc_error')){
	function cf7_nc_error() {

		if ( ! file_exists( WP_PLUGIN_DIR . '/contact-form-7/wp-contact-form-7.php' ) ) {
			$error = '<div id="message" class="error is-dismissible"><p>';
			$error .= __( 'The Contact Form 7 plugin must be installed for the <b>Newsletter card plugin</b> to work. <b><a href="' . admin_url( 'plugin-install.php?tab=plugin-information&plugin=contact-form-7&from=plugins&TB_iframe=true&width=600&height=550' ) . '" class="thickbox" title="Contact Form 7">Install Contact Form 7 Now.</a></b>', CF7_NC_PLUGIN_TEXT_DOMAIN );
			$error .= '</p></div>';
			echo $error;
		} else if ( ! class_exists( 'WPCF7' ) ) {
			$error = '<div id="message" class="error is-dismissible"><p>';
			$error .= __( 'The Contact Form 7 is installed, but <strong>you must activate Contact Form 7</strong> below for the <b>Newsletter card plugin</b> to work.', CF7_NC_PLUGIN_TEXT_DOMAIN );
			$error .= '</p></div>';
			echo $error;
		}
	}
	add_action( 'admin_notices', 'cf7_nc_error' );
}
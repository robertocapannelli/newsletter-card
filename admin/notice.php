<?php
/**
 *
 * Check if Contact Form 7 exists and is active
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
<?php

if ( is_admin() ) {
	require_once CF7_NC_PLUGIN_DIR . 'admin/notice.php';
	require_once( CF7_NC_PLUGIN_DIR . 'admin/settings.php' );
} else {
	$shortcode = get_option( CF7_NC_PLUGIN_TEXT_DOMAIN . '_shortcode' );
	//needed to invoke is_plugin_active
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	$is_active = is_plugin_active( CF7_NC_PLUGIN_DIR . '/newsletter-card.php' );
	//check if a CF7 shortcode is provided and if the plugin is active
	if ( ! ( $shortcode || $is_active ) || isset( $_COOKIE['is_card_hidden'] ) ) {
		return;
	} else {
		require_once( CF7_NC_PLUGIN_DIR . 'public/enqueue.php' );

		//Add content to the front-end
		function cf7_nc_add_content() {
			require_once plugin_dir_path( __FILE__ ) . '/public/card.php';
		}
		add_action( 'wp_footer', 'cf7_nc_add_content' );
	}
}
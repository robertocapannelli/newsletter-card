<?php

if(is_admin()){
	require_once PLUGIN_DIR . 'admin/notice.php';
	require_once (PLUGIN_DIR . 'admin/settings.php');
}else{
	$shortcode = get_option( 'walkap_cf7nc_shortcode' );
	//needed to invoke is_plugin_active
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	$is_active = is_plugin_active( PLUGIN_DIR . '/newsletter-card.php' );

	//check if a CF7 shortcode is provided and if the plugin is active
	if ( ! ( $shortcode || $is_active ) || isset( $_COOKIE['is_card_hidden'] ) ) {
		return;
	}else{
		require_once (PLUGIN_DIR . 'public/enqueue.php');
		/**
		 * Add content to the front-end
		 */
		function walkap_cf7nc_add_content() {
			require_once plugin_dir_path( __FILE__ ) . '/public/card.php';

		}
		add_action( 'wp_footer', 'walkap_cf7nc_add_content' );
	}
}
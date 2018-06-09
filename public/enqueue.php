<?php
/**
 * Enqueue scripts and styles
 */
function walkap_cf7nc_scripts() {

	//unset($_COOKIE['is_card_hidden']);

	if ( ! isset( $_COOKIE['is_card_hidden'] ) ) {
		wp_enqueue_style( 'public_style', PLUGIN_PUBLIC_STYLE, null, PLUGIN_VERSION );
		wp_enqueue_script( 'public_script', PLUGIN_PUBLIC_SCRIPT, array( 'jquery' ), PLUGIN_VERSION, true );

		$nonce = wp_create_nonce( 'is_hidden_card' );
		wp_localize_script( 'public_script', 'my_ajax_obj', array(
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'nonce'    => $nonce,
		) );
	}
}

add_action( 'wp_enqueue_scripts', 'walkap_cf7nc_scripts' );
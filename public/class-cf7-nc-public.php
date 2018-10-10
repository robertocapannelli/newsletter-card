<?php

if ( ! class_exists( 'CF7_Nc_Public' ) ) {
	class CF7_Nc_Public {

		/**
		 * CF7_Nc_Public constructor.
		 */
		public function __construct() {
			$this->init();
		}

		/**
		 * Init all methods necessary
		 */
		public function init() {
			if ( ! isset( $_COOKIE['is_card_hidden'] ) ) {
				add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
				add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );
				add_action( 'wp_enqueue_scripts', array( $this, 'get_cookie_option' ) );
				add_action( 'wp_footer', array( $this, 'render_content' ) );
			}
		}

		/**
		 * Enqueue styles
		 */
		public function enqueue_styles() {
			wp_enqueue_style( 'public_style', CF7_NC_PLUGIN_PUBLIC_STYLE, null, CF7_NC_PLUGIN_VERSION );
		}

		/**
		 * Enqueue scripts
		 */
		public function enqueue_scripts() {
			wp_enqueue_script( 'public_script', CF7_NC_PLUGIN_PUBLIC_SCRIPT, array( 'jquery' ), CF7_NC_PLUGIN_VERSION, true );
		}

		/**
		 * Get cookie option
		 */
		public function get_cookie_option() { //TODO this may not be a proper function name
			$nonce = wp_create_nonce( 'is_hidden_card' );
			wp_localize_script( 'public_script', 'my_ajax_obj', array(
				'ajax_url' => admin_url( 'admin-ajax.php' ),
				'nonce'    => $nonce,
			) );
		}

		/**
		 * Render the content to show in the footer
		 */
		public function render_content() {
			include_once CF7_NC_ABSPATH . '/public/view.php';
		}
	}
}
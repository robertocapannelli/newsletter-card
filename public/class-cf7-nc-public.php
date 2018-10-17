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
				//Enqueue scripts
				add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
				//Enqueue styles
				add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );
				//Localize script for AJAX purpose
				add_action( 'wp_enqueue_scripts', array( $this, 'localize_script' ) );
				//Render the front-end content
				add_action( 'wp_footer', array( $this, 'render_content' ) );
			}
		}

		/**
		 * Enqueue styles
		 */
		public function enqueue_styles() {
			//Register style
			wp_register_style( 'public-style', CF7_NC_PLUGIN_PUBLIC_STYLE, null, CF7_NC_PLUGIN_VERSION );
			//Enqueue style
			wp_enqueue_style('public-style');
		}

		/**
		 * Enqueue scripts
		 */
		public function enqueue_scripts() {
			//Register scripts
			wp_register_script( 'public-script', CF7_NC_PLUGIN_PUBLIC_SCRIPT, array( 'jquery' ), CF7_NC_PLUGIN_VERSION, true );
			wp_register_script('jquery-validation', CF7_NC_PLUGIN_URI . '/bower_components/jquery-validation/dist/jquery.validate.js', array( 'jquery' ), '1.18.0', true);
			wp_register_script('jquery-validation-additional', CF7_NC_PLUGIN_URI . '/bower_components/jquery-validation/dist/additional-methods.js', array( 'jquery' ),'1.18.0', true);

			//Enqueue scripts
			wp_enqueue_script('public-script');
			wp_enqueue_script('jquery-validation');
			wp_enqueue_script('jquery-validation-additional');
		}

		/**
		 * Get cookie option
		 */
		public function localize_script() { //TODO make ajax class to handle all the process
			//Creates a cryptographic token tied to a specific action, user, user session, and window of time.
			$nonce = wp_create_nonce( 'is_hidden_card' );

			wp_localize_script(
				'public-script',
				'my_ajax_obj',
				array( 'ajax_url' => admin_url( 'admin-ajax.php' ),
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
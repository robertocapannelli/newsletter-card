<?php

if ( ! class_exists( 'CF7_Nc_Public' ) ) {
	class CF7_Nc_Public {

		/**
		 * The ID of this plugin.
		 *
		 * @since    2.0.0
		 * @access   private
		 * @var      string $plugin_name The ID of this plugin.
		 */
		private $plugin_name;

		/**
		 * The version of this plugin.
		 *
		 * @since    2.0.0
		 * @access   private
		 * @var      string $version The current version of this plugin.
		 */
		private $version;


		/**
		 * Initialize the class and set its properties.
		 *
		 * @since    2.0.0
		 *
		 * @param      string $plugin_name The name of this plugin.
		 * @param      string $version The version of this plugin.
		 */
		public function __construct( $plugin_name, $version ) {
			$this->plugin_name = $plugin_name;
			$this->version     = $version;
		}

		/**
		 * Enqueue styles
		 */
		public function enqueue_styles() {
			//Register style
			wp_register_style( 'public-style', plugin_dir_url( __FILE__ ) . 'assets/css/style.css', null, $this->version );
			//Enqueue style
			wp_enqueue_style( 'public-style' );
		}

		/**
		 * Enqueue scripts
		 */
		public function enqueue_scripts() {
			//Register scripts
			wp_register_script( 'public-script', plugin_dir_url( __FILE__ ) . 'assets/js/main.js', array( 'jquery' ), $this->version, true );
			wp_register_script( 'jquery-validation', plugins_url( CF7_NC_PLUGIN_SLUG ) . '/bower_components/jquery-validation/dist/jquery.validate.js', array( 'jquery' ), '1.18.0', true );
			wp_register_script( 'jquery-validation-additional', plugins_url( CF7_NC_PLUGIN_SLUG ) . '/bower_components/jquery-validation/dist/additional-methods.js', array( 'jquery' ), '1.18.0', true );

			//Enqueue scripts
			wp_enqueue_script( 'public-script' );
			wp_enqueue_script( 'jquery-validation' );
			wp_enqueue_script( 'jquery-validation-additional' );
		}

		/**
		 * Render the content to show in the footer
		 */
		public function render_content() {
			$shortcode = get_option( CF7_NC_PLUGIN_TEXT_DOMAIN . '_shortcode' );
			//needed to invoke is_plugin_active
			include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			$is_active = is_plugin_active( CF7_NC_ABSPATH . '/newsletter-view.php' );

			//check if a CF7 shortcode is provided and if the plugin is active
			if ( ! ( $shortcode || $is_active ) || isset( $_COOKIE['is_card_hidden'] ) ) {
				return;
			}

			include_once CF7_NC_ABSPATH . '/public/view.php';
		}

	}
}
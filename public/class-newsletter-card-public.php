<?php

if ( ! class_exists( 'Newsletter_Card_Public' ) ) {
	class Newsletter_Card_Public {

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
			wp_register_script( 'jquery-validation', plugin_dir_url( __FILE__ ) . 'assets/js/jquery.validate.js', array( 'jquery' ), '1.18.0', true );
			wp_register_script( 'jquery-validation-additional', plugin_dir_url( __FILE__ ) . 'assets/js/additional-methods.js', array( 'jquery' ), '1.18.0', true );

			//Enqueue scripts
			wp_enqueue_script( 'public-script' );
			wp_enqueue_script( 'jquery-validation' );
			wp_enqueue_script( 'jquery-validation-additional' );
		}

		/**
		 * Render the content to show in the footer
		 */
		public function render_content() {
			include_once NEWSLETTER_CARD_ABSPATH . '/public/view.php';
		}
	}
}
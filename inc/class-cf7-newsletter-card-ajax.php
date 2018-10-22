<?php

if( !class_exists('CF7_Newsletter_Card_Ajax')){
	class CF7_Newsletter_Card_Ajax {

		/**
		 * Action hook used by he AJAX class
		 *
		 * @var string
		 */
		const ACTION = 'handle';

		/**
		 * Action argument used by the nonce validating the AJAX request.
		 *
		 * @var string
		 */
		const NONCE = 'is_hidden_card';

		/**
		 * Plugin name
		 *
		 * @var string
		 */
		private $plugin_name;

		/**
		 * Plugin version
		 *
		 * @var string
		 */
		private $version;

		/**
		 * CF7_Newsletter_Card_Ajax constructor.
		 *
		 * @param $plugin_name
		 * @param $version
		 *
		 * @since 2.0.0
		 */
		public function __construct($plugin_name, $version) {
			$this->plugin_name;
			$this->version;
		}

		/**
		 * Build the array to pass to the ajax script with useful information
		 *
		 * @return array
		 */
		private function get_ajax_data() {
			return array(
				'ajax_url' => admin_url( 'admin-ajax.php' ),
				'action'   => self::ACTION,
				'nonce'    => wp_create_nonce( CF7_Newsletter_Card_Ajax::NONCE )
			);
		}

		/**
		 * Localize the file where the ajax script is coded
		 *
		 * @since 1.0.0
		 */
		public function localize_script() {
			$handle      = 'public-script';
			$list        = 'enqueued';
			$object_name = 'my_ajax_obj';
			if ( wp_script_is( $handle, $list ) ) {
				wp_localize_script( $handle, $object_name, $this->get_ajax_data() );
			}
		}

		/**
		 * Handle the ajax request and respond with expiring cookie days
		 *
		 * @since 1.0.0
		 */
		public function handle() {
			check_ajax_referer( self::NONCE );
			$exdays = 2;
			$option = 'cf7_nc_exdays';
			if ( get_option( $option ) ) {
				$exdays = intval( get_option( $option ) );
			}
			echo $exdays;
			wp_die();
		}

		/**
		 * Returns the error
		 *
		 * @param WP_Error $error
		 */
		public function cf7_send_error( WP_Error $error ) {
			wp_send_json( array(
				'code'    => $error->get_error_code(),
				'message' => $error->get_error_message()
			) );
		}
	}
}
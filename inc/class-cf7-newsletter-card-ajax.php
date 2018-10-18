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
		 * Custom constructor that init actions
		 */
		public static function register() {

			$handler = new self();

			add_action( 'wp_enqueue_scripts', array( $handler, 'localize_script' ) );
			add_action( 'wp_ajax_handle', array( $handler, 'handle' ) );
			add_action( 'wp_ajax_nopriv_handle', array( $handler, 'handle' ) );

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
		 */
		public function localize_script() {

			$handle      = 'public-script';
			$list        = 'enqueued';
			$object_name = 'my_ajax_obj';

			if ( wp_script_is( $handle, $list ) ) {
				echo 'Script enqueued ';
				wp_localize_script( $handle, $object_name, $this->get_ajax_data() );
			}
		}

		/**
		 * Handle the ajax request and respond with expiring cookie days
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
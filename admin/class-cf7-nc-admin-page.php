<?php
if ( ! class_exists( 'CF7_Nc_Admin_Page' ) ) {
	class CF7_Nc_Admin_Page {

		private $plugin_slug = 'cf7-newsletter-card';
		private $parent_slug = 'wpcf7';
		private $menu_title = 'CF7 Newsletter Card';
		private $page_title = 'CF7 Newsletter Card';
		private $capability = 'manage_options';

		private $option_group = CF7_NC_PLUGIN_TEXT_DOMAIN . '_group';

		private $settings_section_id = CF7_NC_PLUGIN_TEXT_DOMAIN . '_settings';
		private $settings_section_title = 'Settings';

		private $content_section_id = CF7_NC_PLUGIN_TEXT_DOMAIN . '_content';
		private $content_section_title = 'Content';

		/**
		 * CF7_Nc_Admin_page constructor.
		 */
		public function __construct() {
			$this->init_hooks();
		}

		/**
		 * Hook into actions
		 */
		private function init_hooks(){
			//Configure the settings API
			add_action( 'admin_init', array( $this, 'configure' ) );

			//Get ajax script works
			add_action( 'wp_ajax_get_cookie_option', array($this, 'get_cookie_option') );
			add_action( 'wp_ajax_nopriv_get_cookie_option', array($this, 'get_cookie_option') );

			add_action( 'admin_notices', array($this, 'notices') );

			//Remove WordPress thank you footer
			add_filter( 'admin_footer_text', '__return_empty_string', 11 );
			add_filter( 'update_footer', '__return_empty_string', 11 );
        }

		public function get_parent_slug() {
			return $this->parent_slug;
		}

		public function get_page_title() {
			return $this->page_title;
		}

		public function get_menu_title() {
			return $this->menu_title;
		}

		public function get_capability() {
			return $this->capability;
		}

		public function get_plugin_slug() {
			return $this->plugin_slug;
		}

		/**
		 * Get the setting options to show content in the admin page
		 *
		 * @return array
		 */
		private function get_options() {
			$options = include_once dirname( __FILE__ ) . '/options.php';
			return $options;
		}

		/**
		 * Configure the admin page content
		 */
		public function configure() {

			//TODO we could add this from an array
			//Add the settings section as the function name suggests
			add_settings_section( $this->content_section_id, $this->content_section_title, null, $this->get_plugin_slug() );
			add_settings_section( $this->settings_section_id, $this->settings_section_title, null, $this->get_plugin_slug() );

			//Get options
			$options = $this->get_options();

			//Check if options is an array or an object
			if ( is_array( $options ) || is_object( $options ) ) {
				foreach ( $options as $option ) {

					//Register the setting in database
					register_setting( $this->option_group, $option['option_name'] );

					$args = [
						'type'        => $option['type'],
						'option_name' => $option['option_name'],
						'hint'        => $option['hint'],
						'is_required' => $option['is_required']
					];

					//Add the field to insert in the setting form
					add_settings_field( $option['field_id'], $option['field_title'], array( $this, 'render_option_field' ), $this->get_plugin_slug(), $option['section'], $args );
				}
			}

		}

		/**
		 * Render the entire html admin page
		 */
		public function render_page() {
			// check if the user have submitted the settings
			// wordpress will add the "settings-updated" $_GET parameter to the url
			if ( isset( $_GET['settings-updated'] ) ) {
				// add settings saved message with the class of "updated"
				add_settings_error( CF7_NC_PLUGIN_TEXT_DOMAIN . '_messages', CF7_NC_PLUGIN_TEXT_DOMAIN . '_message', __( 'Settings Saved', CF7_NC_PLUGIN_TEXT_DOMAIN ), 'updated' );
			}

			// show error/update messages
			settings_errors( CF7_NC_PLUGIN_TEXT_DOMAIN . '_messages' );
			//Require page.php file that contains admin view
			require_once( dirname( __FILE__ ) . '/page.php' );
		}

		/**
		 * Render an option field
		 *
		 * @param $args
		 */
		public function render_option_field( $args ) {
			//Get the option from the database
            //TODO ternary operators to check data
			$setting     = get_option( $args['option_name'] );
			$type        = esc_attr( $args['type'] );
			$option_name = esc_attr( $args['option_name'] );
			$hint        = $args['hint'];
			$value       = isset( $setting ) ? esc_attr( $setting ) : '';
			$required    = ( $args['is_required'] == true ) ? esc_attr( 'required' ) : '';
			$range       = ( $type == 'number' ) ? 'min="0"' : '';

			$input    = <<<HTML
        <input type="$type" $range name="$option_name" value="$value" $required>
HTML;
			$textarea = <<<HTML
        <textarea name="$option_name" $required>$value</textarea>
HTML;
			switch ( $args['type'] ) {
				case 'date':
				case 'color':
				case 'checkbox':
				case 'password':
				case 'number':
				case 'email':
				case 'text':
					echo $input;
					break;
				case 'textarea':
					echo $textarea;
					break;
			}

			?>
            <p class="description"><?= $hint ?></p>
			<?php
		}

		/**
		 * Get cookies options
		 */
		public function get_cookie_option() {
			check_ajax_referer( 'is_hidden_card' );
			$exdays = 2;
			if ( get_option( CF7_NC_PLUGIN_TEXT_DOMAIN . '_exdays' ) ) {
				$exdays = get_option( CF7_NC_PLUGIN_TEXT_DOMAIN . '_exdays' );
			}
			echo $exdays;
			wp_die();
		}

		/**
		 * Display notices checking if CF7 plugin is installed and is active
		 */
		public function notices(){
			if ( ! file_exists( WP_PLUGIN_DIR . '/contact-form-7/wp-contact-form-7.php' ) ) {
				$error = '<div id="message" class="error is-dismissible"><p>';
				$error .= __( 'The Contact Form 7 plugin must be installed for the <b>Newsletter card plugin</b> to work. <b><a href="' . admin_url( 'plugin-install.php?tab=plugin-information&plugin=contact-form-7&from=plugins&TB_iframe=true&width=600&height=550' ) . '" class="thickbox" title="Contact Form 7">Install Contact Form 7 Now.</a></b>', CF7_NC_PLUGIN_TEXT_DOMAIN );
				$error .= '</p></div>';
				echo $error;
			} else if ( ! class_exists( 'WPCF7' ) ) {
				$error = '<div id="message" class="error is-dismissible"><p>';
				$error .= __( 'The Contact Form 7 is installed, but <strong>you must activate Contact Form 7</strong> below for the <b>Newsletter card plugin</b> to work.', CF7_NC_PLUGIN_TEXT_DOMAIN );
				$error .= '</p></div>';
				echo $error;
			}
        }


	}
}
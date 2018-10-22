<?php
if ( ! class_exists( 'CF7_Nc_Admin_Page' ) ) {
	class CF7_Nc_Admin_Page {

		//TODO these should be constant
		private $plugin_slug;
		private $plugin_name;
		private $capability;
		private $option_group;
		private $content_section_id;
		private $content_section_title;
		private $settings_section_id;
		private $settings_section_title;
		private $parent_slug;

		/**
		 * CF7_Nc_Admin_Page constructor.
         *
         * @since 1.0.0
		 */
		public function __construct() {
			$this->set_plugin_slug( 'cf7-newsletter-card' );
			$this->set_plugin_name( 'Newsletter Card' );
			$this->set_capability( 'manage_options' );
			$this->set_option_group( 'newsletter_card_group' );
			$this->set_content_section_id( 'newsletter_card_content' );
			$this->set_content_section_title( 'Content' );
			$this->set_settings_section_id( 'newsletter_card_settings' );
			$this->set_settings_section_title( 'Settings' );
			$this->set_parent_slug( 'wpcf7' );
			$this->remove_thank_you_footer(); //TODO I dont like it here
		}

		/**
		 * Remove WordPress footer text
         *
         * @since 2.0.0
		 */
		private function remove_thank_you_footer() {
			//Remove WordPress thank you footer
			add_filter( 'admin_footer_text', '__return_empty_string', 11 );
			add_filter( 'update_footer', '__return_empty_string', 11 );
		}

		/**
		 * @param string $plugin_slug
		 */
		public function set_plugin_slug( string $plugin_slug ): void {
			$this->plugin_slug = $plugin_slug;
		}

		/**
		 * @param string $plugin_name
		 */
		public function set_plugin_name( string $plugin_name ): void {
			$this->plugin_name = $plugin_name;
		}

		/**
		 * @param string $capability
		 */
		public function set_capability( string $capability ): void {
			$this->capability = $capability;
		}

		/**
		 * @param string $option_group
		 */
		public function set_option_group( string $option_group ): void {
			$this->option_group = $option_group;
		}

		/**
		 * @param string $content_section_id
		 */
		public function set_content_section_id( string $content_section_id ): void {
			$this->content_section_id = $content_section_id;
		}

		/**
		 * @param string $content_section_title
		 */
		public function set_content_section_title( string $content_section_title ): void {
			$this->content_section_title = $content_section_title;
		}

		/**
		 * @param string $settings_section_id
		 */
		public function set_settings_section_id( string $settings_section_id ): void {
			$this->settings_section_id = $settings_section_id;
		}

		/**
		 * @param string $settings_section_title
		 */
		public function set_settings_section_title( string $settings_section_title ): void {
			$this->settings_section_title = $settings_section_title;
		}

		/**
		 * @param string $parent_slug
		 */
		public function set_parent_slug( string $parent_slug ): void {
			$this->parent_slug = $parent_slug;
		}

		/**
		 * @return string
		 */
		public function get_plugin_slug(): string {
			return $this->plugin_slug;
		}

		/**
		 * @return string
		 */
		public function get_parent_slug(): string {
			return $this->parent_slug;
		}

		/**
		 * @return string
		 */
		public function get_menu_title(): string {
			return $this->plugin_name;
		}

		/**
		 * @return string
		 */
		public function get_page_title(): string {
			return $this->plugin_name;
		}

		/**
		 * @return string
		 */
		public function get_capability(): string {
			return $this->capability;
		}

		/**
		 * @return string
		 */
		public function get_option_group(): string {
			return $this->option_group;
		}

		/**
		 * @return string
		 */
		public function get_settings_section_id(): string {
			return $this->settings_section_id;
		}

		/**
		 * @return string
		 */
		public function get_settings_section_title(): string {
			return $this->settings_section_title;
		}

		/**
		 * @return string
		 */
		public function get_content_section_id(): string {
			return $this->content_section_id;
		}

		/**
		 * @return string
		 */
		public function get_content_section_title(): string {
			return $this->content_section_title;
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

			//Add the settings section as the function name suggests
			add_settings_section( $this->get_content_section_id(), $this->get_content_section_title(), null, $this->get_plugin_slug() );
			add_settings_section( $this->get_settings_section_id(), $this->get_settings_section_title(), null, $this->get_plugin_slug() );

			//Get options
			$options = $this->get_options();

			//Check if options is an array or an object
			if ( is_array( $options ) || is_object( $options ) ) {

				if ( ! class_exists( 'CF7_Option_Field' ) ) {
					include_once CF7_NC_ABSPATH . '/admin/class-cf7-newsletter-card-option-field.php';
				}

				foreach ( $options as $option ) {

					//Register the setting in database
					register_setting( $this->option_group, $option['option_name'] );

					$object = new CF7_Option_Field( $option );

					$args = [
						'type'        => $object->get_type(),
						'option_name' => $object->get_option_name(),
						'hint'        => $object->get_hint(),
						'is_required' => $object->is_required()
					];

					//Add the field to insert in the setting form
					add_settings_field( $object->get_field_id(), $object->get_field_title(), array(
						$this,
						'render_option_field'
					), $this->get_plugin_slug(), $object->get_section(), $args );
				}
			}
		}

		/**
		 * Render the entire html admin page
		 *
		 * @since 1.0.0
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
			if ( ! get_option( $args['option_name'] ) ) {
				return;
			}
			$value       = get_option( $args['option_name'] );
			$type        = esc_attr( $args['type'] );
			$option_name = esc_attr( $args['option_name'] );
			$hint        = $args['hint'];

			$required = ( $args['is_required'] == true ) ? esc_attr( 'required' ) : '';
			$range    = ( $type == 'number' ) ? 'min="0"' : '';

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
		 * Display notices checking if CF7 plugin is installed and is active
         *
         * @since 1.0.0
		 */
		public function notices() {
			include_once CF7_NC_ABSPATH . '/admin/notice.php';
		}

		/**
		 * Add menu to admin sidebar
         *
         * @since 1.0.0
		 */
		public function add_menus() {
			//Check if CF7 is installed
			if ( ! is_plugin_active( 'contact-form-7/wp-contact-form-7.php' ) ) {
				return;
			}
			//Add submenu under CF7 menu
			add_submenu_page(
				$this->get_parent_slug(),
				$this->get_page_title(),
				$this->get_menu_title(),
				$this->get_capability(),
				$this->get_plugin_slug(),
				array( $this, 'render_page' )
			);
		}


	}
}
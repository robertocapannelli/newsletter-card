<?php
if ( ! class_exists( 'Newsletter_Card_Admin' ) ) {
	class Newsletter_Card_Admin {

		//TODO these should be constant
		private $plugin_slug;
		private $plugin_name;
		private $capability;
		private $option_group;
		private $content_section_id;
		private $content_section_title;
		private $general_section_id;
		private $general_section_title;
		private $parent_slug;

		/**
		 * CF7_Nc_Admin_Page constructor.
		 *
		 * @since 1.0.0
		 *
		 * @param $plugin_name
		 * @param $plugin_slug
		 */
		public function __construct( $plugin_name, $plugin_slug ) {
			$this->plugin_name = $plugin_name;
			$this->plugin_slug = $plugin_slug;
			$this->set_capability( 'manage_options' );
			$this->set_option_group( 'newsletter_card_group' );
			$this->set_content_section_id( 'newsletter_card_content' );
			$this->set_content_section_title( 'Content' );
			$this->set_general_section_id( 'newsletter_card_general' );
			$this->set_general_section_title( 'General' );
			$this->set_parent_slug( 'wpcf7' );

			$this->remove_thank_you_footer(); //TODO I dont like it here
		}

		/**
		 * Add menu to admin sidebar if the Contact form 7 plugin is installed and activated
		 *
		 * @since 1.0.0
		 */
		public function add_menus() {
			if ( ! is_plugin_active( 'contact-form-7/wp-contact-form-7.php' ) ) {
				return;
			}
			add_submenu_page(
				$this->get_parent_slug(),
				$this->get_page_title(),
				$this->get_menu_title(),
				$this->get_capability(),
				$this->get_plugin_slug(),
				[ $this, 'render_page' ]
			);
		}

		/**
		 * Configure the admin page content and its content
		 *
		 * @since 1.0.0
		 */
		public function configure() {
			add_settings_section(
				$this->get_content_section_id(),
				$this->get_content_section_title(),
				null,
				$this->get_plugin_slug() );

			add_settings_section(
				$this->get_general_section_id(),
				$this->get_general_section_title(),
				null,
				$this->get_plugin_slug() );

			$options = $this->get_options();

			if ( is_array( $options ) || is_object( $options ) ) {

				echo 'is array and is object';

				if ( ! class_exists( 'Newsletter_Card_Option_Field' ) ) {
					include_once NEWSLETTER_CARD_ABSPATH . '/admin/class-newsletter-card-option-field.php';
				}

				foreach ( $options as $option ) {
					register_setting( $this->option_group, $option['option_name'] );
					$object = new Newsletter_Card_Option_Field( $option );
					$args   = [
						'type'        => $object->get_type(),
						'option_name' => $object->get_option_name(),
						'hint'        => $object->get_hint(),
						'is_required' => $object->is_required()
					];

					//Add the field to insert in the setting form
					add_settings_field(
						$object->get_field_id(),
						$object->get_field_title(),
						[ $this, 'render_option_field' ],
						$this->get_plugin_slug(),
						$object->get_section(),
						$args );
				}
			}
		}

		/**
		 * Render the entire html admin page
		 *
		 * @since 1.0.0
		 */
		public function render_page() {
			if ( isset( $_GET['settings-updated'] ) ) {
				add_settings_error(
					NEWSLETTER_CARD_TEXT_DOMAIN . '_messages',
					NEWSLETTER_CARD_TEXT_DOMAIN . '_message',
					__( 'Settings Saved', NEWSLETTER_CARD_TEXT_DOMAIN ),
					'updated' );
			}
			settings_errors( NEWSLETTER_CARD_TEXT_DOMAIN . '_messages' );
			require_once( dirname( __FILE__ ) . '/page.php' );
		}

		/**
		 * Render an option field
		 *
		 * @param $args
		 *
		 * @since 1.0.0
		 */
		public function render_option_field( $args ) {
			$value       = get_option( $args['option_name'] );
			$type        = esc_attr( $args['type'] );
			$option_name = esc_attr( $args['option_name'] );
			$hint        = $args['hint'];

			$required = ( $args['is_required'] == true ) ? esc_attr( 'required' ) : '';
			$range    = ( $type == 'number' ) ? 'min="0"' : '';

			//TODO this is shit like this
			$input    = <<<HTML
        <input type='$type' $range name='$option_name' value='$value' $required>
HTML;
			$textarea = <<<HTML
        <textarea name='$option_name' $required>$value</textarea>
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
			include_once NEWSLETTER_CARD_ABSPATH . '/admin/notice.php';
		}

		/**
		 * Remove WordPress footer text
		 *
		 * @since 2.0.0
		 */
		private function remove_thank_you_footer() {
			add_filter( 'admin_footer_text', '__return_empty_string', 11 );
			add_filter( 'update_footer', '__return_empty_string', 11 );
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
		 * @param string $general_section_id
		 */
		public function set_general_section_id( string $general_section_id ): void {
			$this->general_section_id = $general_section_id;
		}

		/**
		 * @param string $general_section_title
		 */
		public function set_general_section_title( string $general_section_title ): void {
			$this->general_section_title = $general_section_title;
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
		public function get_general_section_id(): string {
			return $this->general_section_id;
		}

		/**
		 * @return string
		 */
		public function get_general_section_title(): string {
			return $this->general_section_title;
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
	}
}
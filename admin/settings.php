<?php
//Remove WordPress thank you footer
add_filter( 'admin_footer_text', '__return_empty_string', 11 );
add_filter( 'update_footer', '__return_empty_string', 11 );

//Group
define( 'CF7_NC_OPTION_GROUP', CF7_NC_PLUGIN_TEXT_DOMAIN . '_group' );

//Section settings
define( 'CF7_NC_SECTION_SETTINGS_ID', CF7_NC_PLUGIN_TEXT_DOMAIN . '_settings' );
define( 'CF7_NC_SECTION_SETTINGS_TITLE', 'Settings' );

//Settings content
define( 'CF7_NC_SECTION_CONTENT_ID', CF7_NC_PLUGIN_TEXT_DOMAIN . '_content' );
define( 'CF7_NC_SECTION_CONTENT_TITLE', 'Content' );

//Page slug
define( 'CF7_NC_PAGE', 'cf7-newsletter-card' );

//Field callback function
define( 'CF7_NC_FIELD_CB', CF7_NC_PLUGIN_TEXT_DOMAIN . '_settings_field_callback' );

//these are option to cycle for admin form
$options = include CF7_NC_PLUGIN_DIR . 'options.php';

/**
 * Add the CF7 newsletter card sub menu to the CF7 main menu
 */

if(!function_exists('cf7_nc_menu')){
	function cf7_nc_menu() {
		//Check if CF7 is installed
		if ( ! is_plugin_active( 'contact-form-7/wp-contact-form-7.php' ) ) {
			return;
		}
		//Add submenu under CF7 menu
		add_submenu_page(
			'wpcf7',
			CF7_NC_PLUGIN_NAME,
			CF7_NC_PLUGIN_NAME,
			'manage_options',
			CF7_NC_PAGE,
			'cf7_nc_options_page_html'
		);
	}
	add_action( 'admin_menu', 'cf7_nc_menu' );
}

/**
 * Callback function for add_submenu
 */

if(!function_exists('cf7_nc_options_page_html')){
	function cf7_nc_options_page_html() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		// check if the user have submitted the settings
		// wordpress will add the "settings-updated" $_GET parameter to the url
		if ( isset( $_GET['settings-updated'] ) ) {
			// add settings saved message with the class of "updated"
			add_settings_error( CF7_NC_PLUGIN_TEXT_DOMAIN . '_messages', CF7_NC_PLUGIN_TEXT_DOMAIN . '_message', __( 'Settings Saved', CF7_NC_PLUGIN_TEXT_DOMAIN ), 'updated' );
		}

		// show error/update messages
		settings_errors( CF7_NC_PLUGIN_TEXT_DOMAIN . '_messages' );
		//Require view.php file that contains admin view
		require_once( CF7_NC_PLUGIN_DIR . 'admin/view.php' );
	}
}

/**
 * This function init the form components
 */

if(!function_exists('cf7_nc_settings_init')){
	function cf7_nc_settings_init() {

		global $options;

		//Add the settings section as the function name suggests
		add_settings_section(
			CF7_NC_SECTION_CONTENT_ID,
			CF7_NC_SECTION_CONTENT_TITLE,
			null,
			CF7_NC_PAGE
		);

		add_settings_section(
			CF7_NC_SECTION_SETTINGS_ID,
			CF7_NC_SECTION_SETTINGS_TITLE,
			null,
			CF7_NC_PAGE
		);

		if ( is_array( $options ) || is_object( $options ) ) {
			foreach ( $options as $option ) {

				//Register the setting in database
				register_setting(
					CF7_NC_OPTION_GROUP,
					$option['option_name']
				);

				//Add the field to insert in the setting form
				add_settings_field(
					$option['field_id'],
					$option['field_title'],
					CF7_NC_FIELD_CB,
					CF7_NC_PAGE,
					$option['section'],
					[
						'type'        => $option['type'],
						'option_name' => $option['option_name'],
						'hint'        => $option['hint'],
						'is_required' => $option['is_required']
					]
				);
			}

		}
	}
	add_action( 'admin_init', 'cf7_nc_settings_init' );
}

/**
 * Callback add_setting_fields
 */

if(!function_exists('cf7_nc_settings_field_callback')){
	function cf7_nc_settings_field_callback( $args ) {
		//Get the option from the database
		$setting     = get_option( $args['option_name'] );
		$type        = esc_attr( $args['type'] );
		$option_name = esc_attr( $args['option_name'] );
		$hint        = $args['hint'];
		$value       = isset( $setting ) ? esc_attr( $setting ) : '';
		$required    = ( $args['is_required'] == true ) ? esc_attr( 'required' ) : '';
		$range = ( $type == 'number' ) ? 'min="0"' : ''; //TODO fix the cookie parameter
		$text     = <<<HTML
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
				echo $text;
				break;
			case 'textarea':
				echo $textarea;
				break;
		}
		?>
        <p class="description"><?= $hint ?></p>
		<?php
	}
}

/**
 * Get cookie option from the database
 */

if(!function_exists('cf7_nc_get_cookie_option')){
	function cf7_nc_get_cookie_option() {
		check_ajax_referer( 'is_hidden_card' );
		$exdays = 2;
		if ( get_option( CF7_NC_PLUGIN_TEXT_DOMAIN . '_exdays' ) ) {
			$exdays = get_option( CF7_NC_PLUGIN_TEXT_DOMAIN . '_exdays' );
		}
		echo $exdays;
		wp_die();
	}
	add_action( 'wp_ajax_' . CF7_NC_PLUGIN_TEXT_DOMAIN . '_get_cookie_option', 'cf7_nc_get_cookie_option' );
	add_action( 'wp_ajax_nopriv_' . CF7_NC_PLUGIN_TEXT_DOMAIN . '_get_cookie_option', 'cf7_nc_get_cookie_option' );
}
<?php
//Remove WordPress thank you footer
add_filter( 'admin_footer_text', '__return_empty_string', 11 );
add_filter( 'update_footer',     '__return_empty_string', 11 );

//Group
define( 'OPTION_GROUP', 'walkap_cf7nc_group' );

//Section settings
define( 'SECTION_SETTINGS_ID', 'walkap_cf7nc_settings' );
define( 'SECTION_SETTINGS_TITLE', 'Settings' );

//Settings content
define( 'SECTION_CONTENT_ID', 'walkap_cf7nc_content' );
define( 'SECTION_CONTENT_TITLE', 'Content' );

//Page slug
define( 'PAGE', 'cf7-newsletter-card' );

//Field callback function
define( 'FIELD_CB', 'walkap_cf7nc_settings_field_callback' );

//these are option to cycle for admin form
$options = [
	[
		'option_name' => 'walkap_cf7nc_shortcode',
		'type'        => 'text',
		'section'     => SECTION_CONTENT_ID,
		'field_id'    => 'shortcode',
		'field_title' => 'Shortcode *',
		'is_required' => true,
		'hint'        => 'Type here your CF7 shortcode, make sure your form has just an email field to have a cooler newsletter card'
	],
	[
		'option_name' => 'walkap_cf7nc_title',
		'type'        => 'text',
		'section'     => SECTION_CONTENT_ID,
		'field_id'    => 'title',
		'field_title' => 'Card Title',
		'is_required' => false,
		'hint'        => 'Type here the title you want to display in the front-end, just above the description and the form field'
	],
	[
		'option_name' => 'walkap_cf7nc_description',
		'type'        => 'textarea',
		'section'     => SECTION_CONTENT_ID,
		'field_id'    => 'description',
		'field_title' => 'Card description',
		'is_required' => false,
		'hint'        => 'Type here the description you want to display in the front-end, between the title and the form field'
	],
	[
		'option_name' => 'walkap_cf7nc_exdays',
		'type'        => 'number',
		'section'     => SECTION_SETTINGS_ID,
		'field_id'    => 'exdays',
		'field_title' => 'Cookie expiring days',
		'is_required' => false,
		'hint'        => 'Choose how many days you want to remember the user choice about to show or not the newsletter card. <br> Default value is 2 days'
	]
];

/**
 * This function init the form components
 */
function walkap_cf7nc_settings_init() {

	global $options;

	//Add the settings section as the function name suggests
	add_settings_section(
		SECTION_CONTENT_ID,
		SECTION_CONTENT_TITLE,
		null,
		PAGE
	);

	add_settings_section(
		SECTION_SETTINGS_ID,
		SECTION_SETTINGS_TITLE,
		null,
		PAGE
	);

	if ( is_array( $options ) || is_object( $options ) ) {
		foreach ( $options as $option ) {

			//Register the setting in database
			register_setting(
				OPTION_GROUP,
				$option['option_name']
			);

			//Add the field to insert in the setting form
			add_settings_field(
				$option['field_id'],
				$option['field_title'],
				FIELD_CB,
				PAGE,
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

add_action( 'admin_init', 'walkap_cf7nc_settings_init' );

/**
 * Callback add_setting_fields
 */
function walkap_cf7nc_settings_field_callback( $args ) {

	//Get the option from the database
	$setting     = get_option( $args['option_name'] );
	$type        = esc_attr( $args['type'] );
	$option_name = esc_attr( $args['option_name'] );
	$hint        = $args['hint'];
	$value       = isset( $setting ) ? esc_attr( $setting ) : '';
	$required    = isset( $args['is_required'] ) ? esc_attr( 'required' ) : '';

	$range = ($type == 'number') ? 'min="0"' : '';

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

/**
 * Get cookie option from the database
 */
function walkap_cf7nc_get_cookie_option() {
	check_ajax_referer( 'is_hidden_card' );
	$exdays = 2;
	if ( get_option( 'walkap_cf7nc_exdays' ) ) {
		$exdays = get_option( 'walkap_cf7nc_exdays' );
	}
	echo $exdays;
	wp_die();
}

add_action( 'wp_ajax_walkap_cf7nc_get_cookie_option', 'walkap_cf7nc_get_cookie_option' );
add_action( 'wp_ajax_nopriv_walkap_cf7nc_get_cookie_option', 'walkap_cf7nc_get_cookie_option' );
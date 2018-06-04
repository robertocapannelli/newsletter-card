<?php

define( 'OPTION_GROUP', 'walkap_cf7nc_group' );

define( 'SECTION_ID', 'walkap_cf7nc_section' );

define( 'SECTION_TITLE', 'Settings' );

define( 'PAGE', 'cf7-newsletter-card' );

define( 'FIELD_CB', 'walkap_cf7nc_settings_field_callback' );

//these are option to cycle for admin form
$options = [
	[
		'option_name' => 'walkap_cf7nc_shortcode',
		'type'        => 'text',
		'field_id'    => 'shortcode',
		'field_title' => 'Shortcode *',
		'is_required' => true,
		'hint'        => 'Type here your CF7 shortcode, make sure your form has just an email field to have a cooler newsletter card'
	],
	[
		'option_name' => 'walkap_cf7nc_title',
		'type'        => 'text',
		'field_id'    => 'title',
		'field_title' => 'Card Title',
		'is_required' => false,
		'hint'        => 'Type here the title you want to display in the front-end, just above the description and the form field'
	],
	[
		'option_name' => 'walkap_cf7nc_description',
		'type'        => 'textarea',
		'field_id'    => 'description',
		'field_title' => 'Card description',
		'is_required' => false,
		'hint'        => 'Type here the description you want to display in the front-end, between the title and the form field'
	]
];

/**
 * This function init the form components
 */
function walkap_cf7nc_settings_init() {

	global $options;

	//Add the settings section as the function name suggests
	add_settings_section(
		SECTION_ID,
		SECTION_TITLE,
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
				SECTION_ID,
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
	$hint        = esc_html( $args['hint'] );
	$value       = isset( $setting ) ? esc_attr( $setting ) : '';
	$required = ($args['is_required']) ? 'required' : '';

	$text     = <<<HTML
        <input type="$type" name="$option_name" value="$value" $required>
HTML;
	$textarea = <<<HTML
        <textarea name="$option_name" $required>$value</textarea>
HTML;

	switch ( $args['type'] ) {
        case 'date':
        case 'color':
        case 'checkbox':
        case 'password':
        case 'numebr':
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
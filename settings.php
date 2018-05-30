<?php

/**
 *
 * Add the CF7 newsletter card sub menu to the CF7 main menu
 *
 */
function walkap_cf7nc_options_page() {
	if ( ! is_plugin_active( 'contact-form-7/wp-contact-form-7.php' ) ) {
		return;
	}
	add_submenu_page(
		'wpcf7',
		'CF7 newsletter card',
		'Newsletter card',
		'manage_options',
		'cf7-newsletter-card',
		'walkap_cf7nc_options_page_html'
	);
}
add_action( 'admin_menu', 'walkap_cf7nc_options_page' );

function walkap_cf7nc_options_page_html() {
	require plugin_dir_path(__FILE__) . '/admin/view.php';
}


$options = [
	[
		'option_group'     => 'walkap_cf7nc_group',
		'option_name'      => 'walkap_cf7nc_shortcode',
		'type'             => 'text',
		'section_id'       => 'walkap_cf7nc_section',
		'section_title'    => 'CF7 Newsletter Card Section',
		'section_callback' => 'walkap_cf7nc_settings_section_callback',
		'page'             => 'cf7-newsletter-card',
		'field_id'         => 'walkap_cf7nc_settings_field',
		'field_title'      => 'CF7 Newsletter Card Setting',
		'field_callback'   => 'walkap_cf7nc_settings_field_callback',
		'field_section'    => 'walkap_cf7nc_settings_section',
		'hint'             => 'Type here your CF7 shortcode'
	]
];

function walkap_cf7nc_settings_init() {

	global $options;

	add_settings_section(
		'walkap_cf7nc_settings_section',
		'CF7 Newsletter Card Section',
		null,
		'cf7-newsletter-card'
	);

	if ( is_array( $options ) || is_object( $options ) ) {
		foreach ( $options as $option ) {

			register_setting(
				$option['option_group'],
				$option['option_name']
			);

			add_settings_field(
				$option['field_id'],
				$option['field_title'],
				$option['field_callback'],
				$option['page'],
				$option['field_section'],
				[
					'type' => $option['type'],
					'name' => $option['option_name'],
					'hint' => $option['hint']
				]
			);
		}

	}
}
add_action( 'admin_init', 'walkap_cf7nc_settings_init' );

function walkap_cf7nc_settings_field_callback( $args ) {
	$setting = get_option( 'walkap_cf7nc_shortcode' );
	?>
	<input type="<?= esc_attr( $args['type'] ); ?>" name="<?= esc_attr( $args['name'] ); ?>"
	       value="<?= isset( $setting ) ? esc_attr( $setting ) : ''; ?>">
	<p class="description"><?= esc_attr__($args['hint']); ?></p>
	<?php
}
<?php

//TODO move this into includes folder

return [
	[
		'option_name' => CF7_NC_PLUGIN_TEXT_DOMAIN . '_shortcode',
		'type'        => 'text',
		'section'     => CF7_NC_SECTION_CONTENT_ID,
		'field_id'    => 'shortcode',
		'field_title' => 'Shortcode *',
		'is_required' => true,
		'hint'        => 'Type here your CF7 shortcode, make sure your form has just an email field to have a cooler newsletter card'
	],
	[
		'option_name' => CF7_NC_PLUGIN_TEXT_DOMAIN . '_title',
		'type'        => 'text',
		'section'     => CF7_NC_SECTION_CONTENT_ID,
		'field_id'    => 'title',
		'field_title' => 'Card Title',
		'is_required' => false,
		'hint'        => 'Type here the title you want to display in the front-end, just above the description and the form field'
	],
	[
		'option_name' => CF7_NC_PLUGIN_TEXT_DOMAIN . '_description',
		'type'        => 'textarea',
		'section'     => CF7_NC_SECTION_CONTENT_ID,
		'field_id'    => 'description',
		'field_title' => 'Card description',
		'is_required' => false,
		'hint'        => 'Type here the description you want to display in the front-end, between the title and the form field'
	],
	[
		'option_name' => CF7_NC_PLUGIN_TEXT_DOMAIN . '_exdays',
		'type'        => 'number',
		'section'     => CF7_NC_SECTION_SETTINGS_ID,
		'field_id'    => 'exdays',
		'field_title' => 'Cookie expiring days',
		'is_required' => false,
		'hint'        => 'Choose how many days you want to remember the user choice about to show or not the newsletter card. <br> Default value is 2 days'
	]
];
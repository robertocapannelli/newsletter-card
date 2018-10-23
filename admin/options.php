<?php

return [
	[
		'option_name' => 'newsletter_card_shortcode',
		'type'        => 'text',
		'section'     => 'newsletter_card_content',
		'field_id'    => 'shortcode',
		'field_title' => 'Shortcode *',
		'is_required' => true,
		'hint'        => 'Type here your CF7 shortcode, make sure your form has just an email field to have a cooler newsletter card'
	],
	[
		'option_name' => 'newsletter_card_title',
		'type'        => 'text',
		'section'     => 'newsletter_card_content',
		'field_id'    => 'title',
		'field_title' => 'Card Title',
		'is_required' => false,
		'hint'        => 'Type here the title you want to display in the front-end, just above the description and the form field'
	],
	[
		'option_name' => 'newsletter_card_description',
		'type'        => 'textarea',
		'section'     => 'newsletter_card_content',
		'field_id'    => 'description',
		'field_title' => 'Card description',
		'is_required' => false,
		'hint'        => 'Type here the description you want to display in the front-end, between the title and the form field'
	],
	[
		'option_name' => 'newsletter_card_exdays',
		'type'        => 'number',
		'section'     => 'newsletter_card_general',
		'field_id'    => 'exdays',
		'field_title' => 'Cookie expiring days',
		'is_required' => false,
		'hint'        => 'Choose how many days you want to remember the user choice about to show or not the newsletter card. <br> Default value is 2 days'
	]
];
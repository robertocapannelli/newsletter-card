<?php

return [
	[
		'option_name' => 'newsletter_card_shortcode',
		'type'        => 'text',
		'section'     => 'newsletter_card_content',
		'field_id'    => 'shortcode',
		'field_title' => 'Shortcode *',
		'is_required' => true,
		'hint'        => 'Type here your CF7 shortcode!<br><br><b>Reminder for CF7 configuration (minimum requirements to make things work)</b><br> 1) Make sure you have exactly one email field called your_email like <b>[email* your_email id:email]</b>,
this field should be mandatory the * symbol does the job.<br>
		2) All other fields should be wrapped inside a div with class "hidden-fields" like <b>' . htmlentities('<div class="hidden-fields">...</div>') . '</b><br>
		3) At the end of the content copy and paste this tag <b>' .  htmlentities('<button type="button">Register</button>') . '</b>'
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
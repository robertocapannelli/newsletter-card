<?php

$html = <<<HTML

<div class="field">
  <label for="email">Email*</label>
  [email* your_email id:email]
</div>

<div class="hidden-fields">
  <div class="field">
    <label for="name">Name</label>
    [text your-name id:name placeholder "Your name"]
  </div>
  
  <div class="field">
    <label for="last-name">Last Name</label>
    [text last-name id:last-name placeholder "Your last name"]
  </div>

  <div class="field">
    <label for="gender">Gender</label>
    [select gender id:gender include_blank "Male" "Female" "Other"]
  </div>

</div>

<button type="button" class="submit-button">Register</button>

HTML;

return [
	[
		'option_name' => 'newsletter_card_shortcode',
		'type'        => 'text',
		'section'     => 'newsletter_card_content',
		'field_id'    => 'shortcode',
		'field_title' => 'Shortcode *',
		'is_required' => true,
		'hint'        => 'Type here your CF7 shortcode!<br><br><b>
							Reminder for CF7 configuration (minimum requirements to make things work)</b><br> 
							1) Make sure you have exactly one email field called your_email like <b>[email* your_email id:email]</b>,
							this field should be mandatory the * symbol does the job.<br>
							2) All other fields should be wrapped inside a div with class "hidden-fields" like <b><code>' . htmlentities('<div class="hidden-fields">...</div>') . '</code></b><br>
							3) At the end of the content copy and paste this tag <b><code>' .  htmlentities('<button type="button">Register</button>') . '</code></b><br>
							<h3>Complete Example</h3><code>' . htmlentities($html) .'</code>'
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
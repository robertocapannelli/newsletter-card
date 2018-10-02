<div class="wrap">
        <h1><?= esc_html( get_admin_page_title() ); ?></h1>
        <form action="options.php" method="post">
			<?php
			settings_fields( CF7_NC_OPTION_GROUP );
			do_settings_sections( CF7_NC_PAGE );
			submit_button( 'Save Settings' );
			?>
        </form>
    </div>
<p>The symbol * means the field is mandatory.</p>
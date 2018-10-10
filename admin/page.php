<div class="wrap">
        <h1><?= $this->get_page_title(); ?></h1>
        <form action="options.php" method="post">
			<?php
			settings_fields( $this->option_group );
			do_settings_sections( $this->get_plugin_slug() );
			submit_button( 'Save Settings' );
			?>
        </form>
    </div>
<p>The symbol * means the field is mandatory.</p>
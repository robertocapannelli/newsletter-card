<?php
if ( ! current_user_can( 'manage_options' ) ) {
	return;
}

?>
    <div class="wrap">
        <h1><?= esc_html( get_admin_page_title() ); ?></h1>
        <form action="options.php" method="post">
			<?php
			settings_fields( 'walkap_cf7nc_group' );
			do_settings_sections( 'cf7-newsletter-card' );
			submit_button( 'Save Settings' );
			?>
        </form>
    </div>
<?php
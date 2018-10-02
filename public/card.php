<div class="cf7nc-card-container">
    <div class="cf7nc-card-wrapper">
		<?php if ( get_option( CF7_NC_PLUGIN_TEXT_DOMAIN . '_title' ) ) { ?>
            <div class="header">
                <h4><?= get_option( CF7_NC_PLUGIN_TEXT_DOMAIN . '_title' ) ?></h4>
            </div>
		<?php } ?>
		<?php if ( get_option( CF7_NC_PLUGIN_TEXT_DOMAIN . '_description' ) ) { ?>
            <div class="description">
                <p><?= get_option( CF7_NC_PLUGIN_TEXT_DOMAIN . '_description' ) ?></p>
            </div>
		<?php } ?>
        <div class="content">
			<?= do_shortcode( get_option( CF7_NC_PLUGIN_TEXT_DOMAIN . '_shortcode' ) ); ?>
        </div>
        <span class="close-button">X</span>
    </div>
</div>
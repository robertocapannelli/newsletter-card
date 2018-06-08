<div class="cf7nc-card-container">

    <div class="cf7nc-card-wrapper">

		<?php if ( get_option( 'walkap_cf7nc_title' ) ) { ?>
            <div class="header">
                <h4><?= get_option( 'walkap_cf7nc_title' ) ?></h4>
            </div>
		<?php } ?>

		<?php if ( get_option( 'walkap_cf7nc_description' ) ) { ?>
            <div class="description">
                <p><?= get_option( 'walkap_cf7nc_description' ) ?></p>
            </div>
		<?php } ?>

        <div class="content">
			<?= do_shortcode( get_option( 'walkap_cf7nc_shortcode' ) ); ?>
        </div>

        <span class="close-button">X</span>

    </div>

</div>
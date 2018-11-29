<div class="newsletter-card-wrapper" id="newsletter-card-wrapper">
    <div class="container">
		<?php if ( get_option( NEWSLETTER_CARD_TEXT_DOMAIN . '_title' ) ) { ?>
            <div class="header">
                <h4><?= get_option( NEWSLETTER_CARD_TEXT_DOMAIN . '_title' ) ?></h4>
            </div>
		<?php } ?>
		<?php if ( get_option( NEWSLETTER_CARD_TEXT_DOMAIN . '_description' ) ) { ?>
            <div class="description">
                <p><?= get_option( NEWSLETTER_CARD_TEXT_DOMAIN . '_description' ) ?></p>
            </div>
		<?php } ?>
        <div class="content">
			<?php if ( get_option( NEWSLETTER_CARD_TEXT_DOMAIN . '_shortcode' ) ) { ?>
				<?= do_shortcode( get_option( NEWSLETTER_CARD_TEXT_DOMAIN . '_shortcode' ) ); ?>
			<?php } ?>
        </div>
        <span class="close-button">X</span>
    </div>
</div>
<?php
/**
 * @link walkap.com
 * @package Newsletter_Card
 *
 * @wordpress-plugin
 * Plugin Name:       Newsletter card
 * Plugin URI:        https://github.com/robertocapannelli/newsletter-card
 * Description:       WordPress plugin to show a fancy subscription form on scrolling page
 * Version:           3.0.0
 * Author:            Roberto Capannelli
 * Author URI:        https://walkap.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       newsletter-card
 * Domain Path:       /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Current plugin version
 *
 * Start at version 2.0.0 and use SemVer - https://semver.org
 */

if ( ! defined( 'NEWSLETTER_CARD_VERSION' ) ) {
	define( 'NEWSLETTER_CARD_VERSION', '3.0.0' );
}

if ( ! defined( 'NEWSLETTER_CARD_PLUGIN_FILE' ) ) {
	define( 'NEWSLETTER_CARD_PLUGIN_FILE', __FILE__ );
}

if ( ! defined( 'NEWSLETTER_CARD_TEXT_DOMAIN' ) ) {
	define( 'NEWSLETTER_CARD_TEXT_DOMAIN', 'newsletter_card' );
}

if ( ! defined( 'NEWSLETTER_CARD_NAME' ) ) {
	define( 'NEWSLETTER_CARD_NAME', 'Newsletter Card' );
}

if ( ! defined( 'NEWSLETTER_CARD_SLUG' ) ) {
	define( 'NEWSLETTER_CARD_SLUG', 'newsletter-card' );
}

if ( ! defined( 'NEWSLETTER_CARD_ABSPATH' ) ) {
	define( 'NEWSLETTER_CARD_ABSPATH', dirname( NEWSLETTER_CARD_PLUGIN_FILE ) );
}

if ( ! defined( 'NEWSLETTER_CARD_URL' ) ) {
	define( 'NEWSLETTER_CARD_URL', plugins_url( NEWSLETTER_CARD_SLUG ) );
}

/**
 * The core plugin class
 */

// Include the main Newsletter Card class.
if ( ! class_exists( 'Newsletter_Card' ) ) {
	include_once plugin_dir_path( __FILE__ ) . 'inc/class-newsletter-card.php';
}

/**
 * Begins the execution of the plugin
 *
 * @since 1.0.0
 */
function newsletter_card() {
	Newsletter_Card::instance(NEWSLETTER_CARD_NAME, NEWSLETTER_CARD_SLUG)->run();
}
newsletter_card();
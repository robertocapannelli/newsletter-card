<?php
/**
 * @link walkap.com
 * @since 2.0.0
 * @package Newsletter_Card
 *
 * @wordpress-plugin
 * Plugin Name:       Newsletter card
 * Plugin URI:        https://github.com/robertocapannelli/newsletter-card
 * Description:       WordPress plugin that works with CF7 plugin to show a fancy subscription form on scrolling page
 * Version:           2.0.0
 * Author:            Roberto Capannelli
 * Author URI:        https://walkap.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       newsletter-card
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Current plugin version
 *
 * Start at version 2.0.0 and use SemVer - https://semver.org
 */
define('NEWSLETTER_CARD_VERSION', '2.0.0');

// Define CF7_NC_PLUGIN_FILE
if ( ! defined( 'CF7_NC_PLUGIN_FILE' ) ) {
	define( 'CF7_NC_PLUGIN_FILE', __FILE__ );
}

/**
 * The core plugin class
 */
require plugin_dir_path( __FILE__ ) . 'inc/class-cf7-newsletter-card.php';

/**
 * Begins the execution of the plugin
 *
 * @since 1.0.0
 */
function cf7_newsletter_card(){
	$plugin = CF7_Newsletter_Card::instance();
	$plugin->run();
}

cf7_newsletter_card();

//TODO set cookie also when the form is submitted, but with a grater number of days
//TODO add position left or right
//TODO add style for background and color font
//TODO add custom css field
//TODO these changes could be done by a JSON so we just use ajax one time not storing data as json but call with php and serve to the front end with ajax
//TODO exclude pages?
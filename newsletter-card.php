<?php
/*
Plugin Name: Newsletter Card
Plugin URI: https://github.com/robertocapannelli/newsletter-card
Description: WordPress plugin that works with CF7 plugin to show a fancy subscription form on scrolling page
Version: 2.0.0
Author: Roberto Capannelli
Author URI: https://walkap.com
Text Domain: cf7_nc
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Define CF7_NC_PLUGIN_FILE.
if ( ! defined( 'CF7_NC_PLUGIN_FILE' ) ) {
	define( 'CF7_NC_PLUGIN_FILE', __FILE__ );
}

if ( ! class_exists( 'CF7_Newsletter_Card' ) ) {
	include_once dirname( __FILE__ ) . '/inc/class-cf7-newsletter-card.php';
}

/**
 * Create an instance of the plugin
 *
 * @return CF7_Newsletter_Card|null
 */
function cf7_newsletter_card(){
	return CF7_Newsletter_Card::instance();
}

cf7_newsletter_card();

//TODO set cookie also when the form is submitted, but with a grater number of days
//TODO add position left or right
//TODO add style for background and color font
//TODO add custom css field
//TODO these changes could be done by a JSON so we just use ajax one time not storing data as json but call with php and serve to the front end with ajax
//TODO exclude pages?
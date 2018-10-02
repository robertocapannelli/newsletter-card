<?php
/*
Plugin Name: Newsletter Card
Plugin URI: https://github.com/robertocapannelli/newsletter-card
Description: WordPress plugin that works with CF7 plugin to show a fancy subscription form on scrolling page
Version: 1.0
Author: Roberto Capannelli
Author URI: https://walkap.com
Text Domain: walkap_cf7nc
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'CF7_NC_PLUGIN_NAME', 'CF7 newsletter card' );


define( 'CF7_NC_PLUGIN_PREFIX', 'walkap_cf7nc' );


define( 'CF7_NC_PLUGIN_VERSION', '1.0' );


define( 'CF7_NC_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );


define( 'CF7_NC_PLUGIN_PUBLIC_STYLE', plugins_url( '/public/css/style.css', __FILE__ ) );


define( 'CF7_NC_PLUGIN_PUBLIC_SCRIPT', plugins_url( '/public/js/main.js', __FILE__ ) );


require_once CF7_NC_PLUGIN_DIR . 'init.php';

//TODO set cookie also when the form is submitted, but with a grater number of days
//TODO add position left or right
//TODO add style for background and color font
//TODO add custom css field
//TODO these changes could be done by a JSON so we just use ajax one time not storing data as json but call with php and serve to the front end with ajax
//TODO exclude pages?
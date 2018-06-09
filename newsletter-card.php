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

define( 'PLUGIN_NAME', 'CF7 newsletter card' );

define( 'PLUGIN_PREFIX', 'walkap_cf7nc' );

define( 'PLUGIN_VERSION', '1.0' );

define( 'PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

define( 'PLUGIN_PUBLIC_STYLE', plugins_url( '/public/css/style.css', __FILE__ ) );

define( 'PLUGIN_PUBLIC_SCRIPT', plugins_url( '/public/js/main.js', __FILE__ ) );

require_once PLUGIN_DIR . 'admin/notice.php';
require_once PLUGIN_DIR . 'settings.php';

//TODO set cookie also when the form is submitted, but with a grater number of days
//TODO add position left or right
//TODO add style for background and color font
//TODO add custom css field
//TODO these changes could be done by a JSON so we just use ajax one time not storing data as json but call with php and serve to the front end with ajax
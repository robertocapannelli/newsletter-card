<?php

class CF7_Newsletter_Card {

	protected static $_instance = null;

	/**
	 * CF7_Newsletter_Card constructor.
	 */
	public function __construct() {
		$this->define_constants();
		$this->init();
	}

	/**
	 * Main CF7 Newsletter Card Instance.
	 *
	 * Ensures only one instance of CF7 Newsletter Card Instance is loaded or can be loaded.
	 * @return CF7_Newsletter_Card|null
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Define main constants
	 */
	private function define_constants() {
		$this->define( 'CF7_NC_PLUGIN_NAME', 'CF7 newsletter card' );
		$this->define( 'CF7_NC_PLUGIN_TEXT_DOMAIN', 'cf7_nc' );
		$this->define( 'CF7_NC_PLUGIN_SLUG', 'cf7-newsletter-card' );
		$this->define( 'CF7_NC_PLUGIN_VERSION', '2.0.0' );
		$this->define( 'CF7_NC_ABSPATH', dirname( CF7_NC_PLUGIN_FILE ) );
		$this->define( 'CF7_NC_PLUGIN_URI', plugins_url( 'newsletter-card' ) );
		$this->define( 'CF7_NC_PLUGIN_PUBLIC_STYLE', CF7_NC_PLUGIN_URI . '/assets/css/style.css' );
		$this->define( 'CF7_NC_PLUGIN_PUBLIC_SCRIPT', CF7_NC_PLUGIN_URI . '/assets/js/main.js' );
	}

	/**
	 * Define constant if not already set.
	 *
	 * @param string $name Constant name.
	 * @param string|bool $value Constant value.
	 */
	private function define( $name, $value ) {
		if ( ! defined( $name ) ) {
			define( $name, $value );
		}
	}

	/**
	 * Render the plugin menu and the relative admin page
	 */
	public function render_admin_page(){
		if ( ! class_exists( 'CF7_Nc_Admin_Page' ) ) {
			include_once CF7_NC_ABSPATH . '/admin/class-cf7-nc-admin-page.php';
		}

		$admin_page = new CF7_Nc_Admin_Page();
		//Check if CF7 is installed
		if ( ! is_plugin_active( 'contact-form-7/wp-contact-form-7.php' ) ) {
			return;
		}
		//Add submenu under CF7 menu
		add_submenu_page(
			$admin_page->get_parent_slug(),
			$admin_page->get_page_title(),
			$admin_page->get_menu_title(),
			$admin_page->get_capability(),
			$admin_page->get_plugin_slug(),
			array($admin_page, 'render_page' )
		);

	}

	/**
	 * Render the public content
	 */
	private function render_public(){
		$shortcode = get_option( CF7_NC_PLUGIN_TEXT_DOMAIN . '_shortcode' );
		//needed to invoke is_plugin_active
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		$is_active = is_plugin_active( CF7_NC_ABSPATH . '/newsletter-view.php' );

		//check if a CF7 shortcode is provided and if the plugin is active
		if ( ! ( $shortcode || $is_active ) || isset( $_COOKIE['is_card_hidden'] ) ) {
			return;
		}
		if ( ! class_exists( 'CF7_Nc_Public' ) ) {
			include_once CF7_NC_ABSPATH . '/public/class-cf7-nc-public.php';
		}
		new CF7_Nc_Public();
	}

	/**
	 * Handle the back-end and the front ent based on the role admin or not
	 */
	private function init() {
		if ( is_admin() ) {
			add_action( 'admin_menu', array($this, 'render_admin_page') );
		} else {
			$this->render_public();
		}
	}
}
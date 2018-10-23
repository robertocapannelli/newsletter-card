<?php

if(!class_exists( 'Newsletter_Card' )){
	class Newsletter_Card {

		/**
		 * The loader that's responsible for maintaining and registering all hooks that power
		 * the plugin.
		 *
		 * @since    2.0.0
		 * @access   protected
		 * @var      Newsletter_Card_Loader $loader Maintains and registers all hooks for the plugin.
		 */
		protected $loader;

		/**
		 * The unique identifier of this plugin.
		 *
		 * @since    2.0.0
		 * @access   protected
		 * @var      string $plugin_name The string used to uniquely identify this plugin.
		 */
		protected $plugin_name;


		private $plugin_slug;

		/**
		 * The current version of the plugin.
		 *
		 * @since    2.0.0
		 * @access   protected
		 * @var      string $version The current version of the plugin.
		 */
		protected $version;

		/**
		 * Instance used for singleton
		 *
		 * @var null
		 */
		protected static $_instance = null;


		/**
		 * CF7_Newsletter_Card constructor.
		 *
		 * @since 2.0.0
		 *
		 * @param $plugin_name
		 * @param $plugin_slug
		 */
		public function __construct( $plugin_name, $plugin_slug ) {

			$this->plugin_name = $plugin_name;
			$this->plugin_slug = $plugin_slug;

			$this->load_dependencies();
			$this->define_admin_hooks();
			$this->define_public_hooks();
			$this->init_ajax();

		}

		/**
		 * Main CF7 Newsletter Card Instance.
		 *
		 * Ensures only one instance of CF7 Newsletter Card Instance is loaded or can be loaded.
		 *
		 * @param $plugin_name
		 * @param $plugin_slug
		 *
		 * @since 2.0.0
		 * @return Newsletter_Card|null
		 */
		public static function instance($plugin_name, $plugin_slug) {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self( $plugin_name, $plugin_slug );
			}
			return self::$_instance;
		}

		/**
		 * Load the required dependencies for this plugin.
		 *
		 * Include the following files that make up the plugin:
		 *
		 * - CF7_Nc_Loader. Orchestrates the hooks of the plugin.
		 * - CF7_Nc_Admin_Page. Defines all hooks for the admin area.
		 * - CF7_Nc_Public. Defines all hooks for the public side of the site.
		 *
		 * Create an instance of the loader which will be used to register the hooks
		 * with WordPress.
		 *
		 * @since    2.0.0
		 * @access   private
		 */
		private function load_dependencies() {
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'inc/class-newsletter-card-loader.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-newsletter-card-admin.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-newsletter-card-public.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'inc/class-newsletter-card-ajax.php';
			$this->loader = new Newsletter_Card_Loader();
		}

		/**
		 * Register all of the hooks related to the admin area functionality
		 * of the plugin.
		 *
		 * @since    2.0.0
		 * @access   private
		 */
		private function define_admin_hooks() {
			$plugin_admin = new Newsletter_Card_Admin($this->get_plugin_name() , $this->get_plugin_slug() );
			$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_menus' );
			$this->loader->add_action( 'admin_init', $plugin_admin, 'configure' );
			$this->loader->add_action( 'admin_notices', $plugin_admin, 'notices' );
		}

		/**
		 * Register all of the hooks related to the public-facing functionality
		 * of the plugin.
		 *
		 * @since    2.0.0
		 * @access   private
		 */
		private function define_public_hooks() {
			$plugin_public = new Newsletter_Card_Public( $this->get_plugin_name(), $this->get_version() );
			$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
			$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
			$this->loader->add_action( 'wp_footer', $plugin_public, 'render_content' );
		}

		/**
		 * Register all of the hooks related to the ajax calls
		 *
		 * @since 2.0.0
		 * @access private
		 */
		private function init_ajax() {
			$plugin_ajax = new Newsletter_Card_Ajax( $this->get_plugin_name() );
			$this->loader->add_action( 'wp_enqueue_scripts', $plugin_ajax, 'localize_script' );
			$this->loader->add_action( 'wp_ajax_handle', $plugin_ajax, 'handle' );
			$this->loader->add_action( 'wp_ajax_nopriv_handle', $plugin_ajax, 'handle' );
		}

		/**
		 * Run the loader to execute all of the hooks with WordPress.
		 *
		 * @since    2.0.0
		 */
		public function run() {
			$this->loader->run();
		}

		/**
		 * The name of the plugin used to uniquely identify it within the context of
		 * WordPress and to define internationalization functionality.
		 *
		 * @since     2.0.0
		 * @return    string    The name of the plugin.
		 */
		private function get_plugin_name() {
			return $this->plugin_name;
		}

		/**
		 * Retrieve the version number of the plugin.
		 *
		 * @since     2.0.0
		 * @return    string    The version number of the plugin.
		 */
		private function get_version() {
			return $this->version;
		}

		private function get_plugin_slug(){
			return $this->plugin_slug;
		}

	}
}
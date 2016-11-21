<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://londonclc.org.uk/
 * @since      1.0.0
 *
 * @package    Hitherfield_Computing
 * @subpackage Hitherfield_Computing/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Hitherfield_Computing
 * @subpackage Hitherfield_Computing/includes
 * @author     Joe Halloran <jhalloran@londonclc.org.uk>
 */
class Hitherfield_Computing {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Hitherfield_Computing_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->plugin_name = 'hitherfield-computing';
		$this->version = '1.0.0';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_metabox_hooks();
		$this->define_metabox_save_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Hitherfield_Computing_Loader. Orchestrates the hooks of the plugin.
	 * - Hitherfield_Computing_i18n. Defines internationalization functionality.
	 * - Hitherfield_Computing_Admin. Defines all hooks for the admin area.
	 * - Hitherfield_Computing_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-hitherfield-computing-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-hitherfield-computing-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-hitherfield-computing-admin.php';

		/**
		 * The class responsible for defining all actions relating to creating metaboxes.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-hitherfield-computing-admin-metabox.php';
		
		/**
		 * The class responsible for defining all actions relating to saving metaboxes.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-hitherfield-computing-admin-save-metabox.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-hitherfield-computing-public.php';

		$this->loader = new Hitherfield_Computing_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Hitherfield_Computing_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Hitherfield_Computing_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Hitherfield_Computing_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		// Create Custom Post Type and associated taxonomies for Pupil work
		$this->loader->add_action( 'init', $plugin_admin, 'new_cpt_pupil_work' );

		// Set all pupil work to private by default
		$this->loader->add_filter( 'default_content', $plugin_admin, 'set_default_save_value_private', 10, 2 );
		$this->loader->add_filter( 'wp_insert_post_data', $plugin_admin, 'save_pupil_work_private', 99, 2);

		//Hide admin menu items from contributors
		$this->loader->add_action( 'admin_init', $plugin_admin, 'manage_admin_menu_contributors' );
		//Hide admin menu items from contributors
		$this->loader->add_action( 'wp_before_admin_bar_render', $plugin_admin, 'manage_admin_bar_contributors' );

	}

	/**
	 * Register all of the hooks related to metaboxes
	 *
	 * @since 		1.0.0
	 * @access 		private
	 */
	private function define_metabox_hooks() {
		$plugin_metaboxes = new Hitherfield_Computing_Admin_Metaboxes( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'add_meta_boxes', $plugin_metaboxes, 'hitherfield_computing_add_metaboxes' );

	}

	/**
	 * Register all of the hooks related to saving metaboxes
	 *
	 * @since 		1.0.0
	 * @access 		private
	 */
	private function define_metabox_save_hooks() {
		$plugin_save_metaboxes = new Hitherfield_Computing_Admin_Save_Metaboxes( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'save_post', $plugin_save_metaboxes, 'hitherfield_computing_meta_save' );
 	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Hitherfield_Computing_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Hitherfield_Computing_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}

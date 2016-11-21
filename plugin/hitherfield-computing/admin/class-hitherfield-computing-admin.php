<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://londonclc.org.uk/
 * @since      1.0.0
 *
 * @package    Hitherfield_Computing
 * @subpackage Hitherfield_Computing/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Hitherfield_Computing
 * @subpackage Hitherfield_Computing/admin
 * @author     Joe Halloran <jhalloran@londonclc.org.uk>
 */
class Hitherfield_Computing_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Hitherfield_Computing_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Hitherfield_Computing_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/hitherfield-computing-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Hitherfield_Computing_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Hitherfield_Computing_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/hitherfield-computing-admin.js', array( 'jquery' ), $this->version, false );

		wp_enqueue_script('jquery-ui-autocomplete');

		// Localize the script with new data
		$pupilNames = $terms = get_terms( array(
		    'taxonomy' => 'cat_pupil_name',
		    'fields' => 'names',
		    'childless' => true, //Remove parent categories (i.e. classnames from results)
		    'hide_empty' => false,
		) );
		wp_localize_script( $this->plugin_name, 'pupil_names', $pupilNames );

		
    
	}

	/**
	 * Creates a new custom post type and taxonomy for Hitherfield Computing - pupil's work
	 *
	 * @since 	1.0.0
	 * @access 	public
	 * @uses 	new_cpt_item() and new_taxonomy()
	 */
	public function new_cpt_pupil_work(){
		$cptArgs = array(
				'cap_type' => 'post',
				'cpt_name' => 'pupil_work',
				'plural' => "Pupil's work",
				'single'=> 'Work',
				'desc' => "Pupil's computing work",
				'dashicon' => 'dashicons-welcome-learn-more',
				'slug' => 'pupil-work',
			);

		$this->new_cpt_item( $args = $cptArgs , $optsOveride = array() );

		$this->new_taxonomy( 
			$tax_name = 'cat_pupil_name',
			$single = 'Pupil',
			$plural = 'Pupils',
			$cpt = $cptArgs['cpt_name'] 
			);

		$this->new_taxonomy( 
			$tax_name = 'cat_activity',
			$single = 'Activity',
			$plural = 'Activities',
			$cpt = $cptArgs['cpt_name'] 
			);

		$this->new_taxonomy( 
			$tax_name = 'cat_colours',
			$single = 'Colour',
			$plural = 'Colours',
			$cpt = $cptArgs['cpt_name'] 
			);

	}

	/**
	 * Sets the default save value to private
	 *
	 * @since 	1.0.0
	 * @access 	public
	 * @uses 	
	 */
	public function set_default_save_value_private( $post_content, $post ) {

	    if( $post->post_type )
	        switch( $post->post_type ) {
	            case 'pupil_work':
	                $post->post_status = 'private';
	            break;
	        }
	    return $post_content;
	}

	/**
	 * Overrides save settings to private for all pupil work
	 *
	 * @since 	1.0.0
	 * @access 	public
	 * @uses 	
	 */
	public function save_pupil_work_private( $data, $postarr ) {

	    if( $data['post_type'] )
	        switch( $data['post_type'] ) {
	            case 'pupil_work':
		            if ( $data['post_status'] == 'publish' ) {
	            		$data['post_status'] = 'private';
		                $status = $data['post_status'];
		                $name = $data['post_name'];
		                trigger_error("saving {$name} with status {$status}", E_USER_WARNING);
	            	}	                
	            break;
	        }   
	    return $data;
	}

	/**
	 * Hide admin pages for contributors
	 *
	 * @since 	1.0.0
	 * @access 	public
	 * @uses 	
	 */
	public function manage_admin_menu_contributors() {
	 
	    global $user_ID;
	 
	    if ( !current_user_can( 'moderate_comments' ) ) {
			remove_menu_page( 'edit-comments.php' );
				remove_menu_page( 'profile.php' );
				remove_submenu_page( 'users.php', 'profile.php' );
		 }
	}

	/**
	 * Hide edit wordpress admin bar contributors
	 *
	 * @since 	1.0.0
	 * @access 	public
	 * @uses 	
	 */
	public function manage_admin_bar_contributors() {
	 
	    global $user_ID;
	 
	    if ( !current_user_can( 'moderate_comments' ) ) {

			global $wp_admin_bar;
   			$wp_admin_bar->remove_menu('my-account');
   			
		 }
	}

	/**
	 * Creates a new custom post type
	 *
	 * @since 	1.0.0
	 * @access 	protected
	 * @uses 	register_post_type()
	 */
	protected function new_cpt_item( array $args, array $optsOveride) {

		$defaults = array(
			'cap_type' => 'post',
			'cpt_name' => 'custom_post',
			'plural' => 'custom posts',
			'single' => 'custom post',
			'desc' => 'Description of post',
			'dashicon' => 'dashicons-welcome-learn-more',
			'slug' =>'custom-post',
		);

		$inputs = array_merge($defaults, $args);


		$single = $inputs['single'];
		$plural = $inputs['plural'];
		$cpt_name = $inputs['cpt_name'];


		$opts['can_export']								= TRUE;
		$opts['capability_type']						= $inputs['cap_type'];
		$opts['description']							= esc_html( $inputs['desc'], 'ldnclc-plugin' );
		$opts['exclude_from_search']					= FALSE;
		$opts['has_archive']							= TRUE;
		$opts['hierarchical']							= FALSE;
		//$opts['map_meta_cap']							= TRUE;
		$opts['menu_icon']								= $inputs['dashicon'];
		$opts['menu_position']							= 5;
		$opts['public']									= TRUE;
		$opts['publicly_querable']						= TRUE;
		$opts['query_var']								= TRUE;
		//$opts['register_meta_box_cb']					= '';
		//$opts['rewrite']								= FALSE;
		$opts['show_in_admin_bar']						= TRUE;
		$opts['show_in_menu']							= TRUE;
		$opts['show_in_nav_menu']						= TRUE;
		$opts['show_ui']								= TRUE;
		$opts['supports']								= array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', 'page-attributes', 'menu_order' );
		// $opts['taxonomies']								= array();
		$opts['capabilities']['delete_others_posts']	= "delete_others_{$cpt_name}s";
		$opts['capabilities']['delete_post']			= "delete_{$cpt_name}";
		$opts['capabilities']['delete_posts']			= "delete_{$cpt_name}s";
		$opts['capabilities']['delete_private_posts']	= "delete_private_{$cpt_name}s";
		$opts['capabilities']['delete_published_posts']	= "delete_published_{$cpt_name}s";
		$opts['capabilities']['edit_others_posts']		= "edit_others_{$cpt_name}s";
		$opts['capabilities']['edit_post']				= "edit_{$cpt_name}";
		$opts['capabilities']['edit_posts']				= "edit_{$cpt_name}s";
		$opts['capabilities']['edit_private_posts']		= "edit_private_{$cpt_name}s";
		$opts['capabilities']['edit_published_posts']	= "edit_published_{$cpt_name}s";
		$opts['capabilities']['publish_posts']			= "publish_{$cpt_name}s";
		$opts['capabilities']['read_post']				= "read_{$cpt_name}";
		$opts['capabilities']['read_private_posts']		= "read_private_{$cpt_name}s";
		$opts['labels']['add_new']						= esc_html__( "Add New {$single}", 'ldnclc-plugin' );
		$opts['labels']['add_new_item']					= esc_html__( "Add New {$single}", 'ldnclc-plugin' );
		$opts['labels']['all_items']					= esc_html__( $plural, 'ldnclc-plugin' );
		$opts['labels']['edit_item']					= esc_html__( "Edit {$single}" , 'ldnclc-plugin' );
		$opts['labels']['menu_name']					= esc_html__( $plural, 'ldnclc-plugin' );
		$opts['labels']['name']							= esc_html__( $plural, 'ldnclc-plugin' );
		$opts['labels']['name_admin_bar']				= esc_html__( $single, 'ldnclc-plugin' );
		$opts['labels']['new_item']						= esc_html__( "New {$single}", 'ldnclc-plugin' );
		$opts['labels']['not_found']					= esc_html__( "No {$plural} Found", 'ldnclc-plugin' );
		$opts['labels']['not_found_in_trash']			= esc_html__( "No {$plural} Found in Trash", 'ldnclc-plugin' );
		$opts['labels']['parent_item_colon']			= esc_html__( "Parent {$plural} :", 'ldnclc-plugin' );
		$opts['labels']['search_items']					= esc_html__( "Search {$plural}", 'ldnclc-plugin' );
		$opts['labels']['singular_name']				= esc_html__( $single, 'ldnclc-plugin' );
		$opts['labels']['view_item']					= esc_html__( "View {$single}", 'ldnclc-plugin' );
		$opts['rewrite']['ep_mask']						= EP_PERMALINK;
		$opts['rewrite']['feeds']						= FALSE;
		$opts['rewrite']['pages']						= TRUE;
		$opts['rewrite']['slug']						= esc_html__( $inputs['slug'], 'ldnclc-plugin' );
		$opts['rewrite']['with_front']					= FALSE;

		$opts = array_merge($opts, $optsOveride);

		register_post_type( strtolower( $cpt_name ), $opts );

		
	}

	/**
	 * Create a custom taxonomy
	 *
	 * @since 	1.0.0
	 * @access 	protected
	 * @uses register_taxonomy()
	 */
	protected function new_taxonomy( 
			$tax_name = 'custom_category', 
			$single = 'Category', 
			$plural = 'Categories',
			$cpt = 'post' ) {

		$opts['hierarchical']							= TRUE;
		//$opts['meta_box_cb'] 							= '';
		$opts['public']									= TRUE;
		$opts['query_var']								= $tax_name;
		$opts['show_admin_column'] 						= FALSE;
		$opts['show_in_nav_menus']						= TRUE;
		$opts['show_tag_cloud'] 						= TRUE;
		$opts['show_ui']								= TRUE;
		$opts['sort'] 									= '';
		//$opts['update_count_callback'] 					= '';
		$opts['capabilities']['assign_terms'] 			= "assign_{$tax_name}";
		$opts['capabilities']['delete_terms'] 			= "manage_{$tax_name}";
		$opts['capabilities']['edit_terms'] 			= "manage_{$tax_name}";
		$opts['capabilities']['manage_terms'] 			= "manage_{$tax_name}";
		$opts['labels']['add_new_item'] 				= esc_html__( "Add New {$single}", 'ldnclc-plugin' );
		$opts['labels']['add_or_remove_items'] 			= esc_html__( "Add or remove {$plural}", 'ldnclc-plugin' );
		$opts['labels']['all_items'] 					= esc_html__( $plural, 'ldnclc-plugin' );
		$opts['labels']['choose_from_most_used'] 		= esc_html__( "Choose from most used {$plural}", 'ldnclc-plugin' );
		$opts['labels']['edit_item'] 					= esc_html__( "Edit {$single}" , 'ldnclc-plugin');
		$opts['labels']['menu_name'] 					= esc_html__( $plural, 'ldnclc-plugin' );
		$opts['labels']['name'] 						= esc_html__( $plural, 'ldnclc-plugin' );
		$opts['labels']['new_item_name'] 				= esc_html__( "New {$single} Name", 'ldnclc-plugin' );
		$opts['labels']['not_found'] 					= esc_html__( "No {$plural} Found", 'ldnclc-plugin' );
		$opts['labels']['parent_item'] 					= esc_html__( "Parent {$single}", 'ldnclc-plugin' );
		$opts['labels']['parent_item_colon'] 			= esc_html__( "Parent {$single}:", 'ldnclc-plugin' );
		$opts['labels']['popular_items'] 				= esc_html__( "Popular {$plural}", 'ldnclc-plugin' );
		$opts['labels']['search_items'] 				= esc_html__( "Search {$plural}", 'ldnclc-plugin' );
		$opts['labels']['separate_items_with_commas'] 	= esc_html__( "Separate {$plural} with commas", 'ldnclc-plugin' );
		$opts['labels']['singular_name'] 				= esc_html__( $single, 'ldnclc-plugin' );
		$opts['labels']['update_item'] 					= esc_html__( "Update {$single}", 'ldnclc-plugin' );
		$opts['labels']['view_item'] 					= esc_html__( "View {$single}", 'ldnclc-plugin' );
		$opts['rewrite']['ep_mask']						= EP_NONE;
		$opts['rewrite']['hierarchical']				= FALSE;
		$opts['rewrite']['slug']						= esc_html__( strtolower( $tax_name ), 'ldnclc-plugin' );
		$opts['rewrite']['with_front']					= FALSE;
		//$opts = apply_filters( '', $opts );

		register_taxonomy( $tax_name, $cpt , $opts );
	}

}

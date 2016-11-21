<?php
/**
 * The metabox-specific functionality of the plugin.
 *
 * @link 		http://example.com
 * @since 		1.0.0
 *
 * @package 	Ldnclc_Plugin
 * @subpackage 	Ldnclc_Plugin/admin
 */

class Hitherfield_Computing_Admin_Metaboxes 
{

	/**
	 * The post meta data
	 *
	 * @since 		1.0.0
	 * @access 		private
	 * @var 		string 			$meta    			The post meta data.
	 */
	private $meta;
	/**
	 * The ID of this plugin.
	 *
	 * @since 		1.0.0
	 * @access 		private
	 * @var 		string 			$plugin_name 		The ID of this plugin.
	 */
	private $plugin_name;
	/**
	 * The version of this plugin.
	 *
	 * @since 		1.0.0
	 * @access 		private
	 * @var 		string 			$version 			The current version of this plugin.
	 */
	private $version;
	/**
	 * Initialize the class and set its properties.
	 *
	 * @since 		1.0.0
	 * @param 		string 			$Now_Hiring 		The name of this plugin.
	 * @param 		string 			$version 			The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}
	/**
	 * Registers metaboxes with WordPress
	 *
	 * @since 	1.0.0
	 * @access 	public
	 */
	public function hitherfield_computing_add_metaboxes() {
		// add_meta_box( $id, $title, $callback, $screen, $context, $priority, $callback_args );
		
		add_meta_box(
	        'pupil-names-autocomplete', //id
	        __( 'Pupil Names', 'ldnclc-plugin' ), //title
	        array( $this, 'hitherfield_computing_pupil_names' ), //callback
	        'pupil_work', //post_type
	        'normal', //context
	        'low', // priority
	        array() // callback args
	    );
	} // add_metaboxes()

	/**
	 * Generates metabox content for pupil workshop key info
	 *
	 * @since 	1.0.0
	 * @access 	public
	 * @return 	void
	 */
	public function hitherfield_computing_pupil_names( $post ) {
	    $pupilNames = $terms = get_terms( array(
		    'taxonomy' => 'cat_pupil_name',
		    'fields' => 'names',
		    'childless' => true, //Remove parent categories (i.e. classnames from results)
		    'hide_empty' => false,
		) );
	    include_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/hitherfield-computing-admin-pupil-name-metabox.php';
	}



}
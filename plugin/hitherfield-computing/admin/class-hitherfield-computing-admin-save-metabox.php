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

class Hitherfield_Computing_Admin_Save_Metaboxes
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
	 * Saves the data from the metabox. Triggered by 'save_post'.
	 *
	 * @since 	1.0.0
	 * @access 	public
	 * @return 	void
	 */
	public function hitherfield_computing_meta_save( $post_id ) {
 
	    // Checks save status
	    $is_autosave = wp_is_post_autosave( $post_id );
	    $is_revision = wp_is_post_revision( $post_id );
	    $is_valid_nonce = ( isset( $_POST[ 'prfx_nonce' ] ) && wp_verify_nonce( $_POST[ 'prfx_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
	 
	    // Exits script depending on save status
	    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
	        return;
	    }

	    $this->hitherfield_computing_save_pupil_names( $post_id ) ;
			
	}

	/**
	 * Saves the data from the pupil workshop key info metabox. Triggered by 'ldnclc_plugin_meta_save'.
	 *
	 * @since 	1.0.0
	 * @access 	protected
	 * @return 	void
	 */
	protected function hitherfield_computing_save_pupil_names( $post_id ) {
		$acceptedValues = $terms = get_terms( array(
		    'taxonomy' => 'cat_pupil_name',
		    'fields' => 'names',
		    'childless' => true, //Remove parent categories (i.e. classnames from results)
		    'hide_empty' => false,
		) );	

		if ( isset( $_POST[ "pupil-name" ] ) ) {
			$value = $_POST[ "pupil-name" ];
			if (in_array($value, $acceptedValues)) {
				$cat_id = get_cat_ID( $value );
				wp_set_post_categories( $post_id, $cat_id, false );
				update_post_meta($post_id, 'pupil-name', $value);
			}
		}
	}

	

}
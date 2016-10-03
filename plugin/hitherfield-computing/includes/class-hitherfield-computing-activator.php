<?php

/**
 * Fired during plugin activation
 *
 * @link       http://londonclc.org.uk/
 * @since      1.0.0
 *
 * @package    Hitherfield_Computing
 * @subpackage Hitherfield_Computing/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Hitherfield_Computing
 * @subpackage Hitherfield_Computing/includes
 * @author     Joe Halloran <jhalloran@londonclc.org.uk>
 */
class Hitherfield_Computing_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		/**
		 * Adjust capabilities of pupils (Contributors) when managing categories
		 *
		 * You should call the function when your plugin is activated.
		 *
		 * @uses WP_Role::remove_cap()
		 */

		// Set capabilities for contributor
		$role = get_role( 'contributor' );
		$role->add_cap( 'assign_cat_pupil_name');
		$role->add_cap( 'assign_cat_activity' );
		$role->add_cap( 'assign_cat_colours' );
		$role->remove_cap( 'manage_cat_pupil_name' );
		$role->remove_cap( 'manage_cat_activity' );
		$role->remove_cap( 'manage_cat_colours' );
		$role->remove_cap( 'edit_posts');
		$role->remove_cap( 'delete_posts');
		// Add option to upload files.
		$role->add_cap( 'upload_files');

		// Set capabilities for editor
		$role = get_role( 'editor' );
		$role->add_cap( "delete_others_pupil_works" );
		$role->add_cap( "delete_pupil_work" );
		$role->add_cap( "delete_pupil_works" );
		$role->add_cap( "delete_private_pupil_works" );
		$role->add_cap( "delete_published_pupil_works" );
		$role->add_cap( "edit_others_pupil_works" );
		$role->add_cap( 'edit_pupil_work' );
		$role->add_cap( 'edit_pupil_works' );
		$role->add_cap( 'edit_private_pupil_works' );
		$role->add_cap( 'edit_published_pupil_works' );
		$role->add_cap( 'publish_pupil_work' );
		$role->add_cap( "read_pupil_work" );
		$role->add_cap( "read_private_pupil_works" );
		// Pupil work taxonomies
		$role->add_cap( 'assign_cat_pupil_name');
		$role->add_cap( 'assign_cat_activity' );
		$role->add_cap( 'assign_cat_colours' );
		$role->add_cap( 'manage_cat_pupil_name' );
		$role->add_cap( 'manage_cat_activity' );
		$role->add_cap( 'manage_cat_colours' );

		// Set capabilities for administrator
		$role = get_role( 'administrator' );
		// Pupil work CPT
		$role->add_cap( "delete_others_pupil_works" );
		$role->add_cap( "delete_pupil_work" );
		$role->add_cap( "delete_pupil_works" );
		$role->add_cap( "delete_private_pupil_works" );
		$role->add_cap( "delete_published_pupil_works" );
		$role->add_cap( "edit_others_pupil_works" );
		$role->add_cap( 'edit_pupil_work' );
		$role->add_cap( 'edit_pupil_works' );
		$role->add_cap( 'edit_private_pupil_works' );
		$role->add_cap( 'edit_published_pupil_works' );
		$role->add_cap( 'publish_pupil_work' );
		$role->add_cap( "read_pupil_work" );
		$role->add_cap( "read_private_pupil_works" );
		// Pupil work taxonomies
		$role->add_cap( 'assign_cat_pupil_name');
		$role->add_cap( 'assign_cat_activity' );
		$role->add_cap( 'assign_cat_colours' );
		$role->add_cap( 'manage_cat_pupil_name' );
		$role->add_cap( 'manage_cat_activity' );
		$role->add_cap( 'manage_cat_colours' );
	}

}

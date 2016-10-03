<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://londonclc.org.uk/
 * @since      1.0.0
 *
 * @package    Hitherfield_Computing
 * @subpackage Hitherfield_Computing/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Hitherfield_Computing
 * @subpackage Hitherfield_Computing/includes
 * @author     Joe Halloran <jhalloran@londonclc.org.uk>
 */
class Hitherfield_Computing_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'hitherfield-computing',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}

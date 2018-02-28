<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       js-display-schedule
 * @since      1.0.0
 *
 * @package    Js_Display_Schedule
 * @subpackage Js_Display_Schedule/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Js_Display_Schedule
 * @subpackage Js_Display_Schedule/includes
 * @author     Andrei Hetsevich <a.hetsevich@yahoo.com>
 */
class Js_Display_Schedule_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'js-display-schedule',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}

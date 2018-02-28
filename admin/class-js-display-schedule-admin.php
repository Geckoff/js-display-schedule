<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       js-display-schedule
 * @since      1.0.0
 *
 * @package    Js_Display_Schedule
 * @subpackage Js_Display_Schedule/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Js_Display_Schedule
 * @subpackage Js_Display_Schedule/admin
 * @author     Andrei Hetsevich <a.hetsevich@yahoo.com>
 */


// Carbon fields plugin
use Carbon_Fields\Container;
use Carbon_Fields\Field;

class Js_Display_Schedule_Admin {

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
		
		// Carbon fields plugin
		require_once( __DIR__.'/../vendor/autoload.php' );
        \Carbon_Fields\Carbon_Fields::boot();

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
		 * defined in Js_Display_Schedule_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Js_Display_Schedule_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/js-display-schedule-admin.css', array(), $this->version, 'all' );

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
		 * defined in Js_Display_Schedule_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Js_Display_Schedule_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/js-display-schedule-admin.js', array( 'jquery' ), $this->version, false );

	}

	//new post type
	//add_action('init', 'arc_our_team');
	public function jsdisplay_post_type() {
	    register_post_type('jsdisplay', array(
	        'public' => true,
	        'supports' => array('title'),
	        'menu_position' => 57,
	        'menu_icon' => 'dashicons-clock',
	        'labels' => array(
	            'name' => 'JS Display IDs',
	            'all_items' => 'All JS Display IDs',
	            'add_new' => 'New ID',
	            'add_new_item' => 'Add New ID',
	        ),
	    ));
	}

	// new page
	public function display_jsids_page() {
		add_menu_page(
			'JS Display Identifyers',
			'JS Display IDs',
			'manage_options',
			'js-display-ids',
			array($this, 'jsids_page'),
			'',
			'3.0'
		);
	}

	public function jsids_page() {
		include plugin_dir_path( __FILE__ ).'partials/js-display-schedule-admin-display.php';
	}

	public function crb_attach_theme_options() {
		$labels = array(
			'plural_name' => 'Intervals',
			'singular_name' => 'Interval',
		);

		Container::make( 'post_meta', __( 'Display Schedule Type', 'crb' ) )
			->where( 'post_type', '=', 'jsdisplay' )
			->add_fields( array(
				Field::make( 'radio', 'jsd_type', '' )
					->add_options( array(
						'jsd_rs_sched' => 'Recurring Schedule',
						'jsd_us_sched' => 'Uneven Schedule',						
					) )
			) );

		Container::make( 'post_meta', __( 'Display Schedule Type', 'crb' ) )
			->where( 'post_type', '=', 'jsdisplay' )
			->add_fields( array(
				Field::make( 'select', 'jsd_rs_glob', 'Schedule Interval' )
					->add_options( array(
						'jsd_rs_every_other_day' => 'Every Other Day',
						'jsd_rs_every_other_week' => 'Every Other Week',
					) ),
				Field::make( 'radio', 'jsd_rs_type', 'Time Settings' )
					->add_options( array(
						'whole_day' => 'Whole Day',
						'custom_hours' => 'Custom Hours',						
					) )
			) );

		Container::make( 'post_meta', __( 'Uneven Display Schedule', 'crb' ) )
			->where( 'post_type', '=', 'jsdisplay' )
			->add_fields( array(
				Field::make( 'complex', 'jsd_us', 'Display Intervals' )
					->set_min(1)
					->setup_labels($labels)
					->set_layout('grid')
					->add_fields( array(
						Field::make( 'date_time', 'jsd_us_time_start', 'Display Interval Start')->set_required( true ),
						Field::make( 'date_time', 'jsd_us_time_end', 'Display Interval End' )->set_required( true ),
					) ),
			) );
    }
}

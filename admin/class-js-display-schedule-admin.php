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

	// Add custom fields for the plugin
	public function crb_attach_theme_options() {
		$labels = array(
			'plural_name' => 'Intervals',
			'singular_name' => 'Interval',
		);

		Container::make( 'post_meta', __( 'General Info', 'crb' ) )
			->where( 'post_type', '=', 'jsdisplay' )
			->add_fields( array(
				Field::make( 'text', 'jsdid', 'ID' )
					->set_attribute( 'pattern', '[a-z]+[a-z0-9-_]*[a-z0-9]+' )
					->set_required( true )
					->set_help_text('May contain only lowercase letters, numbers, "-" and "_" characters and should start with a letter and end with a letter or a number.'),
				Field::make( 'select', 'jsd_css_display', 'CSS display type' )
					->add_options( array(
						'block' => 'Block',
						'inline' => 'Inline',
						'inline-block' => 'Inline Block',
						'flex' => 'Flex',
					) )
					->set_help_text('Used for JS display functionality.')
			) );

		Container::make( 'post_meta', __( 'Display Schedule Type', 'crb' ) )
			->where( 'post_type', '=', 'jsdisplay' )
			->add_fields( array(
				Field::make( 'radio', 'jsd_type', '' )
					->add_options( array(
						'jsd_rs_sched' => 'Recurring Schedule',
						'jsd_us_sched' => 'Uneven Schedule',						
					) )
			) );



		Container::make( 'post_meta', __( 'Recurring Display Schedule', 'crb' ) )
			->where( 'post_type', '=', 'jsdisplay' )
			->add_fields( array(
				Field::make( 'select', 'jsd_rs_glob', 'Schedule Interval' )
					->add_options( array(
						'jsd_rs_every_day' => 'Every Day',
						'jsd_rs_every_other_day' => 'Every Other Day',
						'jsd_rs_every_other_week' => 'Every Other Week',
						'jsd_rs_every_even_date' => 'Every Even Date',
						'jsd_rs_every_odd_date' => 'Every Odd Date',
						'jsd_rs_every_monday' => 'Every Monday',
						'jsd_rs_every_tuesday' => 'Every Tuesday',
						'jsd_rs_every_wednesday' => 'Every Wednesday',
						'jsd_rs_every_thursday' => 'Every Thursday',
						'jsd_rs_every_friday' => 'Every Friday',
						'jsd_rs_every_saturday' => 'Every Saturday',
						'jsd_rs_every_sunday' => 'Every Sunday',
						'jsd_rs_every_weekend' => 'Every Weekend',
					) ),
				Field::make( 'date', 'jsd_reccuring_start_date', 'Start Date' )
					->set_help_text('If date is not picked, current date will be used.'),
				Field::make( 'date', 'jsd_reccuring_end_date', 'Start Date' )
					->set_help_text('If there is no end date, leave the field blank.'),
				Field::make( 'radio', 'jsd_rs_type', 'Time Settings' )
					->add_options( array(
						'whole_day' => 'Whole Day',
						'custom_hours' => 'Custom Hours',						
					) ),
				Field::make( 'time', 'jsd_rs_hours_start', 'Start Time' )
					->set_required( true )
					->set_default_value('12:00 AM'),
				Field::make( 'time', 'jsd_rs_hours_finish', 'Finish Time' )
					->set_required( true )
					->set_default_value('11:59 PM'),
			) );

		Container::make( 'post_meta', __( 'Uneven Display Schedule', 'crb' ) )
			->where( 'post_type', '=', 'jsdisplay' )
			->add_fields( array(
				Field::make( 'complex', 'jsd_us', 'Display Intervals' )
					->setup_labels($labels)
					->set_layout('grid')
					->add_fields( array(
						Field::make( 'date_time', 'jsd_us_time_start', 'Display Interval Start')
							->set_required( true ),
						Field::make( 'date_time', 'jsd_us_time_end', 'Display Interval End' )
							->set_required( true ),
					) ),
			) );

		Container::make( 'post_meta', __( 'Description', 'crb' ) )
			->where( 'post_type', '=', 'jsdisplay' )
			->add_fields( array(
				Field::make( 'textarea', 'jsd_description', '' )
    				->set_rows(4)
			) );
	}
	
	// building schedule array and write it into json format
	public function generateJsSchedule($post_ID, $post) {
		if (get_post_type($post_ID) == 'jsdisplay') {
			$the_query = new WP_Query(['post_type' => 'jsdisplay']);
			$jsd_arr = [];
			if ( $the_query->have_posts() ) {
				while ( $the_query->have_posts() ) {
					$the_query->the_post();
					// save countdown date

					$jsd_current = [];
					$post_id = get_the_ID();
					//$jsd_id = carbon_get_post_meta($post_id, 'jsdid');
					$jsd_id = get_post_meta($post_id, "_jsdid")[0];
					//$jsd_css_display = carbon_get_post_meta($post_id, 'jsd_css_display');
					$jsd_css_display = get_post_meta($post_id, "_jsd_css_display")[0];
					$jsd_sched_type = carbon_get_post_meta($post_id, 'jsd_type');

					// uneven schedule
					$intervals = carbon_get_post_meta($post_id, 'jsd_us');
					if ($intervals) {
						$jsd_uneve_intervals = [];
						foreach ( $intervals as $interval ) {
							$start_interval = $interval["jsd_us_time_start"];
							$end_interval =  $interval["jsd_us_time_end"];
							$jsd_uneve_intervals[] = ['us_time_start' => $start_interval, 'us_time_end' => $end_interval];
						}
					} else {
						$jsd_uneve_intervals = false;
					}

					//recurring schedule
					$jsd_recurring_schedule_day = carbon_get_post_meta($post_id, 'jsd_rs_glob');
					$jsd_recurring_schedule_start_date = carbon_get_post_meta($post_id, 'jsd_reccuring_start_date');
					// using current date as a start date for reccuring schedule if 
					if ($jsd_recurring_schedule_start_date == ""){
						update_post_meta( $post_id, 'jsd_reccuring_start_date', date('Y-m-d'));
						$jsd_recurring_schedule_start_date = date('Y-m-d');
					}
					$jsd_recurring_schedule_end_date = carbon_get_post_meta($post_id, 'jsd_reccuring_end_date');
					$jsd_recurring_time_interval_type = carbon_get_post_meta($post_id, 'jsd_rs_type');
					$jsd_recurring_time_interval_start = $this->timeToSeconds(carbon_get_post_meta($post_id, 'jsd_rs_hours_start'));
					$jsd_recurring_time_interval_end = $this->timeToSeconds(carbon_get_post_meta($post_id, 'jsd_rs_hours_finish'));

					$jsd_current['id'] = $jsd_id; 
					$jsd_current['css_display'] = $jsd_css_display; 
					$jsd_current['sched_type'] = $jsd_sched_type; 
					$jsd_current['uneve_intervals'] = $jsd_uneve_intervals; 
					$jsd_current['recurring_schedule_day'] = $jsd_recurring_schedule_day; 
					$jsd_current['recurring_schedule_start_date'] = $jsd_recurring_schedule_start_date; 
					$jsd_current['recurring_schedule_end_date'] = $jsd_recurring_schedule_end_date; 
					$jsd_current['recurring_time_interval_type'] = $jsd_recurring_time_interval_type; 
					$jsd_current['recurring_time_interval_start'] = $jsd_recurring_time_interval_start; 
					$jsd_current['recurring_time_interval_end'] = $jsd_recurring_time_interval_end; 
					$jsd_arr[$jsd_id] = $jsd_current;
				}
			} 		
			
			$jsd_json = json_encode($jsd_arr);		
			//write json to file
			$jsFileUrl = plugin_dir_path( __FILE__ )."../public/js/schedule.js";
			$fp = fopen($jsFileUrl, 'w+');
			fwrite($fp, "var jsdSchedules = ".$jsd_json);
			fclose($fp);
		}
	}

	private function timeToSeconds($time) {
		sscanf($time, "%d:%d:%d", $hours, $minutes, $seconds);
		return $hours * 3600 + $minutes * 60 + $seconds;		
	}
}

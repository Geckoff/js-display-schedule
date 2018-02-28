<?php
use Carbon_Fields\Container;
use Carbon_Fields\Field;

Container::make( 'post_meta', __( 'Page Settings' ) )
	->where( 'post_type', '=', 'page' )
	->add_fields( array(
		Field::make( 'text', 'page_subtitle', __( 'Subtitle' ) )
			->set_width( 50 )
			->set_required( true )
			->set_help_text( __( 'Will be displayed below the main title.' ) ),
		Field::make( 'select', 'page_layout', __( 'Layout' ) )
			->set_width( 50 )
			->set_options( array(
				'left-sidebar' => __( 'Left Sidebar' ),
				'right-sidebar' => __( 'Right Sidebar' ),
			) )
			->set_default_value( 'right-sidebar' ),
	) );
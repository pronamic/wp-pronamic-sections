<?php

class Pronamic_WP_Sections_Settings {
	
	public function __construct() {
		add_action( 'admin_init', array( $this, 'register_settings' ) );
	}
	
	public function register_settings() {
		add_settings_section( 'pronamic-sections-general', __( 'General Settings', 'pronamic-sections-domain' ), '__return_false', 'pronamic-sections' );
		
		
		add_settings_field(
			'pronamic-sections-post-types',
			__( 'Post Types', 'pronamic-sections-domains' ),
			array( $this, 'field_post_type_checkboxes' ),
			'pronamic-sections',
			'pronamic-sections-general',
			array( 
				'label_for'   => 'pronamic-sections-post-types',
				'description' => __( 'Choose the post types you want to show the Pronamic Sections boxes on in the Admin area', 'pronamic-sections-domain' )
			)
		);
		
		register_setting( 'pronamic-sections-general', 'pronamic-sections-post-types' );
		
		/**
		 * Look Settings
		 */
		add_settings_section(
			'pronamic-sections-look',
			__( 'Look and Feel', 'pronamic-sections-domain' ),
			'__return_false',
			'pronamic-sections'
		);
		
		add_settings_field(
			'pronamic-sections-look-activate-shortcode',
			__( 'Activate Shortcode?', 'pronamic-sections-domain' ),
			array( $this, 'field_checkbox' ),
			'pronamic-sections',
			'pronamic-sections-look',
			array(
				'label_for' => 'pronamic-sections-look-activate-shortcode'
			)
		);
		
		add_settings_field(
			'pronamic-sections-look-shortcode-display',
			__( 'Shortcode Template', 'pronamic-sections-domain' ),
			array( $this, 'field_display_select' ),
			'pronamic-sections',
			'pronamic-sections-look',
			array(
				'label_for' => 'pronamic-sections-look-shortcode-display',
				'description' => sprintf( __( 'Specify a display output of the shortcode.. You can define your own also. See <a target="_blank" href="%s">here</a>', 'pronamic-sections-domain' ), '' )
			)
		);
		
		register_setting( 'pronamic-sections-look', 'pronamic-sections-look-activate-shortcode' );
		register_setting( 'pronamic-sections-look', 'pronamic-sections-look-shortcode-display' );
	}
	
	public function field_post_type_checkboxes( $args ) {
		// get all post types
		$post_types = get_post_types();
		
		$selected_post_types = get_option( $args['label_for'], array() );
		
		if ( ! is_array( $selected_post_types ) )
			$selected_post_types = array();
		
		$ignored_post_types = array(
			'revision',
			'nav_menu_item',
			'pronamic_section',
			'deprecated_log',
			'pronamic_payment',
			'pronamic_pay_gf',
			'pronamic_gateway',
		);
		
		echo "<span class='howto'>" . $args['description'] . "</span><hr/>";
		
		foreach ( $post_types as $post_type ) {
			if ( in_array( $post_type, $ignored_post_types ) ) {
				continue;
			}
			
			printf( 
				'<input type="checkbox" id="%1$s" name="%1$s" value="1" %2$s /><label for="%1$s">%3$s</label><br/>',
				$args['label_for'] . '[' . $post_type . ']',
				checked( array_key_exists($post_type, $selected_post_types ), true, false ),
				ucwords( str_replace( array( '_', '-' ), ' ', $post_type ) )
			);
		}
	}
	
	public function field_checkbox( $args ) {
		if ( isset( $args['description'] ) ) {
			echo "<span class='howto'>" . $args['description'] . "</span><hr/>";
		}
		
		$value = get_option( $args['label_for'], 0 );
		
		printf(
			'<input type="checkbox" id="%1$s" name="%1$s" value="1" %2$s />',
			$args['label_for'],
			checked( $value, 1, false )
		);
	}
	
	public function field_display_select( $args ) {
		if ( isset( $args['description'] ) ) {
			echo "<span class='howto'>" . $args['description'] . "</span><hr/>";
		}
		
		// Get all registered display methods
		$registered_displays = Pronamic_WP_Sections_DisplayManager::all();
		
		$print_format = "<option value='%s'>%s</option>";
		
		echo "<select name='{$args['label_for']}'>";
		foreach ( $registered_displays as $registered_display ) {
			printf( $print_format, $registered_display->get_ID(), $registered_display->get_name() );
		}
		echo "</select>";
	}
	
}
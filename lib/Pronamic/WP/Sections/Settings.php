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
		
		register_setting( 'pronamic_sections_settings_general', 'pronamic-sections-post-types' );
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
	
}
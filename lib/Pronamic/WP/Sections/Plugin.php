<?php

class Pronamic_WP_Sections_Plugin {
	
	public function __construct() {
		// Load the post type and text domain
		add_action( 'init', array( $this, 'init' ) );
		
		// Register and possibly enqueue the required assets.
		add_action( 'wp_enqueue_scripts', array( $this, 'assets' ) );
	}
	
	/**
	 * Register the text domain 'pronamic-sections-domain' and prepares the
	 * hidden section post type.
	 * 
	 * @access public
	 * @return void
	 */
	public function init() {
		load_plugin_textdomain( 'pronamic-sections-domain', false, dirname( plugin_basename( PRONAMIC_SECTIONS_FILE ) ) );

		// Register the new internal post type
		register_post_type( 'pronamic_section', array(
			'labels' => array(
				'name' => _x( 'Sections', 'Plural Name for Pronamic Section Post', 'pronamic-sections-domain' ),
				'singular_name' => _x( 'Section', 'Singular Name for the Pronamic Section Post', 'pronamic-sections-domain' )
			),
			'public' => false,
			'publicly_querable' => false,
			'show_ui' => false,
			'show_in_menu' => false,
			'query_var' => false,
			'rewrite' => null,
			'capability_type' => 'post',
			'has_archive' => false,
			'hierarchical' => false,
			'menu_position' => null,
			'supports' => array( 'title', 'editor' )
		) );
		
		// Bootstrap
		wp_register_script( 'pronamic-sections-bootstrap-tabs', plugins_url( 'assets/parts/bootstrap/bootstrap-tabs.js', PRONAMIC_SECTIONS_FILE ) );
		wp_register_style( 'pronamic-sections-bootstrap-tabs', plugins_url( 'assets/parts/bootstrap/bootstrap-tabs.css', PRONAMIC_SECTIONS_FILE ) );
		
		// Register the default managers
		Pronamic_WP_Sections_DisplayManager::register( 'Pronamic_WP_Sections_Display_Bootstrap' );
	}
	
	/**
	 * Register the partial assets we have to be a possible use for users
	 * of the plugin and also in the preview panel.
	 * 
	 * @access public
	 * @return void
	 */
	public function assets() {
		// Check if they want to load the assets
	}
}
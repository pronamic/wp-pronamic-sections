<?php

class Pronamic_Sections_Admin {
    public function __construct() {
		add_action( 'init', array( $this, 'init' ) );
		
		add_action( 'admin_enqueue_scripts', array( $this, 'assets' ) );
		
		add_action( 'wp_ajax_remove_tab', array( $this, 'ajax_remove_tab' ) );
		
		add_action( 'edit_page_form', array( $this, 'show_sections' ) );
		add_action( 'edit_form_advanced', array( $this, 'show_sections' ) );
		
		add_action( 'wp_ajax_pronamic_section_move_up', array( $this, 'ajax_pronamic_section_move_up' ) );
		add_action( 'wp_ajax_pronamic_section_move_down', array( $this, 'ajax_pronamic_section_move_down' ) );
		add_action( 'wp_ajax_pronamic_section_add', array( $this, 'ajax_pronamic_section_add' ) );
    }
	
	public function init() {
		load_plugin_textdomain( 'pronamic-sections-domain', false, dirname(plugin_basename( PRONAMIC_SECTIONS_FILE ) ) );
		
		// Register the new internal post type
		register_post_type( 'pronamic_section', array(
			'labels' => array(
				'name' => _x( 'Sections', 'Plural Name for Pronamic Section Post', 'pronamic-sections-domain' ),
				'singular_name' => _x( 'Section', 'Singular Name for the Pronamic Section Post', 'pronamic-sections-domain' )
			),
			'public'            => false,
			'publicly_querable' => false,
			'show_ui'           => false,
			'show_in_menu'      => false,
			'query_var'         => false,
			'rewrite'           => null,
			'capability_type'   => 'post',
			'has_archive'       => false,
			'hierarchical'      => false,
			'menu_position'     => null,
			'supports'          => array( 'title', 'editor' )
		) );
	}

    public function assets() {
        wp_register_script( 'pronamic_sections_admin', plugins_url( '/assets/admin/pronamic_sections_admin.js', PRONAMIC_SECTIONS_FILE ), array( 'jquery', 'jquery-ui-sortable' ) );
        wp_enqueue_script( 'pronamic_sections_admin' );
		
		wp_register_style( 'pronamic-sections', plugins_url( '/assets/admin/pronamic-sections.css', PRONAMIC_SECTIONS_FILE ) );
		wp_enqueue_style( 'pronamic-sections' );
    }
	
	public function show_sections( $post ) {
		// Get all sections
		$all_sections = Pronamic_Sections_SectionFactory::get_all_sections( $post->ID );
		
		$view = new Pronamic_Sections_View( PRONAMIC_SECTIONS_ROOT . '/views' );
		$view
			->set_view( 'show_sections' )
			->set( 'sections', $all_sections )
			->set( 'post_id', $post->ID )
			->render();
	}
	
	public function ajax_pronamic_section_move_up() {
		// Determine it is an ajax request
		if ( ! DOING_AJAX )
			return;
		
		// Get the required post information
		$current_id = filter_input( INPUT_POST, 'current_id', FILTER_SANITIZE_NUMBER_INT );
		$post_id    = filter_input( INPUT_POST, 'post_id', FILTER_SANITIZE_NUMBER_INT );
		$position   = filter_input( INPUT_POST, 'position', FILTER_SANITIZE_NUMBER_INT );
		
		// Get the section above this one
		$above_section = Pronamic_Sections_SectionFactory::get_above_section( $post_id, $position );
		
		// Get this section
		$section = Pronamic_Sections_Section::get_instance( $current_id );
		$section->move_up( $above_section );
	}
	
	public function ajax_pronamic_section_move_down() {
		if ( ! DOING_AJAX )
			return;
		
		// Get the required post information
		$current_id = filter_input( INPUT_POST, 'current_id', FILTER_SANITIZE_NUMBER_INT );
		$post_id    = filter_input( INPUT_POST, 'post_id', FILTER_SANITIZE_NUMBER_INT );
		$position   = filter_input( INPUT_POST, 'position', FILTER_SANITIZE_NUMBER_INT );
		
		// Get the section below this one
		$below_section = Pronamic_Sections_SectionFactory::get_below_section( $post_id, $position );
		
		// Get this section
		$section = Pronamic_Sections_Section::get_instance( $current_id );
		$section->move_down( $below_section );
	}
	
	public function ajax_pronamic_section_add() {
		if ( ! DOING_AJAX )
			return;
		
		// Get the required post information
		$parent_id    = filter_input( INPUT_POST, 'post_id', FILTER_SANITIZE_NUMBER_INT );
		$post_title   = filter_input( INPUT_POST, 'post_title', FILTER_UNSAFE_RAW );
		
		// Add the new section
		$section = Pronamic_Sections_SectionFactory::insert_section( $parent_id, $post_title );
		
		wp_send_json( array(
			'ret' => true,
			'msg' => __( 'Successfully added a new section. Update the post to see it!', 'pronamic-sections-domain' )
		) );
	}
}
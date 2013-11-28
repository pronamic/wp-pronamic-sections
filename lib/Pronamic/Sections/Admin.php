<?php

class Pronamic_Sections_Admin {
    public function __construct() {
		add_action( 'init', array( $this, 'init' ) );
		
		add_action( 'admin_enqueue_scripts', array( $this, 'assets' ) );
		
		add_action( 'edit_page_form', array( $this, 'show_sections' ) );
		add_action( 'edit_form_advanced', array( $this, 'show_sections' ) );
		add_action( 'save_post', array( $this, 'save_sections' ), 10, 2 );
		
		add_action( 'wp_ajax_pronamic_section_move_up', array( $this, 'ajax_pronamic_section_move_up' ) );
		add_action( 'wp_ajax_pronamic_section_move_down', array( $this, 'ajax_pronamic_section_move_down' ) );
		add_action( 'wp_ajax_pronamic_section_add', array( $this, 'ajax_pronamic_section_add' ) );
		add_action( 'wp_ajax_pronamic_section_remove', array( $this, 'ajax_pronamic_section_remove' ) );
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
        wp_register_script( 'pronamic_sections_admin', plugins_url( '/assets/admin/pronamic_sections_admin.js', PRONAMIC_SECTIONS_FILE ), array( 'jquery' ) );
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
	
	public function save_sections( $post_id, $post ) {
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return;
		
		if ( ! filter_has_var( INPUT_POST, 'pronamic_sections' ) )
			return;
		
		remove_action( 'save_post', array( $this, 'save_sections' ), 10, 2 );
		
		$sections = $_POST['pronamic_sections'];
		
		if ( empty( $sections) )
			return;
		
		foreach ( $sections as $section_id => $section_post ) {
			$section = Pronamic_Sections_Section::get_instance( $section_id );
			
			if ( is_a( $section, 'Pronamic_Sections_Section' ) ) {
				$is_updated = $section->update( $section_post['post_title'], $section_post['post_content'] );
			}
		}
		
		add_action( 'save_post', array( $this, 'save_sections' ), 10, 2 );
	}
	
	public function ajax_pronamic_section_move_up() {
		// Determine it is an ajax request
		if ( ! DOING_AJAX )
			return;
		
		// Get the required post information
		$current_id = filter_input( INPUT_POST, 'current_id', FILTER_SANITIZE_NUMBER_INT );
		$post_id    = filter_input( INPUT_POST, 'post_id', FILTER_SANITIZE_NUMBER_INT );
		
		// Get this section
		$section = Pronamic_Sections_Section::get_instance( $current_id );
		$position = $section->get_position();
		
		// Get the section above this one
		$above_section = Pronamic_Sections_SectionFactory::get_above_section( $post_id, $position );
		
		$section->move_up( $above_section );
		
		wp_send_json( array(
			'ret' => true,
			'msg' => sprintf( __( 'Successfully moved the %s section up. Refresh to see the changes', 'pronamic-sections-domain' ), $section->post->post_title )
		) );
	}
	
	public function ajax_pronamic_section_move_down() {
		if ( ! DOING_AJAX )
			return;
		
		// Get the required post information
		$current_id = filter_input( INPUT_POST, 'current_id', FILTER_SANITIZE_NUMBER_INT );
		$post_id    = filter_input( INPUT_POST, 'post_id', FILTER_SANITIZE_NUMBER_INT );
		
		// Get this section
		$section = Pronamic_Sections_Section::get_instance( $current_id );
		$position = $section->get_position();
		
		// Get the section below this one
		$below_section = Pronamic_Sections_SectionFactory::get_below_section( $post_id, $position );
		
		// Move the section down
		$section->move_down( $below_section );
		
		wp_send_json( array(
			'ret' => true,
			'msg' => sprintf( __( 'Successfully moved the %s section down. Refresh to see the changes', 'pronamic-sections-domain' ), $section->post->post_title )
		) );
	}
	
	public function ajax_pronamic_section_add() {
		if ( ! DOING_AJAX )
			return;
		
		// Get the required post information
		$parent_id    = filter_input( INPUT_POST, 'post_id', FILTER_SANITIZE_NUMBER_INT );
		$post_title   = filter_input( INPUT_POST, 'post_title', FILTER_UNSAFE_RAW );
		
		// Add the new section
		Pronamic_Sections_SectionFactory::insert_section( $parent_id, $post_title );
		
		wp_send_json( array(
			'ret' => true,
			'msg' => sprintf( __( 'Successfully added a new section: %s. Update the post to see it!', 'pronamic-sections-domain' ), $post_title )
		) );
	}
	
	public function ajax_pronamic_section_remove() {
		if ( ! DOING_AJAX )
			return;
		
		$section_id = filter_input( INPUT_POST, 'current_id', FILTER_SANITIZE_NUMBER_INT );
		
		$section = Pronamic_Sections_Section::get_instance( $section_id );
		$section->remove();
		
		wp_send_json( array(
			'ret' => true,
			'msg' => __( 'Successful removed the section.', 'pronamic-sections-domain' )
		) );
	}
}
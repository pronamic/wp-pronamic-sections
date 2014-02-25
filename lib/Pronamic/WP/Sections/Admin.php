<?php

class Pronamic_WP_Sections_Admin {

	public function __construct() {
		add_action( 'init', array( $this, 'init' ) );
		add_action( 'admin_init', array( $this, 'admin_init' ) );

		add_action( 'admin_enqueue_scripts', array( $this, 'assets' ) );

		add_action( 'edit_page_form', array( $this, 'show_sections' ) );
		add_action( 'edit_form_advanced', array( $this, 'show_sections' ) );
		add_action( 'save_post', array( $this, 'save_sections' ), 10, 2 );

		add_action( 'wp_ajax_pronamic_section_move_up', array( $this, 'ajax_pronamic_section_move_up' ) );
		add_action( 'wp_ajax_pronamic_section_move_down', array( $this, 'ajax_pronamic_section_move_down' ) );
		add_action( 'wp_ajax_pronamic_section_add', array( $this, 'ajax_pronamic_section_add' ) );
		add_action( 'wp_ajax_pronamic_section_remove', array( $this, 'ajax_pronamic_section_remove' ) );

		// Add support for section content in yoast analysis
		add_filter( 'wpseo_pre_analysis_post_content', array( $this, 'yoast_support' ), 10, 2 );
		
		// Add the admin menu
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		add_action( 'admin_init', array( $this, 'example_data' ) );
	}

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
	}

	public function admin_init() {

		$db_version = get_option( 'pronamic_sections_version' );

		if ( empty( $db_version ) )
			include_once PRONAMIC_SECTIONS_ROOT . '/includes/admin/upgrade.php';
	}

	public function assets() {
		wp_register_script( 'pronamic_sections_admin', plugins_url( '/assets/admin/pronamic_sections_admin.js', PRONAMIC_SECTIONS_FILE ), array( 'jquery' ) );
		wp_enqueue_script( 'pronamic_sections_admin' );

		wp_register_style( 'pronamic-sections', plugins_url( '/assets/admin/pronamic-sections.css', PRONAMIC_SECTIONS_FILE ) );
		wp_enqueue_style( 'pronamic-sections' );
	}

	public function show_sections( $post ) {
		// Get all sections
		$all_sections = Pronamic_WP_Sections_SectionFactory::get_all_sections( $post->ID );

		$view = new Pronamic_WP_Sections_View( PRONAMIC_SECTIONS_ROOT . '/views' );
		$view
				->set_view( 'show_sections' )
				->set( 'sections', $all_sections )
				->set( 'post_id', $post->ID )
				->render();
	}

	public function save_sections( $post_id, $post ) {
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return;

		if ( !filter_has_var( INPUT_POST, 'pronamic_sections' ) )
			return;

		remove_action( 'save_post', array( $this, 'save_sections' ), 10, 2 );

		$sections = $_POST['pronamic_sections'];

		if ( empty( $sections ) )
			return;

		foreach ( $sections as $section_id => $section_post ) {
			$section = Pronamic_WP_Sections_Section::get_instance( $section_id );

			if ( is_a( $section, 'Pronamic_WP_Sections_Section' ) ) {
				$is_updated = $section->update( $section_post['post_title'], $section_post['post_content'] );
			}
		}

		add_action( 'save_post', array( $this, 'save_sections' ), 10, 2 );
	}

	public function ajax_pronamic_section_move_up() {
		// Determine it is an ajax request
		if ( !DOING_AJAX )
			return;

		// Get the required post information
		$current_id = filter_input( INPUT_POST, 'current_id', FILTER_SANITIZE_NUMBER_INT );
		$post_id = filter_input( INPUT_POST, 'post_id', FILTER_SANITIZE_NUMBER_INT );

		// Get this section
		$section = Pronamic_WP_Sections_Section::get_instance( $current_id );
		$position = $section->get_position();

		// Get the section above this one
		$above_section = Pronamic_WP_Sections_SectionFactory::get_above_section( $post_id, $position );

		$section->move_up( $above_section );

		wp_send_json( array(
			'ret' => true,
			'msg' => sprintf( __( 'Successfully moved the %s section up. Refresh to see the changes', 'pronamic-sections-domain' ), $section->post->post_title )
		) );
	}

	public function ajax_pronamic_section_move_down() {
		if ( !DOING_AJAX )
			return;

		// Get the required post information
		$current_id = filter_input( INPUT_POST, 'current_id', FILTER_SANITIZE_NUMBER_INT );
		$post_id = filter_input( INPUT_POST, 'post_id', FILTER_SANITIZE_NUMBER_INT );

		// Get this section
		$section = Pronamic_WP_Sections_Section::get_instance( $current_id );
		$position = $section->get_position();

		// Get the section below this one
		$below_section = Pronamic_WP_Sections_SectionFactory::get_below_section( $post_id, $position );

		// Move the section down
		$section->move_down( $below_section );

		wp_send_json( array(
			'ret' => true,
			'msg' => sprintf( __( 'Successfully moved the %s section down. Refresh to see the changes', 'pronamic-sections-domain' ), $section->post->post_title )
		) );
	}

	public function ajax_pronamic_section_add() {
		if ( !DOING_AJAX )
			return;

		// Get the required post information
		$parent_id = filter_input( INPUT_POST, 'post_id', FILTER_SANITIZE_NUMBER_INT );
		$post_title = filter_input( INPUT_POST, 'post_title', FILTER_UNSAFE_RAW );

		// Add the new section
		Pronamic_WP_Sections_SectionFactory::insert_section( $parent_id, $post_title );

		wp_send_json( array(
			'ret' => true,
			'msg' => sprintf( __( 'Successfully added a new section: %s. Update the post to see it!', 'pronamic-sections-domain' ), $post_title )
		) );
	}

	public function ajax_pronamic_section_remove() {
		if ( !DOING_AJAX )
			return;

		$section_id = filter_input( INPUT_POST, 'current_id', FILTER_SANITIZE_NUMBER_INT );

		$section = Pronamic_WP_Sections_Section::get_instance( $section_id );
		$section->remove();

		wp_send_json( array(
			'ret' => true,
			'msg' => __( 'Successful removed the section.', 'pronamic-sections-domain' )
		) );
	}

	public function yoast_support( $content, WP_Post $post ) {
		// Get the Pronamic Sections
		$pronamic_sections = the_pronamic_sections( $post->ID );

		$element = apply_filters( 'pronamic_sections_yoast_support_title_element', 'h2' );

		foreach ( $pronamic_sections as $pronamic_section ) {
			$content .= "<{$element}>{$pronamic_section->get_title()}</{$element}>";
			$content .= $pronamic_section->get_content();
			$content .= '<br/>';
		}

		return $content;
	}
	
	public function admin_menu() {
		// Admin Menu
		add_menu_page(
			__( 'Pronamic Sections', 'pronamic-sections-domain' ),
			__( 'Sections', 'pronamic-sections-domain' ),
			'manage_options',
			'pronamic_sections',
			array( $this, 'view_pronamic_sections_page' ),
			'dashicons-list-view'
		);
	}
	
	public function view_pronamic_sections_page() {
		$section = 'pronamic-sections-general';
		
		if ( filter_has_var( INPUT_GET, 'group' ) ) {
			$section = filter_input( INPUT_GET, 'group', FILTER_SANITIZE_STRING );
		}
		
		include plugin_dir_path( PRONAMIC_SECTIONS_FILE ) . 'views/admin/view_pronamic_sections_page.php';
	}
	
	/**
	 * Handles the request to do something with the example data.  Allows
	 * the two values of install and uninstall and then redirects back to
	 * the sections example page.
	 * 
	 * @todo Requires better validation check to ensure no-one can just call
	 * this from the admin area. Cap check.
	 * 
	 * @access public
	 * @return void
	 */
	public function example_data() {
		if ( ! filter_has_var( INPUT_GET, 'example-data' ) ) {
			return;
		}
		
		// Determine what they user pressed.
		$intent = filter_input( INPUT_GET, 'example-data', FILTER_SANITIZE_STRING );
		
		// Intents you can run
		$valid_intents = array(
			'install',
			'uninstall',
		);
		
		// Ensure the intent is valid
		if ( ! in_array( $intent, $valid_intents ) ) {
			return;
		}
		
		// Call the intents method
		call_user_func( array( $this, $intent . '_example_data' ) );
		
		// Redirect so a refresh doesn't recall it.
		wp_redirect( add_query_arg( array(
			'page' => 'pronamic_sections',
			'group' => 'pronamic-sections-examples'
		), admin_url() ) );
		exit;
	}
	
	/**
	 * Creates the post and its sections for the example data.
	 * 
	 * @access public
	 * @return void
	 */
	public function install_example_data() {
		// get a possible existing id
		$existing_post_id = get_option( 'pronamic_sections_example_post_id' );
		
		// remove old data first
		if ( ! empty( $existing_post_id ) ) {
			$this->uninstall_example_data();
		}
		
		// Make a new parent page
		$example_post_id = wp_insert_post( array( 
			'post_title' => __( 'Pronamic Sections Example', 'pronamic-sections-domain' ),
			'post_type' => 'pronamic_section_example',
			'post_status' => 'inherit'
		) );
		
		// Add the saved option for the example id
		update_option( 'pronamic_sections_example_post_id', $example_post_id );
		
		// Make 3 sections
		for ( $i = 0; $i <= 3; $i++ ) {
			$section_id = wp_insert_post( array(
				'post_title' => sprintf( __( 'Section %d', 'pronamic-sections-domain' ), $i ),
				'post_content' => sprintf( __( 'Example content for Section %d', 'pronamic-sections-domain' ), $i ),
				'post_type' => 'pronamic_section',
				'post_parent' => $example_post_id,
				'post_status' => 'publish'
			) );
			
			// Set the sections position
			add_post_meta( $section_id, '_pronamic_section_position', $i );
		}
	}
	
	/**
	 * Removes the example data and deleted the saved example_post_id option.
	 * 
	 * @access public
	 * @reeturn void
	 */
	public function uninstall_example_data() {
		// check an existing example id has been set
		$example_post_id = get_option( 'pronamic_sections_example_post_id' );
		
		if ( ! empty( $example_post_id ) ) {
			
			// get all sections
			$sections = the_pronamic_sections( $example_post_id );
			
			// remove
			foreach ( $sections as $section ) {
				wp_delete_post( $section->ID );
			}

			// remove the parent page and remove the option
			wp_delete_post( $example_post_id );
			delete_option( 'pronamic_sections_example_post_id' );
		}
	}

}

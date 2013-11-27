<?php

class Pronamic_Sections_Admin {
    public function __construct() {
		add_action( 'init', array( $this, 'init' ) );
		
		add_action( 'admin_enqueue_scripts', array( $this, 'assets' ) );

        add_action( 'add_meta_boxes', array( $this, 'meta_boxes' ) );

        add_action( 'save_post', array( $this, 'save_section_meta_box' ) );
		
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

    public function meta_boxes() {

		$post_types = get_post_types( '', 'names' );
		
		// Go through every post type
		foreach ( $post_types as $post_type ) {
			
			// Look for supports = array( 'pronamic_sections' ) from a post type
			if ( post_type_supports( $post_type, 'pronamic_sections' ) ) {
								
				add_meta_box(
					'pronamic-sections-meta-box',
					__( 'Pronamic Sections', 'pronamic-sections-domain' ),
					array( $this, 'view_section_meta_box' ),
					$post_type,
					'advanced',
					'high'
				);
			}
		}
        
    }

    public function view_section_meta_box( $post ) {
		// Get all sections
		$all_sections = Pronamic_Sections_SectionFactory::get_all_sections( $post->ID );
		
        // Start template engine
        $view = new Pronamic_Sections_View( PRONAMIC_SECTIONS_ROOT . '/views' );
        $view
            ->set_view( 'view_section_meta_box' )
			->set( 'sections', $all_sections )
			->set( 'post_id', $post->ID )
			->render();
    }

    public function save_section_meta_box( $post_id ) {
        

	}
	
	public function show_sections( $post ) {
		// Get all sections
		$all_sections = Pronamic_Sections_SectionFactory::get_all_sections( $post->ID );
		var_dump($all_sections);
		?>
		<div class="pronamic_sections_editor_holder">
			<h3 class="pronamic_sections_title"><?php _e( 'Sections', 'pronamic-sections-domain' ); ?></h3>
			<?php if ( ! empty( $all_sections ) ) : ?>
				<?php foreach ( $all_sections as $section ) : ?>
					<?php $section_class = new Pronamic_Sections_Section( $section ); ?>
					<div class="pronamic_section_holder" data-id="<?php echo $section->ID; ?>" data-position="<?php echo $section_class->get_position(); ?>">
						<input type="text" value="<?php echo $section->post_title; ?>"/>
						<?php wp_editor( $section->post_content, 'pronamic-section-editor-' . $section->ID ); ?>
					</div>
				<?php endforeach; ?>
			<?php else: ?>
			<p>
				<?php _e( 'You have no sections yet. To start, add a section in the meta box!', 'pronamic-sections-domain' ); ?>
			</p>
			<?php endif; ?>
		</div>
		<?php
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
		
		echo json_encode( array( 'section' => $section ) );
		exit;
	}
}
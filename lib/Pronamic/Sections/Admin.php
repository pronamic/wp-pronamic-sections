<?php

class Pronamic_Sections_Admin {
    public function __construct() {
        add_action( 'admin_enqueue_scripts', array( $this, 'assets' ) );

        add_action( 'add_meta_boxes', array( $this, 'meta_boxes' ) );

        add_action( 'save_post', array( $this, 'save_section_meta_box' ) );
		
		add_action( 'wp_ajax_remove_tab', array( $this, 'ajax_remove_tab' ) );
		
    }

    public function assets() {
        wp_register_script( 'pronamic_sections_admin', plugins_url( '/assets/admin/pronamic_sections_admin.js', PRONAMIC_SECTIONS_FILE ), array( 'jquery', 'jquery-ui-sortable' ) );
        wp_enqueue_script( 'pronamic_sections_admin' );
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

        // Generate nonce
        $nonce = wp_nonce_field( 'pronamic_section_metabox', 'pronamic_section_metabox_nonce', true, false );

        $quantity = get_post_meta( $post->ID, 'pronamic_sections_quantity', true );

        if ( ! isset( $quantity) )
            $quantity = '0';

        // Get the extra tabs
        $extra_content = get_post_meta( $post->ID, 'pronamic_sections', true );

        // Start template engine
        $view = new Pronamic_Sections_View( PRONAMIC_SECTIONS_ROOT . '/views' );
        $view
            ->set_view( 'view_section_meta_box' )
            ->set( 'nonce', $nonce )
            ->set( 'quantity', $quantity )
            ->set( 'tabs', $extra_content )
            ->render();
    }

    public function save_section_meta_box( $post_id ) {
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
            return;

        if ( ! isset( $_POST['pronamic_section_metabox_nonce'] ) )
            return;

        if ( ! wp_verify_nonce( $_POST['pronamic_section_metabox_nonce'], 'pronamic_section_metabox' ) )
            return;

        $pct_content = $_POST['pct_content'];

        if ( ! empty( $pct_content ) ) {
            foreach ( $pct_content as $key => $tab ) {
                if ( isset( $tab['title'] ) ) {
                    $pct_content[$key]['title'] = apply_filters( 'the_title', $tab['title'] );
                }

                if ( isset( $tab['content'] ) ) {
                    $pct_content[$key]['content'] = apply_filters( 'the_content', $tab['content'] );
                }
            }

			$order = array();
			foreach ( $pct_content as $key => $tab ) {
				$order[$key] = $tab['order'];
			}
						
			array_multisort($order, SORT_ASC, $pct_content);
			
            update_post_meta( $post_id, 'pronamic_sections', $pct_content );    
        } else {
			delete_post_meta( $post_id, 'pronamic_sections' );
		}
        
		

        update_post_meta( $post_id, 'pronamic_sections_quantity', filter_input( INPUT_POST, 'pronamic_section_quantity', FILTER_VALIDATE_INT ) );

	}
	
	public function ajax_remove_tab() {
		
		
		if ( isset( $_POST['tab_id'] ) ) {
			
			$tab_id = $_POST['tab_id'];
			$post_id = $_POST['post_id'];
			
			$pct_content = get_post_meta( $post_id, 'pronamic_sections', true );
			
			if ( isset( $pct_content[$tab_id] ) ) {
				unset( $pct_content[$tab_id] );
				
				$resorted_pct_content = array_values( $pct_content );
				
				if ( ! empty( $resorted_pct_content ) ) {
					update_post_meta( $post_id, 'pronamic_sections', $resorted_pct_content );
					update_post_meta( $post_id, 'pronamic_sections_quantity', ( count( $resorted_pct_content ) - 1 ) );
				} else {
					delete_post_meta( $post_id, 'pronamic_sections' );
					delete_post_meta( $post_id, 'pronamic_sections_quantity' );
				}
				
			}
			
		}
		
		exit;
	}
}
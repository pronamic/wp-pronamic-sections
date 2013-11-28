<?php

class Pronamic_Sections_SectionFactory {
	
	/**
	 * Returns the section above the current passed in position.
	 * This is mainly used to move a section up.
	 * 
	 * @access static public
	 * @param numeric $post_id
	 * @param numeric $position
	 * @return WP_Post|null
	 */
	public static function get_above_section( $post_id, $position ) {
		$above_position = intval( $position );
		$above_position--;
		
		$above_section_query = new WP_Query( array(
			'post_type'           => 'pronamic_section',
			'post_parent'         => $post_id,
			'posts_per_page'      => 1,
			'ignore_sticky_posts' => true,
			'meta_query'          => array(
				array(
					'key'   => '_pronamic_section_position',
					'value' => $above_position
				),
			)
		) );
		
		if ( ! $above_section_query->have_posts() )
			return null;
		
		return new Pronamic_Sections_Section( $above_section_query->post );
	}
	
	/**
	 * Returns the section below the current section in the passed
	 * in position.
	 * 
	 * This is mainly used to move a section down.
	 * 
	 * @access static public
	 * @param numeric $post_id
	 * @param numeric $position
	 * @return WP_Post|null
	 */
	public static function get_below_section( $post_id, $position ) {
		$below_position = intval( $position );
		$below_position++;
		
		$below_section_query = new WP_Query( array(
			'post_type'           => 'pronamic_section',
			'post_parent'         => $post_id,
			'posts_per_page'      => 1,
			'ignore_sticky_posts' => true,
			'meta_query'          => array(
				array(
					'key'   => '_pronamic_section_position',
					'value' => $below_position
				)
			)
		) );
		
		if ( ! $below_section_query->have_posts() )
			return null;
		
		return new Pronamic_Sections_Section( $below_section_query->post );
	}
	
	/**
	 * Returns all assigned sections for the passed in
	 * post id
	 * 
	 * @access static public
	 * @param int $post_id
	 * @return array
	 */
	public static function get_all_sections( $post_id ) {
		$sections_query = new WP_Query( array(
			'post_type'           => 'pronamic_section',
			'post_parent'         => $post_id,
			'nopaging'            => true,
			'ignore_sticky_posts' => true,
			'meta_key'            => '_pronamic_section_position',
			'orderby'             => 'meta_value_num',
			'order'               => 'ASC'
		) );
		
		if ( ! $sections_query->have_posts() )
			return array();
		
		return $sections_query->posts;
	}
	
	/**
	 * Adds a new section to the passed in parent id.  Will insert the 
	 * section at the specified position. If no position specified, will 
	 * add to the end of the position.
	 * 
	 * @access static public
	 * @param int $parent_id
	 * @param string $title
	 * @param string $content
	 * @param int $position
	 * @return Pronamic_Sections_Section|false
	 */
	public static function insert_section( $parent_id, $title, $position = null ) {
		$section_id = wp_insert_post( array(
			'post_type' => 'pronamic_section',
			'post_parent' => $parent_id,
			'post_title' => $title,
			'post_status' => 'publish'
		) );
		
		if ( ! $section_id )
			return false;
		
		// Get the section
		$section = Pronamic_Sections_Section::get_instance( $section_id );
		
		if ( null === $position )
			$position = self::get_next_free_position( $parent_id );
		
		$section->set_position( $position );
		
		return $section;
	} 
	
	/**
	 * Returns the next free position number for a section with the
	 * passed in parent id
	 * 
	 * @access static public
	 * @param int $parent_id
	 * @return int
	 */
	public static function get_next_free_position( $parent_id ) {
		// Get all the sections
		$sections = self::get_all_sections( $parent_id );
		
		if ( empty( $sections ) )
			return 0;
		
		// Get the last section
		$last_section_post = end( $sections );
		
		$last_section = new Pronamic_Sections_Section( $last_section_post );
		$last_section_position = $last_section->get_position();
		$last_section_position++;
		
		return $last_section_position;
	}
}
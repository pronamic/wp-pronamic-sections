<?php

/**
 * Used to represent a section.  Is a entity representation of a Post
 *
 *
 */
class Pronamic_WP_Sections_Section {
	public $ID;

	public $post;

	private $position;

	public $title;
	public $content;
	public $order;

	public function __construct( WP_Post $post = null ) {
		if ( null !== $post ) {
			$this->populate( $post );
		}
	}

	/**
	 * Can be passed any parameter that could be passed into
	 * get_post()
	 *
	 * @access public
	 * @param mixed $id
	 * @return \Pronamic_Sections_Section|boolean
	 */
	public static function get_instance( $id ) {
		if ( $result = get_post( $id ) ) {
			return new Pronamic_WP_Sections_Section( $result );
		}

		return false;
	}

	/**
	 * Loads all of the required meta data and populates the class
	 * with the required information for the other methods to work.
	 *
	 * @access public
	 * @param WP_Post $post
	 * @return void
	 */
	public function populate( WP_Post $post ) {
		$this->ID   = $post->ID;
		$this->post = $post;

		$this->position  = intval( get_post_meta( $this->ID, '_pronamic_section_position', true ) );

		// Compat support
		$this->title = $this->post->post_title;
		$this->content = $this->post->post_content;
		$this->order = $this->position;
	}

	/**
	 * Returns the post objects post_title ran through the the_title
	 * filter.
	 *
	 * @access public
	 * @return string
	 */
	public function get_title() {
		return apply_filters( 'the_title', $this->post->post_title );
	}

	/**
	 * Returns the post objects post_name. The post_name is just a slugified
	 * post_title.
	 *
	 * @access public
	 * @return string
	 */
	public function get_slug() {
		return $this->post->post_name;
	}

	/**
	 * Returns the post_content of the section ran through the_content
	 * filter.
	 *
	 * @access public
	 * @return string
	 */
	public function get_content() {
		return apply_filters( 'the_content', $this->post->post_content );
	}

	/**
	 * Returns the current position of this section
	 *
	 * @access public
	 * @return numeric
	 */
	public function get_position() {
		return $this->position;
	}

	/**
	 * Sets the position of this current section. It is recommended
	 * you not use this method directly.  It is mainly used by the
	 * move_up() and move_down() methods.
	 *
	 * @access private
	 * @param numeric $position
	 * @return \Pronamic_WP_Sections_Section
	 */
	public function set_position( $position ) {
		$this->position = $position;
		update_post_meta( $this->ID, '_pronamic_section_position', $this->position );

		return $this;
	}

	/**
	 * Moves this section up, and sets the passed in Pronamic_WP_Sections_Section
	 * to that of this sections current number.
	 *
	 * @access public
	 * @param Pronamic_WP_Sections_Section $above_section
	 * @return \Pronamic_WP_Sections_Section
	 */
	public function move_up( Pronamic_WP_Sections_Section $above_section ) {
		$old_above_position = $above_section->get_position();
		// Set the position of the one above, to this current position
		$above_section->set_position( $this->position );

		// Lowers the number, so it goes higher
		$new_position = $old_above_position;
		$this->set_position( $new_position );

		return $this;
	}

	/**
	 * Moves this section down, and sets the passed in Pronamic_WP_Sections_Section
	 * to that of this sections current number.
	 *
	 * @access public
	 * @param Pronamic_WP_Sections_Section $below_section
	 * @return \Pronamic_WP_Sections_Section
	 */
	public function move_down( Pronamic_WP_Sections_Section $below_section ) {
		$old_below_position = $below_section->get_position();
		// Get the section below this one
		$below_section->set_position( $this->position );

		// Increase the number, so it goes lower
		$new_position = $old_below_position;
		$this->set_position( $new_position );

		return $this;
	}

	/**
	 * Updates a section with the passed in post title
	 * and the post content
	 * @param string $post_title
	 * @param string $post_content
	 * @return boolean
	 */
	public function update( $post_title, $post_content ) {
		$result = wp_update_post( array(
			'ID'           => $this->ID,
			'post_title'   => $post_title,
			'post_content' => $post_content,
		) );

		do_action( 'pronamic_section_update', $this );

		return ( bool ) ( 0 !== $result );
	}

	/**
	 * Removing this instance of the Section
	 */
	public function remove() {
		wp_trash_post( $this->ID );
	}
}

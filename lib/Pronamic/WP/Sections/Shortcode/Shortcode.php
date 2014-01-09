<?php

abstract class Pronamic_WP_Sections_Shortcode_Shortcode {
	
	/**
	 * Holds the passed in attributes to the shortcode
	 * @var array
	 */
	private $atts = array();
	
	/**
	 * Holds the prepared attributes, the ones that have been
	 * merged with the 
	 * @var array
	 */
	private $attributes = array();
	
	/**
	 * Holds the content between the 2 shortcode tags
	 * @var string
	 */
	private $content = '';
	
	/**
	 * Handles the shortcode attributes and passed in content if there is
	 * any. 
	 * 
	 * Will set to the properties of the class so they can be accessed by
	 * the getter, setter.
	 * 
	 * @access public
	 * @param array $atts
	 * @param string $content
	 */
	public function __construct( $atts, $content = '' ) {
		$this->atts    = $atts;
		$this->content = $content;
		
		// Merge the attributes
		$this->attributes = shortcode_atts( $this->return_defaults(), $this->atts );
	} 
	
	/**
	 * Returns the array of attributes put through the shortcode_atts method.
	 * 
	 * @access public
	 * @return array
	 */
	public function get_attributes() {
		return $this->attributes;
	}
	
	/**
	 * Returns a specific value of the attributes from the passed in key.
	 * 
	 * @access public
	 * @param string|int $key
	 * @return mixed
	 */
	public function get_attribute( $key ) {
		return $this->attributes[$key];
	}
	
	/**
	 * Determine if the passed in comparison matches the keys value
	 * Defaults to a boolean check, this is changed with the 3rd param
	 * 
	 * @param string|bool $key
	 * @param string|bool $comparison
	 * @param string $type [boolean or string]
	 * @return bool
	 */
	public function is_attribute( $key, $comparison = true, $type = 'boolean' ) {
		if ( 'string' === $type ) {
			$value = ( $this->attributes[$key] === $comparison );
		} else if ( 'boolean' === $type ) {
			$value = ( (bool) $this->attributes[$key] === $comparison );
		}
		
		return $value;
	}
	
	/**
	 * Returns the content between the shortcode tags.
	 * 
	 * @access public
	 * @return string
	 */
	public function get_content() {
		return $this->content;
	}
	
	/**
	 * Returns all the sections for the passed in post_id.  If no post_id was
	 * passed in, then use the global ID.
	 * 
	 * @access public
	 * @param int $post_id
	 * @return array
	 */
	public function get_sections( $post_id = null ) {
		if ( null === $post_id ) {
			$post_id = get_the_ID();
		}
		
		return the_pronamic_sections( $post_id );
	}
	
	/**
	 * Returns an array of the default values of the attributes of
	 * the shortcode
	 * 
	 * @access public
	 * @return array
	 */
	abstract public function return_defaults();
	
	/**
	 * Renders the shortcode depending on a few setting options
	 * 
	 * @access public
	 * @return void
	 */
	abstract public function render();
}
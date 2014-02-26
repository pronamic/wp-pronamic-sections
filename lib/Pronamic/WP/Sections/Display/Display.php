<?php

abstract class Pronamic_WP_Sections_Display_Display {
	
	private $ID = '';
	private $name = '';
	private $options = array();
	private $sections = array();
	
	public function __construct( $id, $name, array $options ) {
		$this->ID = $id;
		$this->name = $name;
		$this->options = $options;
	}
	
	public function get_ID() {
		return $this->ID;
	}
	
	public function get_name() {
		return $this->name;
	}
	
	public function get_description() {
		if ( isset( $this->options['description'] ) ) {
			return $this->options['description'];
		}
	}
	
	public function set_sections( array $sections ) {
		foreach ( $sections as $section ) {
			if ( ! is_a( $section, 'Pronamic_WP_Sections_Section' ) ) {
				return false;
			}
		}
		
		$this->sections = $sections;
	}
	
	public function get_sections() {
		return $this->sections;
	}
	
	abstract public function output();
}
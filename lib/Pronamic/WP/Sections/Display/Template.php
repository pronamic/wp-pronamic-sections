<?php

class Pronamic_WP_Sections_Display_Template extends Pronamic_WP_Sections_Display_Display {
	
	public function __construct( $file_name, array $sections ) {
		parent::__construct( $sections );
		
		$this->file_name = $file_name;
	}
	
	public function output() {
		
	}
}
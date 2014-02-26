<?php

class Pronamic_WP_Sections_DisplayManager {
	
	static private $displays = array();
	static private $instanciated = array();
	
	static public function register( $display ) {
		self::$displays[] = $display;
	}
	
	static public function all() {
		foreach ( self::$displays as $display ) {
			self::$instanciated[] = new $display;
		}
		
		return self::$instanciated;
	}
}
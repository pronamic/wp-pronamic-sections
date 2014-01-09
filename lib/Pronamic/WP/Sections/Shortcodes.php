<?php

class Pronamic_WP_Sections_Shortcodes {
	
	public function __construct() {
		// Register the classes to handle the shortcodes
		Pronamic_WP_Sections_ShortcodeFactory::add( 'bootstrap', 'Pronamic_WP_Sections_Shortcode_Bootstrap' );
		Pronamic_WP_Sections_ShortcodeFactory::add( 'foundation', 'Pronamic_WP_Sections_Shortcode_Foundation' );
		
		// Add the shortcode action
		add_shortcode( 'bootstrap-tabs', array( $this, 'bootstrap' ) );
		add_shortcode( 'foundation-tabs', array( $this, 'foundation' ) );
	}
	
	public function bootstrap( $atts, $content = '' ) {
		return $this->_shortcode( 'bootstrap', $atts, $content );
	}
	
	public function foundation( $atts, $content = '' ) {
		return $this->_shortcode( 'foundation', $atts, $content );
	}
	
	private function _shortcode( $name, $atts, $content = '' ) {
		$type_class = Pronamic_WP_Sections_ShortcodeFactory::get( $name );
		$type = new $type_class( $atts, $content );
		
		ob_start();
		
		$type->render();
		
		$contents = ob_get_contents();
		ob_end_clean();
		
		return $contents;
	}
}
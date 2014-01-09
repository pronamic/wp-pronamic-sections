<?php

class Pronamic_WP_Sections_ShortcodeFactory {
	
	private static $shortcode_classes = array();
	
	public static function get( $name ) {
		return self::$shortcode_classes[$name];
	}
	
	public static function add( $name, $class_name ) {
		self::$shortcode_classes[$name] = $class_name;
	}
}
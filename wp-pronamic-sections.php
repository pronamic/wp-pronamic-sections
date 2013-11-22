<?php

/**
 * Plugin Name: Pronamic Sections
 * Author: Pronamic
 * Author URI: http://pronamic.nl
 * Domain: pronamic-sections-domain
 */

define( 'PRONAMIC_SECTIONS_FILE', __FILE__ );
define( 'PRONAMIC_SECTIONS_ROOT', dirname( __FILE__ ) );
define( 'PRONAMIC_SECTIONS_FOLDER', basename( PRONAMIC_SECTIONS_ROOT ) );

// Load the admin!
if ( is_admin() ) {
	// Required classes
	include PRONAMIC_SECTIONS_ROOT . '/lib/Pronamic/Sections/Section.php';
	include PRONAMIC_SECTIONS_ROOT . '/lib/Pronamic/Sections/SectionFactory.php';
	include PRONAMIC_SECTIONS_ROOT . '/lib/Pronamic/Sections/Admin.php';
	include PRONAMIC_SECTIONS_ROOT . '/lib/Pronamic/Sections/View.php';
	
	global $pronamic_sections_admin;
	$pronamic_sections_admin = new Pronamic_Sections_Admin();
}

include PRONAMIC_SECTIONS_ROOT . '/inc/template-functions.php';
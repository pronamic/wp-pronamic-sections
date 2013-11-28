<?php

/**
 * Plugin Name: Pronamic Sections
 * Author: Pronamic
 * Author URI: http://pronamic.nl
 * Domain: pronamic-sections-domain
 * Version: 1.1.1
 */

define( 'PRONAMIC_SECTIONS_FILE', __FILE__ );
define( 'PRONAMIC_SECTIONS_ROOT', dirname( __FILE__ ) );
define( 'PRONAMIC_SECTIONS_FOLDER', basename( PRONAMIC_SECTIONS_ROOT ) );

// Required classes
include PRONAMIC_SECTIONS_ROOT . '/lib/Pronamic/WP/Sections/Section.php';
include PRONAMIC_SECTIONS_ROOT . '/lib/Pronamic/WP/Sections/SectionFactory.php';

// Load the admin!
if ( is_admin() ) {
	
	include PRONAMIC_SECTIONS_ROOT . '/lib/Pronamic/WP/Sections/Admin.php';
	include PRONAMIC_SECTIONS_ROOT . '/lib/Pronamic/WP/Sections/View.php';
	
	global $pronamic_sections_admin;
	$pronamic_sections_admin = new Pronamic_WP_Sections_Admin();
}

include PRONAMIC_SECTIONS_ROOT . '/includes/template-functions.php';
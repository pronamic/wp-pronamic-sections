<?php
/*
Plugin Name: Pronamic Sections
Plugin URI: http://www.happywp.com/plugins/pronamic-sections/
Description: Store additional WYSIWYG content for your posts/pages/CPT's that you can use for ANY tab library.

Version: 1.3.0
Requires at least: 3.0

Author: Pronamic
Author URI: http://www.pronamic.eu/

Text Domain: pronamic-sections-domain
Domain Path: /languages/

License: GPL

GitHub URI: https://github.com/pronamic/wp-pronamic-sections
*/

define( 'PRONAMIC_SECTIONS_FILE', __FILE__ );
define( 'PRONAMIC_SECTIONS_ROOT', dirname( __FILE__ ) );
define( 'PRONAMIC_SECTIONS_FOLDER', basename( PRONAMIC_SECTIONS_ROOT ) );

// Required classes
include PRONAMIC_SECTIONS_ROOT . '/lib/Pronamic/WP/Sections/Section.php';
include PRONAMIC_SECTIONS_ROOT . '/lib/Pronamic/WP/Sections/SectionFactory.php';
include PRONAMIC_SECTIONS_ROOT . '/lib/Pronamic/WP/Sections/Plugin.php';

global $pronamic_sections_plugin;

$pronamic_sections_plugin = new Pronamic_WP_Sections_Plugin();

// Load the admin!
if ( is_admin() ) {
	include PRONAMIC_SECTIONS_ROOT . '/lib/Pronamic/WP/Sections/Admin.php';
	include PRONAMIC_SECTIONS_ROOT . '/lib/Pronamic/WP/Sections/View.php';
	include PRONAMIC_SECTIONS_ROOT . '/lib/Pronamic/WP/Sections/Settings.php';

	global $pronamic_sections_admin;

	$pronamic_sections_admin = new Pronamic_WP_Sections_Admin();

	new Pronamic_WP_Sections_Settings();
}

include PRONAMIC_SECTIONS_ROOT . '/includes/template-functions.php';

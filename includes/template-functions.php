<?php

function pronamic_sections( $id = null ) {
	_deprecated_function( 'pronamic_sections', '1.0.0', 'the_pronamic_sections' );

	if ( ! $id ) {
		$id = get_the_ID();
	}

	$sections = Pronamic_WP_Sections_SectionFactory::get_all_sections( $id );

	if ( empty( $sections ) ) {
		return array();
	}

	$prepared_sections = array();
	foreach ( $sections as $section ) {
		$_section = new Pronamic_WP_Sections_Section( $section );

		$prepared_sections[] = array(
			'title'   => $_section->title,
			'content' => $_section->content,
			'order'   => $_section->order,
		);
	}

	return $prepared_sections;
}

function the_pronamic_sections( $id = null ) {
	if ( ! $id ) {
		$id = get_the_ID();
	}

	$sections = Pronamic_WP_Sections_SectionFactory::get_all_sections( $id );

	if ( empty( $sections ) ) {
		return array();
	}

	$prepared_sections = array();
	foreach ( $sections as $section ) {
		$prepared_sections[] = new Pronamic_WP_Sections_Section( $section );
	}

	return $prepared_sections;
}

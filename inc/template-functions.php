<?php

function pronamic_sections( $id = null ) {
    if ( ! $id )
        $id = get_the_ID();

    $sections = Pronamic_Sections_SectionFactory::get_all_sections( $id );
	
	if ( empty( $sections ) )
		return array();
	
	$prepared_sections = array();
	foreach ( $sections as $section ) {
		$prepared_sections[] = new Pronamic_Sections_Section( $section );
	}
	
	return $prepared_sections;
}
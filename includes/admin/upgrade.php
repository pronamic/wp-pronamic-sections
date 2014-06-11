<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Get previous sections
$existing_posts_with_sections_query = new WP_Query( array(
	'post_type' => 'any',
	'meta_query' => array(
		array(
			'key'     => 'pronamic_sections',
			'value'   => null,
			'compare' => 'EXISTS',
		),
	),
) );

foreach ( $existing_posts_with_sections_query->posts as $post ) {
	$sections = get_post_meta( $post->ID, 'pronamic_sections', true );

	foreach ( $sections as $section ) {
		$_section = Pronamic_Sections_SectionFactory::insert_section( $post->ID, $section['title'], $section['order'] );
		$_section->update( $section['title'], $section['content'] );
	}
}

update_option( 'pronamic_sections_version', '100' );

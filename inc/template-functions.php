<?php

function pronamic_sections( $id = null ) {
    if ( ! $id )
        $id = get_the_ID();

    return get_post_meta( $id, 'pronamic_sections', true );
}
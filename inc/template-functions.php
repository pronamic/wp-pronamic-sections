<?php

function pronamic_tabs( $id = null ) {
    if ( ! $id )
        $id = get_the_ID();

    return get_post_meta( $id, 'pronamic_content_tabs', true );
}
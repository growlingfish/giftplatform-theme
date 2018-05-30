<?php

add_action( 'genesis_meta', 'remove_sidebar_from_object' );
function remove_sidebar_from_object () {
	remove_action( 'genesis_after_content', 'genesis_get_sidebar' );
	remove_action( 'genesis_after_content_sidebar_wrap', 'genesis_get_sidebar_alt');
}

//* Remove the default Genesis loop
remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_loop', 'gift_object_loop' );
function gift_object_loop () { 
	get_template_part( 'templates/single', 'object' );
}

//* Run the Genesis function
genesis();

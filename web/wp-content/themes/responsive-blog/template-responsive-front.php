<?php

/**
 * Template Name: Responsive Front Page
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

	get_header(); 

	get_template_part( 'template-parts/featured-area' );

	/*get_sidebar( 'home' );*/

	get_footer();

?>


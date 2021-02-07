<?php
/**
 * Site Front Page
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

// DP debugging feel free to delete this and the other part below.
// Questions? dan@phiffer.org
if ( ! empty( $_GET['dp-debug'] ) ) {
	define( 'SAVEQUERIES', true );
}

/**
 * Globalize Theme Options
 */
$responsive_options = responsive_get_options();
/**
 * If front page is set to display the
 * blog posts index, include home.php;
 * otherwise, display static front page
 * content
 */
if ( 'posts' == get_option( 'show_on_front' ) && $responsive_options['front_page'] != 1 )
{
	get_template_part( 'home' );
} 
elseif ( 'page' == get_option( 'show_on_front' ) && $responsive_options['front_page'] != 1 )
{
	$template = get_post_meta( get_option( 'page_on_front' ), '_wp_page_template', true );
	$template = ( $template == 'default' ) ? 'index.php' : $template;
	locate_template( $template, true );
}
else
{
	get_header();
	get_template_part( 'includes/custom-front-page' );
	get_footer('home'); // RM - this was the one
}

if ( ! empty( $_GET['dp-debug'] ) ) {
	usort( $wpdb->queries, function( $a, $b ) {
		return ( $a[1] < $b[1] ) ? 1 : -1;
	});
	$queries = print_r( $wpdb->queries, true );
	file_put_contents('/tmp/dp-debug.txt', $queries );
	echo "<!-- saved dp-debug.txt -->";
}

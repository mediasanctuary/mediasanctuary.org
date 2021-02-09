<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Loop Navigation Template-Part File
 *
 * @file           loop-nav.php
 * @package        Responsive
 * @author         Emil Uzelac
 * @copyright      2003 - 2014 CyberChimps
 * @license        license.txt
 * @version        Release: 1.1.0
 * @filesource     wp-content/themes/responsive/loop-nav.php
 * @link           http://codex.wordpress.org/Templates
 * @since          available since Release 1.0
 */

/**
 * Output Prev/Next Posts Links
 */
if ( $wp_query->max_num_pages > 1 ) :
	?>
	
	<div class="navigation">
		<div class="previous"><?php next_posts_link( __( '<img src="'.get_stylesheet_directory_uri().'/images/arrows_archive_prev.png" />', 'responsive' ) ); ?></div>
		<div class="next"><?php previous_posts_link( __( '<img src="'.get_stylesheet_directory_uri().'/images/arrows_archive_next.png" />', 'responsive' ) ); ?></div>
	</div><!-- end of .navigation -->

<?php
endif;
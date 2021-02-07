<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Loop Header Template-Part File
 *
 * @file           loop-header.php
 * @package        Responsive
 * @author         Emil Uzelac
 * @copyright      2003 - 2014 CyberChimps
 * @license        license.txt
 * @version        Release: 1.1.0
 * @filesource     wp-content/themes/responsive/loop-header.php
 * @link           http://codex.wordpress.org/Templates
 * @since          available since Release 1.0
 */

/**
 * Display breadcrumb
 */
// get_responsive_breadcrumb_lists(); RM 11-19-19 - function name changed in parent theme
responsive_get_breadcrumb_lists();

/**
 * Display archive information
 */
if ( is_category() || is_tag() || is_date() || is_tax() ) {
	
	// Replaced old code using new WP core functions
	the_archive_title( '<h1 class="title-archive">', '</h1>' ); 
	the_archive_description( '<div class="taxonomy-description">', '</div>' );
}
/*if (is_author())
{
	the_archive_title( '<h6 class="title-archive">', '</h6>' ); 
	 if ( get_the_author_meta( 'description' ) != '' ) : ?>
				<div class="single_post_author">
					<div class="author_title"> <?php echo __('ABOUT AUTHOR','responsive-blog'); ?> </div>
					<div class="row single_post_author_row">
						<div class="col-xs-12 col-md-3 col-lg-3">
							<?php if ( function_exists( 'get_avatar' ) ) { 
								 echo get_avatar( get_the_author_meta( 'email' ), '80' ); 
								} ?>
						</div>
						<div class="col-xs-12 col-md-9 col-lg-9">
							<?php the_author_meta('description'); ?>
						</div>
					</div>
				</div>
				<?php endif;  // no description, no author's meta 
}*/

/**
 * Display Search information
 */

if ( is_search() ) {
	?>
	<h6 class="title-search-results"><?php printf( __( 'Search results for: %s', 'responsive' ), '<span>' . get_search_query() . '</span>' ); ?></h6>
<?php
}

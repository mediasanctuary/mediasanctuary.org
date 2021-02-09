<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Post Data Template-Part File
 *
 * @file           post-data.php
 * @package        Responsive
 * @author         Emil Uzelac
 * @copyright      2003 - 2014 CyberChimps
 * @license        license.txt
 * @version        Release: 1.1.0
 * @filesource     wp-content/themes/responsive/post-data.php
 * @link           http://codex.wordpress.org/Templates
 * @since          available since Release 1.0
 */
?>

<?php if ( !is_page() && !is_search() ) { ?>

	<div class="post-data">
		<div class="responsive_blog_categories">
			
			<?php  // RM get 'Posted in' cats from all taxonomies
	$the_post_type = get_post_type( $post->ID );
	switch ($the_post_type) {
    case "image-galleries":
        $the_tax = 'image_gallery_categories';
        break;
    case "image-galleries":
        $the_tax = 'image_gallery_categories';
        break;
    case "event":
        $the_tax = 'event-categories';
        break;
    case "podcasts":
        $the_tax = 'podcast_categories';
        break;
    case "peoplepower":
        $the_tax = 'people_power_categories';
        break;
	case "post":
		$the_tax = 'category';
		break;
	default:
        $the_tax = 'category';
	}
	$the_term = get_the_term_list( $post->ID, $the_tax,'Posted in ', ', ' );  
	echo $the_term;
		
		//WAS: printf( __( 'Posted in LOVE %s', 'responsive' ), get_the_category_list( ', ' ) ); ?>
			
			
			
			
		</div>
		<div class="responsive_blog_tags">
			<?php the_tags( __( 'Tagged with:', 'responsive' ) . ' ', ', ', '<br />' ); ?>
		</div>
	</div><!-- end of .post-data -->

<?php } ?>

<div class="post-edit"><?php edit_post_link( __( 'Edit', 'responsive' ) ); ?></div>

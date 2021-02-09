<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Post Meta-Data Template-Part File
 *
 * @file           post-meta.php
 * @package        Responsive
 * @author         Emil Uzelac
 * @copyright      2003 - 2014 CyberChimps
 * @license        license.txt
 * @version        Release: 1.1.0
 * @filesource     wp-content/themes/responsive/post-meta.php
 * @link           http://codex.wordpress.org/Templates
 * @since          available since Release 1.0
 */
?>

<?php if ( is_single() ): ?>
	<h1 class="entry-title post-title"><?php the_title(); ?></h1>
<?php else: ?>
	<h3 class="entry-title post-title"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h3>
<?php endif; ?>

<div class="post-meta">
	<?php
	responsive_blog_post_meta_data(); ?>

	<?php if ( comments_open() ) : ?>
		<span class="comments-link">
		<i class="fa fa-comment" aria-hidden="true"></i>
			<?php comments_popup_link( __( 'No Comments', 'responsive' ), __( '1 Comment', 'responsive' ), __( '% Comments', 'responsive' ) ); ?>
		</span>
	<?php endif; 
	 ?>
</div><!-- end of .post-meta -->

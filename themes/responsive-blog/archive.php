<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Archive Template
 *
 *
 * @file           archive.php
 * @package        Responsive
 * @author         Emil Uzelac
 * @copyright      2003 - 2014 CyberChimps
 * @license        license.txt
 * @version        Release: 1.1
 * @filesource     wp-content/themes/responsive/archive.php
 * @link           http://codex.wordpress.org/Theme_Development#Archive_.28archive.php.29
 * @since          available since Release 1.0
 */

get_header(); ?>

<?php get_template_part( 'loop-header', get_post_type() ); ?>

<div id="content-archive" class="responsive_blog_archive_page <?php echo esc_attr( implode( ' ', responsive_get_content_classes() ) ); ?>">

<?php	if (is_author())
		{
			echo 'Posts by: <b>' . get_the_author(). '</b>'; 
			 if ( get_the_author_meta( 'description' ) != '' ) : ?>
						<div class="single_post_author">
							
							<div class="row single_post_author_row">
								<!-- div class="col-xs-12 col-md-3 col-lg-3">
									<?php if ( function_exists( 'get_avatar' ) ) { 
										 echo get_avatar( get_the_author_meta( 'email' ), '80' ); 
										} ?>
								</div -->
								<div class="col-xs-12 col-md-9 col-lg-9">
									<?php the_author_meta('description'); ?>
								</div>
							</div>
						</div>
						<?php endif;  // no description, no author's meta 
		}
?>
	<?php if ( have_posts() ) : ?>

		<?php while( have_posts() ) : the_post(); ?>

			<?php responsive_entry_before(); ?>
			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<?php responsive_entry_top(); ?>


<?php if ( has_post_thumbnail() ) : ?>
						<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
							<?php the_post_thumbnail(); ?>
						</a>
					<?php endif; ?>
					
					
					
					
			<div class="post-entry">
			 <div class="text_wrap_archive">
			
				<h3 class="entry-title post-title"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h3>
				<hr class="blog_excerpt_title_after"></hr>
				
				<?php $the_post_type = get_post_type( $post->ID );
	
				if ($the_post_type == 'post' || $the_post_type == 'podcasts') { //RM ?>
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
				<?php } ?>
				
					
					<?php the_excerpt(); ?>
					<?php wp_link_pages( array( 'before' => '<div class="pagination">' . __( 'Pages:', 'responsive' ), 'after' => '</div>' ) ); ?>
			      </div><!-- end of .text_wrap_archive	 -->
				</div><!-- end of .post-entry -->

				

				<?php responsive_entry_bottom(); ?>
			</div><!-- end of #post-<?php the_ID(); ?> -->
			<?php responsive_entry_after(); ?>

		<?php
		endwhile;

		get_template_part( 'loop-nav', get_post_type() );

	else :

		get_template_part( 'loop-no-posts', get_post_type() );

	endif;
	?>

</div><!-- end of #content-archive -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>

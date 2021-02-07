<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Archive Template for peoplepower cpt
 *
 *
 * @file           archive-peoplepower.php
 * @package        Responsive
 * @author         RM
 * @license        license.txt
 * @version        Release: 1.1
 * @filesource     wp-content/themes/responsive/archive.php

 */


get_header(); ?>

<?php get_template_part( 'loop-header', get_post_type() ); ?>

<div id="content-archive" class="responsive_blog_archive_page <?php echo esc_attr( implode( ' ', responsive_get_content_classes() ) ); ?>">

<?php	if (is_author())
		{
			
			 if ( get_the_author_meta( 'description' ) != '' ) : ?>
						<div class="single_post_author">
							
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
		}
?>
	<?php if ( have_posts() ) : ?>

		<?php while( have_posts() ) : the_post(); ?>

			<?php responsive_entry_before(); ?>
			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<?php responsive_entry_top(); ?>

					
			<div class="post-entry">
			 <div class="text_wrap_archive">
			 
			<?php if ( has_post_thumbnail() ) : ?>
						<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><div class="post-thumb-float" style="background-image: url(<?php echo the_post_thumbnail_url( 'medium' ); ?>);"></div></a>
					<?php endif; ?>
					
				<div class="pp_excerpt_title"><h3 class="entry-title post-title"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h3></div>
				
				<hr class="blog_excerpt_title_after"></hr>
				
				<div class="pp-post-meta">
					<?php
					/*responsive_blog_post_meta_data();*/
			$the_term = get_the_term_list( $post->ID, 'people_power_categories','',', ');  
			echo $the_term;?>

				</div><!-- end of .pp_post-meta -->

				
					
					<div class="pp_excerpt_txt"><?php the_excerpt(); ?></div>
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
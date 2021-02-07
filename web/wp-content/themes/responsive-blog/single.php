<?php

/**
 * Single Posts Template
 *
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

get_header(); ?>

<?php get_template_part( 'loop-header', get_post_type() ); ?>

<div id="responsive_blog_single_post">
	<div id="content" class="<?php echo esc_attr( implode( ' ', responsive_get_content_classes() ) ); ?>" role="main">

		<?php if ( have_posts() ) : ?>

			<?php while( have_posts() ) : the_post(); ?>

				<?php responsive_entry_before(); ?>
				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<?php responsive_entry_top(); ?>

					<h1 class="entry-title post-title"><?php the_title(); ?></h1>
					
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
					
				
					<?php // modify css if comments not open 
						if ( !(comments_open()) )
						{ ?>

								<style type="text/css">
									#responsive_blog_single_post .post-meta .single_post_time
									{	
										border-right:none;
									}
								</style>
					<?php	}
					?>

					<div class="post-entry">
						
						<div class="single_post_content">
						<?php the_content( sprintf( __( 'Continue reading%s', 'responsive-blog' ), '<span class="screen-reader-text meta-nav">  '.get_the_title().'</span>' ) ); ?>
						</div>

						<?php wp_link_pages( array( 'before' => '<div class="pagination">' . __( 'Pages:', 'responsive-blog' ), 'after' => '</div>' ) ); ?>

						<?php get_template_part( 'post-data', get_post_type() ); ?>
					</div><!-- end of .post-entry -->
					
					<div class="navigation">
						<?php $single_prev_post = get_previous_post();

								if(!empty($single_prev_post))
								{
									$prev_post_date = get_the_date( 'F - j - Y', $single_prev_post->ID ); ?>
									<div class="previous"><?php previous_post_link( '%link', '<img src="'.get_stylesheet_directory_uri().'/images/arrows_archive_prev.png" />' ); ?></div>
							<?php } ?>

						<?php $single_next_post = get_next_post();

								if(!empty($single_next_post) )
								{
									$next_post_date = get_the_date( 'F - j - Y', $single_next_post->ID ); ?>
									<div class="next"><?php next_post_link( '%link', '<img src="'.get_stylesheet_directory_uri().'/images/arrows_archive_next.png" />' ); ?></div>
							<?php } ?>
						
					</div><!-- end of .navigation -->

					<?php responsive_entry_bottom(); ?>
				</div><!-- end of #post-<?php the_ID(); ?> -->
				<?php responsive_entry_after(); ?>

				<?php if ( get_the_author_meta( 'description' ) != '' ) : ?>
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
				<?php endif;  // no description, no author's meta ?>

				<?php responsive_comments_before(); ?>
				<?php comments_template( '', true ); ?>
				<?php responsive_comments_after(); ?>

			<?php
			endwhile;

			get_template_part( 'loop-nav', get_post_type() );

		else :

			get_template_part( 'loop-no-posts', get_post_type() );

		endif;
		?>

	</div><!-- end of #content -->


<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>

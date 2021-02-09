<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Blog Excerpt Magazine Template
 *
Template Name: Blog Excerpt (Magazine layout)
 *
 */

get_header();
?>

<div id="content-blog" class="responsive_blog_magazine_excerpt_page">

	<?php get_template_part( 'loop-header', get_post_type() ); ?>

	<?php
	global $wp_query, $paged;
	if ( get_query_var( 'paged' ) ) {
		$paged = get_query_var( 'paged' );
	}elseif ( get_query_var( 'page' ) ) {
		$paged = get_query_var( 'page' );
	}
	else {
		$paged = 1;
	}
	$blog_query = new WP_Query( array( 'post_type' => 'post', 'paged' => $paged ) );
	$temp_query = $wp_query;
	$wp_query = null;
	$wp_query = $blog_query;


	 if ( $blog_query->have_posts() ) : ?>

		<div class="row" id="aspire_content">
			<div id="column_width" class="col-md-4"></div>
			<!-- Used by masonry to get column width -->
			<div id="gutter_width"></div>
			<!-- Used by masonry to get gutter width -->


<?php	while( $blog_query->have_posts() ) : $blog_query->the_post();
			?>
			
			<?php responsive_entry_before(); ?>		
			<?php
				if (has_post_thumbnail( $blog_query->ID ) )
				{
					$recent_post_img = wp_get_attachment_image_src( get_post_thumbnail_id( $blog_query->ID ), 'large');
				}
				$recent_post_link = get_permalink( $blog_query->ID );
				$recent_post_title = get_the_title( $blog_query->ID );
				$recent_post_excerpt = wp_trim_words(get_the_content($blog_query->ID), 20, '');
			?>	

			<div id="post-<?php the_ID(); ?>" <?php post_class('post_article col-md-4'); ?>>
				<?php responsive_entry_top(); ?>
					<?php if(!empty($recent_post_img))
						{ ?>
						<div class="row">
							<div class="col-lg-12 responsive_blog_magazine_img">
								<a href="<?php echo esc_url( $recent_post_link ); ?>">
									<img alt="<?php echo $recent_post_title; ?>" src="<?php echo $recent_post_img[0]; ?>" class="responsive_magazine_post_img"/>
								</a>
							</div>
						</div>
					<?php } ?>
					<div class="row">
						<div class="col-lg-12 responsive_blog_magazine_title">
							<h3 class="entry-title post-title"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h3>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-12 responsive_blog_magazine_date">
							<?php $recent_post_date = get_the_date( 'F - j - Y', $blog_query->ID );
							?>
							<span class="glyphicon glyphicon-calendar"></span>
							<span class="recent_date"><?php echo $recent_post_date; ?></span>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-12 responsive_blog_magazine_excerpt">
							<p class="magazine_excerpt"><?php echo $recent_post_excerpt; ?></p>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-12 responsive_blog_magazine_readmore">
							<a href="<?php echo esc_url( $recent_post_link ); ?>">
								<span class="magazine_read_more"> <?php echo __('READ MORE', 'responsive-blog'); ?> </span>
							</a>
						</div>
					</div>
				
				<?php responsive_entry_bottom(); ?>
			</div><!-- end of #post-<?php the_ID(); ?> -->
			<?php responsive_entry_after(); ?>

		<?php
		endwhile; ?>
		
		</div><!-- end of aspire_content -->

<?php
	else :

		get_template_part( 'loop-no-posts', get_post_type() );

	endif;
	$wp_query = $temp_query;
	wp_reset_postdata();
	?>

</div><!-- end of #content-blog -->

<?php get_footer(); ?>

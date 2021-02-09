<?php

/**
 * Footer Template
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}



/*
 * Globalize Theme options
 */
global $responsive_options;
$responsive_options = responsive_get_options();
?>
<?php responsive_wrapper_bottom(); // after wrapper content hook ?>

<?php // Closing container class for all pages except custom front page 
		if ( is_front_page())
		{ 
			$rb_body_class= get_body_class();
			if(in_array('front-page', $rb_body_class))
			{ ?>
				</div><!-- end of responsive_wrapper -->
	<?php	} else { ?>
					</div><!-- end of container -->
				</div><!-- end of responsive_wrapper -->
	<?php	}		
		?>
<?php	}
		else
		{ ?>
				</div><!-- end of container -->
			</div><!-- end of responsive_wrapper -->
<?php	} ?>
<?php responsive_wrapper_end(); // after wrapper hook ?>
</div><!-- end of #container -->
<?php responsive_container_end(); // after container hook ?>




<!-- UPCOMING EVENTS   // -->

	<?php
		$args = array(
                    'post_type' => 'event',
                    'tax_query' => array(
    					array(
        				'taxonomy'  => 'event-categories',
        				'field'     => 'slug',
        				'terms'     => 'ongoing', 
        				'operator'  => 'NOT IN')
							),
                    'post_status' => 'publish',
                    'posts_per_page' => 3,
                    'meta_key' => 'event_start_date',
                    'meta_query' => array(
                        array(
                            'key' => 'event_end_date', /* was event_start_date */
                            'value' => date('Y-m-d'),
                            'compare' => '>=', // compares the event_start_date against today's date so we only display events that haven't happened yet
                            'type' => 'DATE'
                            )
                        ),
                    'orderby' => 'meta_value',
                    'order' => 'ASC'
                );
	
		$temp = $wp_query;
        $wp_query = null;
        $wp_query = new WP_Query();
        $wp_query->query($args);
        $blog_query = $wp_query;
	/*$blog_query = new WP_Query( $args  );
	$temp_query = $wp_query;
	$wp_query = null;
	$wp_query = $blog_query;*/

	if ( $blog_query->have_posts() ) :
		$bg_color_class = 0; ?>
		
		
		<div id="upcoming_events"> 
 <div class="upcoming_events_inner">
 <div class="upcoming_events_title">Upcoming Events</div>
 	<?php 
		while( $blog_query->have_posts() ) : $blog_query->the_post();
			?>

			<?php responsive_entry_before(); ?>
			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<?php responsive_entry_top(); ?>

				
				<div class="post-entry bg_<?php echo $bg_color_class ?>">
					<?php if ( has_post_thumbnail() ) : ?>
						<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
							<div class="post-thumb-float-sq" style="background-image: url(<?php echo the_post_thumbnail_url( ); ?>);"></div>
						</a>
					<?php else : ?>
							<div class="post-thumb-float-sq">
								<a href="<?php the_permalink(); ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/logo_ms_240x160.png" /></a></div>
							<?php endif; ?>

					<?php the_excerpt(); ?>
					<?php wp_link_pages( array( 'before' => '<div class="pagination">' . __( 'Pages:', 'responsive' ), 'after' => '</div>' ) ); ?>
				</div><!-- end of .post-entry -->

				<?php responsive_entry_bottom(); ?>
			</div><!-- end of #post-<?php the_ID(); ?> -->
			<?php responsive_entry_after(); ?>

		<?php
		$bg_color_class ++;
		endwhile; ?>
		<!-- end of #content-blog -->
<div class="upcoming_events_full_cal"><a href="events">See the Full Calendar</a></div>
 </div>
</div>
 <?php
	else : ?>
		
		<div style="height: 2px; background-color: #FFF;"> </div>
	<?php
	endif;
	$wp_query = $blog_query;
	wp_reset_postdata();
	?>
<!-- end upcoming events -->



	<div class="responsive_blog_colophon">
		<div class="container">
			<div class="row">
				<?php get_sidebar( 'colophon' ); ?>
			</div>
		</div>
	</div></div>
<div id="responsive_blog_footer" class="clearfix" role="contentinfo">
	<?php responsive_footer_top(); ?>

	<div id="responsive_blog_footer-wrapper" class="container">
	
		<?php get_sidebar( 'footer' ); ?>

	</div><!-- end #footer-wrapper -->

	<div class="responsive_blog_footer_menu_icons">
		<div class="container">
			<div class="row">

				
				<!--<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 responsive_blog_footer_extra_menu">
					<?php if ( has_nav_menu( 'footer-menu', 'responsive' ) ) {
						wp_nav_menu( array(
							'container'      => '',
							'fallback_cb'    => false,
							'menu_class'     => 'footer-menu',
							'theme_location' => 'footer-menu'
						) );
					 } ?>
				</div> end of col-540 -->

				<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 responsive_blog_copyright">
					<div class="copyright">
							<?php esc_attr_e( '&copy;', 'responsive-blog' ); ?> <?php echo date( 'Y' ); ?><a id="copyright_link" href="<?php echo esc_url( home_url( '/' ) ) ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
								<?php bloginfo( 'name' ); ?>
							</a><br />
3361 6th Avenue in North Troy, New York <br />
P.O. Box 35 Troy, NY 12181<br />
(518) 272-2390 
					</div><!-- end of .copyright -->
				</div>

				<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 responsive_blog_footer_extra_icons">
					<?php echo responsive_blog_get_social_icons() ?>
				</div><!-- end of col-380 fit -->

			</div> <!-- end of row -->
		</div><!-- end of container-->
	</div>
	
	<?php /* colophon was here - RM*/ ?>	
	

	<?php responsive_footer_bottom(); ?>
</div><!-- end #footer -->
<?php responsive_footer_after(); ?>
<div id="scroll-to-top"><span class="glyphicon glyphicon-chevron-up"></span></div>

<?php wp_footer(); ?>
</body>
</html>
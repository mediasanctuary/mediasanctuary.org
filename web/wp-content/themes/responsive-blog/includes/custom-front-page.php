<?php

get_header(); 

	$responsive_options = responsive_get_options();
	//test for first install no database
	$db = get_option( 'responsive_theme_options' );
	
	// check all sections
	$responsive_blog_slider_section = $db['responsive_blog_slider_section'];
	$responsive_blog_callout_section = $db['responsive_blog_callout_section'];
	$responsive_blog_features_section = $db['responsive_blog_features_section'];
	$responsive_blog_gallery_section = $db['responsive_blog_gallery_section'];
	$responsive_blog_testimonial_section = $db['responsive_blog_testimonial_section'];
	$responsive_blog_recent_post_section = $db['responsive_blog_recent_post_section'];
	$responsive_blog_upcoming_events_section = $db['responsive_blog_upcoming_events_section']; //RM
	
if($responsive_blog_slider_section != 1)
{
	// Slider section  ?>
	<div class="home full_slider">
		<?php do_action('responsive_blog_page_slider');  ?>
	</div>
<?php } ?>

<!-- =================== Callout section =====================  -->

<?php
if($responsive_blog_callout_section != 1)
{
		if(isset( $responsive_options['responsive_blog_callout_text'] ))
		{
			$callout_text = $responsive_options['responsive_blog_callout_text'];
		}
		if(isset( $responsive_options['responsive_blog_callout_link'] ))
		{
			$callout_link = $responsive_options['responsive_blog_callout_link'];
		}

		//test if all options are empty so we can display default text if they are
		$emtpy_responsive_blog_callout_text = ( empty( $responsive_options['responsive_blog_callout_text'] ) ) ? false : true;
		//$empty_responsive_blog_callout_link = ( empty( $responsive_options['responsive_blog_callout_link'] ) ) ? false : true;
?>
<section id="callout" class="home-page-section">
	<div class="section-top">
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9 callout-text">
					<span>
						<?php 	echo $responsive_options['responsive_blog_callout_text'];
						?>
					</span>
				</div>
				<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 callout-button">
					<a id="callout-read-more" href="<?php if(isset ($responsive_options['responsive_blog_callout_link'])) 
						{ echo $callout_link; } ?>"><?php echo __('Read More', 'responsive-blog'); ?></a>
				</div>
			</div>
		</div>
	</div>
	
</section>
<?php } // end of section enable check ?>


<!-- =================== Upcoming events section (Front page) =====================  -->

<!-- UPCOMING EVENTS   // -->

	<?php
	
	if($responsive_blog_upcoming_events_section != 1) { //RM
		$upcoming_args = array(
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
        $wp_query->query($upcoming_args);
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

		<div> </div>
	<?php 
	endif;
	$wp_query = $blog_query;
	wp_reset_postdata();
	}
	?>

<!-- end upcoming events -->

<!-- =================== frontpage-middle section =====================  -->
 <!-- Frontpage Middle   // -->
<div id="frontpage-middle_wrapper"> 
 <div class="frontpage-middle_inner">
 
<?php get_sidebar( 'frontpage-middle' ); ?>

 </div>
</div>

<!-- =================== Featured Category section =====================  -->

<?php
if($responsive_blog_features_section != 1)
{
	if(isset( $responsive_options['responsive_blog_features_title'] ))
	{
		$responsive_blog_features_title = $responsive_options['responsive_blog_features_title'];
	}
	if(isset( $responsive_options['responsive_blog_features_desc'] ))
	{
		$responsive_blog_features_desc = $responsive_options['responsive_blog_features_desc'];
	}
?>
<section id="features" class="home-page-section">
	<div class="section-top">
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 os-animation" data-os-animation="fadeInDown" data-os-animation-delay="0s">
					<span id="features-title" class="home-template-titles">News
						<?php 	/* RM 12-19-19echo $responsive_options['responsive_blog_features_title'];
						*/?>
					</span>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="features-desc">
					<span> 
						<?php 	/* RM 12-19-19 echo $responsive_options['responsive_blog_features_desc']*/;
						?>
					</span>
				</div>
			</div>
		</div>
	</div>
	<div class="section-bottom">
		<div class="container">
			<div class="row">
				<?php do_action('responsive_blog_section_features'); ?>
			</div>
		</div>
	</div>
</section>
<?php } // end of section enable check ?>

<!-- =================== Testimonial section =====================  -->

<?php /* RM 12-19-19
if($responsive_blog_testimonial_section != 1)
{

	if(isset( $responsive_options['responsive_blog_testimonial_title'] ))
	{
		$responsive_blog_testimonial_title = $responsive_options['responsive_blog_testimonial_title'];
	}
?>
<section id="testimonial" class="home-page-section">
	<div class="section-top">
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 os-animation" data-os-animation="fadeInDown" data-os-animation-delay="0s">
					<span id="testimonial-title" class="home-template-titles"> 
						<?php 	echo $responsive_options['responsive_blog_testimonial_title'];
						?>
					</span>
				</div>
			</div>
		</div>
	</div>
	<div class="section-bottom">
		<div class="container">
			
				<?php do_action('responsive_blog_section_testimonial'); ?>
			
		</div>
	</div>
</section>
<?php } // end of section enable check */ ?>

<!-- =================== Recent Post section =====================  -->
<?php /* RM 12-19-19
if($responsive_blog_recent_post_section != 1)
{

	if(isset( $responsive_options['responsive_blog_recent_post_title'] ))
	{
		$responsive_blog_recent_post_title = $responsive_options['responsive_blog_recent_post_title'];
	}
?>
<section id="recent_post" class="home-page-section">
	<div class="section-top">
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 os-animation" data-os-animation="fadeInDown" data-os-animation-delay="0s">
					<span id="recent-post-title" class="home-template-titles"> 
						<?php 	echo $responsive_options['responsive_blog_recent_post_title'];
						?>
					</span>
				</div>
			</div>
		</div>
	</div>
	<div class="section-bottom">
		<div class="container">		
				<?php do_action('responsive_blog_section_recent_post'); ?>
		</div>
	</div>
</section>
<?php } // end of section enable check */ ?>


<?php get_footer('home'); // RM ?>
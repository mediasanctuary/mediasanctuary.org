<?php
/*
*
* Template Functions File
*
*/


/*======================== Podcast posts ======================================*/

add_action("mini_homepage_podcasts_posts", "mini_homepage_podcasts",10,2);

function mini_homepage_podcasts($mhp_tag_id, $mhp_tag_name) { 
	if ($mhp_tag_name == 'WOOC 105.3 FM') {
		$mini_hp_args_pp = array(
                    'post_type' => 'podcasts',
                    'post_status' => 'publish',
                    'posts_per_page' => 3,
                    /*'tag_id' => $mhp_tag_id,*/
                    'orderby' => 'post_date',
                    'order' => 'DESC'
                );
	
		$mhp_temp = $wp_query;
        $wp_query = null;
        $wp_query = new WP_Query();
        $wp_query->query($mini_hp_args_pp);
        $mhp_blog_query_pp = $wp_query;
        
	 if ( $mhp_blog_query_pp->have_posts() ) : ?>
<div class="mhp_section_wrap mhp_podcasts"> 
 <div class="mhp_section_inner">
 <div class="mhp_section_title"><?php /*echo $mhp_tag_name;*/ ?>WOOC FM: Podcasts</div>

	<?php 
		while( $mhp_blog_query_pp->have_posts() ) : $mhp_blog_query_pp->the_post();
			?>

			<?php responsive_entry_before(); ?>
			<div id="post-<?php the_ID(); ?>" <?php post_class('mhp_post'); ?>>
				<?php responsive_entry_top(); ?>
				<div class="post-entry">
					<?php if ( has_post_thumbnail() ) : ?>
						<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
							<div class="post-thumb-float-sq" style="background-image: url(<?php echo the_post_thumbnail_url( ); ?>);"></div>
						</a>
					<?php else : ?>
							<div class="post-thumb-float-sq">
								<a href="<?php the_permalink(); ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/logo_ms_240x160.png" /></a></div>
							<?php endif; ?>
					<div class="text_wrap">
					
					<h4 class="entry-title post-title"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h4>
					<div class="nhp_excerpt_txt"><?php the_excerpt(); ?></div>
					<?php wp_link_pages( array( 'before' => '<div class="pagination">' . __( 'Pages:', 'responsive' ), 'after' => '</div>' ) ); ?>
					</div><!-- end of .text_wrap -->
				</div><!-- end of .post-entry -->

				<?php responsive_entry_bottom(); ?>
			</div><!-- end of #post-<?php the_ID(); ?> -->
			<?php responsive_entry_after(); ?>

		<?php
		endwhile; ?>
		
		<div class="upcoming_events_full_cal"><a href="<?php echo site_url()  ?>/podcasts">More podcasts</a></div>
	 </div>
	</div>
	<?php else : ?>
	   <div> </div>
	<?php endif;
	$wp_query = $mhp_blog_query_pp;
	wp_reset_postdata(); 
 // END this Section --------
 }
}
/*======================== Tagged Events ======================================*/

add_action("mini_homepage_events_posts", "mini_homepage_events",10,3);

function mini_homepage_events($mhp_tag_id, $mhp_tag_name,$count) {  
		$event_args = array(
                    'post_type' => 'event',
                    'tax_query' => array(
    					array(
        				'taxonomy'  => 'event-categories',
        				'field'     => 'slug',
        				'terms'     => 'ongoing', 
        				'operator'  => 'NOT IN')
							),
                    'post_status' => 'publish',
                    'posts_per_page' => $count,
                    'meta_key' => '_event_start_date', /* was _event_start_date */
                    'meta_query' => array(
                        array(
                            'key' => '_event_end_date', /* was _event_start_date */
                            'value' => date('Y-m-d'),
                            'compare' => '>=', // compares the event_start_date against today's date so we only display events that haven't happened yet
                            'type' => 'DATE'
                            )
                        ),
                    'tag_id' => $mhp_tag_id,
                    'orderby' => 'meta_value',
                    'order' => 'ASC'
                );
	
		$temp = $wp_query;
        $wp_query = null;
        $wp_query = new WP_Query();
        $wp_query->query($event_args);
        $blog_query = $wp_query;
	/*$blog_query = new WP_Query( $args  );
	$temp_query = $wp_query;
	$wp_query = null;
	$wp_query = $blog_query;*/

	if ( $blog_query->have_posts() ) : 
	$bg_color_class = 0;
	?>
<!-- UPCOMING Initiative EVENTS   // -->
<div id="upcoming_events"> 
 <div class="upcoming_events_inner">
 <div class="upcoming_events_title"><?php echo $mhp_tag_name; ?>: Upcoming Events</div>
	<?php
		while( $blog_query->have_posts() ) : $blog_query->the_post();
			?>

			<?php responsive_entry_before(); ?>
			<div id="post-<?php the_ID(); ?>" <?php post_class('post_class'); ?>>
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
			<?php responsive_entry_after();  
 		$bg_color_class ++;
		endwhile; ?>
		<!-- end of #content-blog -->
		<div class="upcoming_events_full_cal"><a href="<?php echo site_url() ?>/events">See More Events</a></div>
 		</div>
	  </div><!-- end upcoming events -->

		<?php else : ?>
	   <div> </div>
	<?php endif;
	$wp_query = $blog_query;
	wp_reset_postdata();
 }


/*======================== People power profiles ======================================*/

add_action("mini_homepage_people_profile_posts", "mini_homepage_people_profiles",10,2);

function mini_homepage_people_profiles($mhp_tag_id, $mhp_tag_name) { 
		$paged1 = isset( $_GET['paged1'] ) ? (int) $_GET['paged1'] : 1;
		$mini_hp_args_pp = array(
                    'post_type' => 'peoplepower',
                    'post_status' => 'publish',
                    'posts_per_page' => 3,
                    'tag_id' => $mhp_tag_id,
                    'orderby' => 'post_date',
                    'order' => 'DESC',
                    'offset' => 0,
                    'paged' => $paged1,
                    'suppress_filters' => true
                );
		
		$previous_post = get_posts($args);
		
		$mhp_temp = $wp_query;
        $wp_query = null;
        $wp_query = new WP_Query();
        $wp_query->query($mini_hp_args_pp);
        $mhp_blog_query_pp = $wp_query;
        
	 if ( $mhp_blog_query_pp->have_posts() ) : ?>
<div class="mhp_section_wrap mhp_people"> 
 <div class="mhp_section_inner">
 <div class="mhp_section_title"><?php echo $mhp_tag_name; ?>: People</div>

	<?php 
		while( $mhp_blog_query_pp->have_posts() ) : $mhp_blog_query_pp->the_post();
			?>

			<?php responsive_entry_before(); ?>
			<div id="post-<?php the_ID(); ?>" <?php post_class('mhp_post'); ?>>
				<?php responsive_entry_top(); ?>
				<div class="post-entry">
					<?php if ( has_post_thumbnail() ) : ?>
						<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
							<div class="post-thumb-float-sq" style="background-image: url('<?php echo the_post_thumbnail_url( ); ?>');"></div>
						</a>
					<?php else : ?>
							<div class="post-thumb-float-sq">
								<a href="<?php the_permalink(); ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/logo_ms_240x160.png" /></a></div>
							<?php endif; ?>
					<div class="text_wrap">
					
					<h4 class="entry-title post-title"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h4>
					<div class="nhp_excerpt_txt"><?php the_excerpt(); ?></div>
					<?php wp_link_pages( array( 'before' => '<div class="pagination">' . __( 'Pages:', 'responsive' ), 'after' => '</div>' ) ); ?>
					</div><!-- end of .text_wrap -->
				</div><!-- end of .post-entry -->

				<?php responsive_entry_bottom(); ?>
			</div><!-- end of #post-<?php the_ID(); ?> -->
			<?php responsive_entry_after(); ?>

		<?php
		
		
			$pag_args1 = array(
    'format'   => '?paged1=%#%',
    'current'  => $paged1,
    'total'    => $previous_post->max_num_pages,
    'add_args' => array( 'paged1' => $paged1 )
);
echo paginate_links( $pag_args1 );
		endwhile; 
		
		
		
		
		
		?>
		
		<div class="upcoming_events_full_cal"><a href="<?php echo site_url()  ?>/peoplepower">More people</a></div>
	 </div>
	</div>
	<?php else : ?>
	   <div> </div>
	<?php endif;
	$wp_query = $mhp_blog_query_pp;
	wp_reset_postdata(); 
 // END this Section --------
 }
 


/*======================== Tagged News ======================================*/

add_action("mini_homepage_news_posts", "mini_homepage_news",10,2);

function mini_homepage_news($mhp_tag_id, $mhp_tag_name)  { 

		$mini_hp_args_pp = array(
                    'post_type' => 'post',
                    'category_name' => 'news',
                    'post_status' => 'publish',
                    'posts_per_page' => 3,
                    'tag_id' => $mhp_tag_id,
                    'orderby' => 'post_date',
                    'order' => 'DESC'
                );
	
		$mhp_temp = $wp_query;
        $wp_query = null;
        $wp_query = new WP_Query();
        $wp_query->query($mini_hp_args_pp);
        $mhp_blog_query_pp = $wp_query;
        
	 if ( $mhp_blog_query_pp->have_posts() ) : ?>
<div class="mhp_section_wrap mhp_news"> 
 <div class="mhp_section_inner">
 <div class="mhp_section_title"><?php echo $mhp_tag_name; ?>: News</div>

	<?php //do_action('excerpt_more');  
		while( $mhp_blog_query_pp->have_posts() ) : $mhp_blog_query_pp->the_post();
			?>

			<?php responsive_entry_before(); ?>
			<div id="post-<?php the_ID(); ?>" <?php post_class('mhp_post'); ?>>
				<?php responsive_entry_top(); ?>
				<div class="post-entry">
					<?php if ( has_post_thumbnail() ) : ?>
						<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
							<div class="post-thumb-float-sq" style="background-image: url(<?php echo the_post_thumbnail_url( ); ?>);"></div>
						</a>
						<?php else : ?>
							<div class="post-thumb-float-sq">
								<a href="<?php the_permalink(); ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/logo_ms_240x160.png" /></a></div>
							<?php endif; ?>
					<div class="text_wrap">
					<?php the_date('n.j.Y', '<b>', '</b>'); ?>
					<div class="entry-title post-title mhp_news"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></div>
					<div class="moretag_wrap"><a href="<?php the_permalink() ?>"><img class="read-more-arrow" src="<?php echo get_stylesheet_directory_uri(); ?>/images/readmore.png" /></a></div>
					</div><!-- end of .text_wrap -->
				</div><!-- end of .post-entry -->

				<?php responsive_entry_bottom(); ?>
			</div><!-- end of #post-<?php the_ID(); ?> -->
			<?php responsive_entry_after(); ?>

		<?php
		endwhile; ?>
		
		<div class="upcoming_events_full_cal"><a href="<?php echo site_url() ?>/news">More News</a></div>
	 </div>
	</div>
	<?php else : ?>
	   <div> </div>
	<?php endif;
	$wp_query = $mhp_blog_query_pp;
	wp_reset_postdata(); 
 // END this Section --------
 }




/*======================== Tagged Projects ======================================*/

add_action("mini_homepage_projects_posts", "mini_homepage_projects",10,2);

function mini_homepage_projects($mhp_tag_id, $mhp_tag_name)  { 

		$mini_hp_args_projects = array(
                    'post_type' => 'post',
                    'category_name' => 'projects',
                    'post_status' => 'publish',
                    'posts_per_page' => 3,
                    'tag_id' => $mhp_tag_id,
                    'orderby' => 'title',
                    'order' => 'ASC'
                );
	
		$mhp_temp = $wp_query;
        $wp_query = null;
        $wp_query = new WP_Query();
        $wp_query->query($mini_hp_args_projects);
        $mhp_blog_query_projects = $wp_query;
        
	 if ( $mhp_blog_query_projects->have_posts() ) : ?>
<div class="mhp_section_wrap mhp_projects"> 
 <div class="mhp_section_inner">
 <div class="mhp_section_title"><?php echo $mhp_tag_name; ?>: Projects</div>

	<?php //do_action('excerpt_more');  
		while(  $mhp_blog_query_projects->have_posts() ) :  $mhp_blog_query_projects->the_post();
			?>

			<?php responsive_entry_before(); ?>
			<div id="post-<?php the_ID(); ?>" <?php post_class('mhp_post'); ?>>
				<?php responsive_entry_top(); ?>
				<div class="post-entry">
					<?php if ( has_post_thumbnail() ) : ?>
						<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
							<div class="post-thumb-float-sq" style="background-image: url(<?php echo the_post_thumbnail_url( ); ?>);"></div>
						</a>
						<?php else : ?>
							<div class="post-thumb-float-sq">
								<a href="<?php the_permalink(); ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/logo_ms_240x160.png" /></a></div>
							<?php endif; ?>
					<div class="text_wrap">
					  <div class="entry-title post-title mhp_news"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></div>
					  <div class="nhp_excerpt_txt"><?php the_excerpt(); ?></div>
					</div><!-- end of .text_wrap -->
				</div><!-- end of .post-entry -->

				<?php responsive_entry_bottom(); ?>
			</div><!-- end of #post-<?php the_ID(); ?> -->
			<?php responsive_entry_after(); ?>

		<?php
		endwhile; ?>
		
		<div class="upcoming_events_full_cal"><a href="<?php echo site_url() ?>/projects">More Projects</a></div>
	 </div>
	</div>
	<?php else : ?>
	   <div> </div>
	<?php endif;
	$wp_query =  $mhp_blog_query_projects;
	wp_reset_postdata(); 
 // END this Section --------
 }



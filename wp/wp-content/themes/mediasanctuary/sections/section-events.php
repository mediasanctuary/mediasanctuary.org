<section id="events" class="posts p60">
	<div class="container">
		<h2>Upcoming Events</h2>
		<p>We aren’t physically gathering at the Sanctuary for most events – but that doesn’t mean our programming has stopped! Check out our <a href="/events/">full schedule</a> of upcoming events.</p>
				
		<ul class="posts__list three-col">

  		<?php
        $args = array(
          'posts_per_page' => 3,
          'post_type' => 'tribe_events'
        );
        $queryLatest = new WP_Query($args);
        if ($queryLatest->have_posts()) :
            $i = 0;
            while ($queryLatest->have_posts()) : $queryLatest->the_post();

          	$thumb_url = get_asset_url('img/default.jpg');
          	if ( has_post_thumbnail() ) {
          		$thumb_id = get_post_thumbnail_id();
          		$thumb_url_array = wp_get_attachment_image_src($thumb_id, 'full', true);
          		$thumb_url = $thumb_url_array[0];
          	}
            
            ?>
            
      			<li class="col">			
              <a href="<?php the_permalink();?>" class="posts__item">
      					<span class="posts__date"><?php the_time('F d, Y');?></span>
                  <span class="post__thumbnail" style="background-image:url(<?php echo $thumb_url; ?>)">
      						<strong>Learn More</strong>
      					</span>												
                <h5><?php the_title();?></h5>
      				</a>
      			</li>

            <?php endwhile;
        endif;
        wp_reset_query();
  		?>

		</ul>
		
		
	</div>
</section>
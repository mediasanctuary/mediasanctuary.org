<section id="events" class="posts p60">
	<div class="container">
	<?php
		$events = get_field('events_section');
		if ($radio) {
			echo '<h2>'.$events['heading'].'</h2>';
			echo $events['description'];
		} else {
			echo '<h2>Upcoming Events</h2>';
			echo '<p>We aren&rsquo;t physically gathering at the Sanctuary for most events – but that doesn&rsquo;t mean our programming has stopped! Check out our <a href="/events/">full schedule</a> of upcoming events.</p>';
		}
	?>

		<ul class="posts__list three-col">
	  <?php
		global $post;
		$events = tribe_get_events([
			'ends_after' => 'now'
		]);

		if (count($events) > 3) {
			$events = array_slice($events, 0, 3);
		}
		foreach ( $events as $post ) {
			setup_postdata( $post );
			if ( get_post_meta($post->ID, '_tribe_events_status', true ) == 'canceled' ) {
				continue;
			}

			$thumb_url = get_asset_url('img/default.jpg');
			if ( has_post_thumbnail() ) {
				$thumb_id = get_post_thumbnail_id();
				$thumb_url_array = wp_get_attachment_image_src($thumb_id, 'full', true);
				$thumb_url = $thumb_url_array[0];
			}
			?>

			<li class="col">
				<a href="<?php echo esc_url(get_permalink());?>" class="posts__item">
					<span class="posts__date"><?php echo tribe_get_start_date( $post );?></span>
					<span class="post__thumbnail" style="background-image:url(<?php echo $thumb_url; ?>)">
						<strong>Learn More</strong>
					</span>
					<h5><?php echo $post->post_title;?></h5>
				</a>
			</li>

	  <?php }  ?>
		</ul>

	</div>
</section>

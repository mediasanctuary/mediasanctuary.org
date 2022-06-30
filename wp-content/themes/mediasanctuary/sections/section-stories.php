<section id="stories" class="posts p60">
	<div class="container">
		<?php

		$stories = get_field('stories_section');
		if ($stories) {
			echo '<h2>'.$stories['heading'].'</h2>';
			echo '<div class="intro">'.$stories['description'].'</div>';
		} else {
			echo '<h2>Recent Stories</h2>';
			echo '<div class="intro"><p>Among our major commitments is to provide a platform for community journalism, with an emphasis on storytelling along the intersections of art, science and media.  Here are our most recent multimedia productions.  You can find complete archives and more information at our Sanctuary Radio and Sanctuary TV initiatives.</p></div>';
		}
		?>

		<ul class="four-col">
			<?php

			// We cannot query the posts for everything with the 'stories'
			// category while also preserving sticky posts. So the approach
			// here is to query for more posts than we need (the most recent
			// 30) and then check that they are stories. We get sticky posts
			// by virtue of this being a standard query and not a "category
			// query." (dphiffer/2022-06-30)

			global $post;

			$args = array(
				'posts_per_page' => 30
			);
			$queryLatest = new WP_Query($args);
			if ($queryLatest->have_posts()) {
				$i = 0;
				while ($queryLatest->have_posts()) {
					$queryLatest->the_post();
					if (! is_story_post($post)) {
						continue;
					}
					$data = array(
						'number' => $i
					);
					get_template_part( 'partials/post', 'none', $data);
					$i++;
					if ($i == 8) {
						break;
					}
				}
			}
			wp_reset_query();
			?>
		</ul>
		<p class="text-center"><a href="<?php echo home_url('/stories/'); ?>" class="btn">View all stories</a></p>
		<?php include get_template_directory() . '/sections/section-wooc.php';?>
	</div>
</section>

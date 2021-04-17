<section id="stories" class="posts p60">
	<div class="container">
		<h2>Recent Stories</h2>
		<?php

		if (function_exists('get_field')) {
			the_field('category_description', 'category_1');
		}

		?>
		<ul class="four-col">

  		<?php
        $args = array(
          'posts_per_page' => 8,
          'category_name' => 'stories'
        );
        $queryLatest = new WP_Query($args);
        if ($queryLatest->have_posts()) :
            $i = 0;
            while ($queryLatest->have_posts()) : $queryLatest->the_post();
              get_template_part( 'partials/post', 'none' );
            endwhile;
        endif;
        wp_reset_query();
  		?>

		</ul>
		<a href="<?php echo home_url('/stories/'); ?>">View all stories</a>
	</div>
</section>

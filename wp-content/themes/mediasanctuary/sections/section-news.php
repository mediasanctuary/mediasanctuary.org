<section id="news" class="posts p60">
	<div class="container">
		<h2>Sanctuary News</h2>
		<?php

		if (function_exists('get_field')) {
			$news_cat = get_term_by('name', 'Sanctuary News', 'category');
			the_field('category_description', 'category_' . $news_cat->term_id);
		}

		?>
		<ul class="posts__list three-col">

  		<?php
        $args = array(
          'posts_per_page' => 3,
          'category_name' => 'sanctuary-news'
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
	</div>
</section>

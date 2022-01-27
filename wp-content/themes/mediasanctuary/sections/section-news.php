<section id="news" class="posts p60">
	<div class="container">
		<?php
			$news = get_field('news_section');
			if ($news) {
				echo '<h2>'.$news['heading'].'</h2>';
				echo $news['description'];
			} else {
				echo '<h2>Sanctuary News</h2>';
				echo '<p>The latest happenings at The Sanctuary for Independent Media. You can also view the <a href="/sanctuary-news/">archive</a> or listen to WOOC 105.3 FM Troy for more updates.</p>';
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

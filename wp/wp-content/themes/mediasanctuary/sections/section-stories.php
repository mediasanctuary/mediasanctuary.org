<section id="stories" class="posts p60">
	<div class="container">
		<h2>Recent Stories</h2>
		<p class="intro">Much of the coverage from <a href="/stories/">Hudson Mohawk Magazine</a> that airs on WOOC 105.3 can also be found on our site. </p>

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
		<p class="text-center"><a href="<?php echo home_url('/stories/'); ?>" class="btn">View all stories</a></p>
	</div>
</section>

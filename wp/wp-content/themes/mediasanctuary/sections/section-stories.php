<section id="stories" class="posts p60">
	<div class="container">
		<h2>Recent Stories</h2>
		<?php
  		if (function_exists('get_field')) {
  			echo '<div class="intro">'.get_field('category_description', 'category_1').'</div>';
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
              $data = array(
                'number' => $i
              );
              get_template_part( 'partials/post', 'none', $data);
              $i++;
            endwhile;
        endif;
        wp_reset_query();
  		?>

		</ul>
		<p class="text-center"><a href="<?php echo home_url('/stories/'); ?>" class="btn">View all stories</a></p>
		
		<?php include get_template_directory() . '/sections/section-wooc.php';?>
	</div>
</section>

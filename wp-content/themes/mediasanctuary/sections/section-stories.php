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

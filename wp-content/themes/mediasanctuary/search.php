<?php get_header(); ?>

<section class="search p40">
	<div class="container">
  	<h1>Search Results</h1>
  	<h4 class="text-center">&ldquo;<?php echo($s); ?>&rdquo;</h4>
		<?php
        if (have_posts()) {
					echo '<ul class="four-col">';
            while (have_posts()) {
							the_post();
              get_template_part( 'partials/post', 'none' );
            }

						echo '</ul>';
            the_posts_pagination();
						echo '</div>';
        } else {
					echo "Sorry, no stories were found.";
				}
  		?>	</div>
</section>

<?php get_footer(); ?>
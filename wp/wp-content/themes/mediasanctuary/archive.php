<?php

get_header();

?>
<section id="stories" class="posts p60">
	<div class="container">
		<h2><?php the_archive_title(); ?></h2>
		<?php
        if (have_posts()) {
					echo '<ul class="four-col">';
            while (have_posts()) {
							the_post();
              get_template_part( 'partials/post', 'none' );
            }

						echo '</ul>';
						$prev = get_previous_posts_link('Previous page');
						$next = get_next_posts_link('Next page');
						$separator = (! empty($prev) && ! empty($next)) ? ' | ' : '';
						echo '<div class="pagination">';
						echo $prev . $separator . $next;
						echo '</div>';
        } else {
					echo "Sorry, no stories were found.";
				}
        wp_reset_query();
  		?>

		</ul>
	</div>
</section>
<?php

get_footer();

<?php

get_header();

?>
<section id="stories" class="posts p60">
	<div class="container">
		<h2><?php the_archive_title(); ?></h2>
		<?php

		if (function_exists('get_field')) {
			if (is_category()) {
				$term = get_queried_object();
				echo '<div class="intro">';
				the_field('category_description', "category_$term->term_id" );
				echo '</div>';
			}
		}

		if ($wp_query->get('post_type') == 'peoplepower') {
			get_template_part( 'partials/peoplepower', 'controls' );
		}

		?>
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
        wp_reset_query();
  		?>

		</ul>
	</div>
</section>
<?php

get_footer();

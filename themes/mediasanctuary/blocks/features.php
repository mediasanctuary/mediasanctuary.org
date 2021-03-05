<div class="block-features">
	<div class="container">
		<?php while ( have_rows('features') ) { ?>
			<?php the_row(); ?>
			<div class="feature">
				<?php

				$image_id = get_sub_field('image');
				echo wp_get_attachment_image($image_id, 'large');

				?>
				<h2 class="feature__title"><?php the_sub_field('title'); ?></h2>
				<a href="<?php the_sub_field('button_url'); ?>">
					<?php the_sub_field('button_label'); ?>
				</a>
			</div>
		<?php } ?>
	</div>
</div>

<div class="block-features">
	<div class="container">
		<?php $class = 'block-features__item block-features__item--large'; ?>
		<ol class="block-features__list">
			<?php while ( have_rows('features') ) { ?>
				<?php the_row(); ?>
				<li class="<?php echo $class; ?>">
					<h2 class="block-features__title"><?php the_sub_field('title'); ?></h2>
					<a href="<?php the_sub_field('button_url'); ?>" class="button">
						<?php the_sub_field('button_label'); ?>
					</a>
					<?php

					$image_id = get_sub_field('image');
					echo wp_get_attachment_image($image_id, 'large');

					?>
				</li>
				<?php $class = 'block-features__item block-features__item--small'; ?>
			<?php } ?>
		</ol>
	</div>
</div>

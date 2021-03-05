<div class="block-features">
	<div class="container">
		<?php $size = 'large'; ?>
		<ol class="block-features__list">
			<?php while ( have_rows('features') ) { ?>
				<?php $class = "block-features__item block-features__item--$size"; ?>
				<?php the_row(); ?>
				<li class="<?php echo $class; ?>">
					<a href="<?php the_sub_field('button_url'); ?>">
						<h2 class="block-features__title"><?php the_sub_field('title'); ?></h2>
						<span class="button">
							<?php the_sub_field('button_label'); ?>
						</span>
						<?php

						$image_id = get_sub_field('image');
						$attrs = [
							'class' => 'block-features__image'
						];
						echo wp_get_attachment_image($image_id, $size, false, $attrs);

						?>
					</a>
				</li>
				<?php $size = 'medium'; ?>
			<?php } ?>
		</ol>
	</div>
</div>

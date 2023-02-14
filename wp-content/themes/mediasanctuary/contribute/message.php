<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title><?php the_title(); ?></title>
		<link rel="stylesheet" href="<?php asset_url('dist/contribute.css'); ?>">
		<?php wp_head(); ?>
	</head>
	<body class="contribute">
		<?php while (have_posts()) { the_post(); ?>
			<form action="<?php the_permalink(); ?>" method="post" enctype="multipart/form-data" class="contribute">
				<h1><?php the_title(); ?></h1>
				<?php if (! empty($feedback)) { ?>
					<section>
						<p><?php echo $feedback; ?></p>
					</section>
				<?php } ?>
			</form>
		<?php } ?>
		<?php wp_footer(); ?>
	</body>
</html>

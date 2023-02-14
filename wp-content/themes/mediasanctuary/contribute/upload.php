<?php

acf_form_head();

$feedback = '';

$post_id = 'new_post';
$button_label = 'Add Story';
if (! empty($_GET['id'])) {
	$post_id = $_GET['id'];
	$button_label = 'Update Story';
	$feedback = "Thank you for contributing. You can edit your story below.";
}

?>
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
			<h1><?php the_title(); ?></h1>
			<?php contribute_stories($person); ?>
			<form action="<?php the_permalink(); ?>" method="post" enctype="multipart/form-data" class="contribute">
				<?php if (! empty($feedback)) { ?>
					<section>
						<p><?php echo $feedback; ?></p>
					</section>
				<?php
				}

				echo '<section>';
				acf_form([
					'post_id'      => $post_id,
					'form'         => true,
					'return'       => '?id=%post_id%',
					'field_groups' => ['group_637a88d633bb4'],
					'html_submit_button' => '<input type="submit" value="' . $button_label . '" class="contribute-button">'
				]);
				echo '</section>';

				?>
			</form>
		<?php } ?>
		<?php wp_footer(); ?>
	</body>
</html>

<?php

$email = esc_html($_SESSION['contribute_email']);
$feedback = ["You seem new here, $email. To get started, please take a moment to review the code of conduct and then complete your signup below."];
$feedback_class = '';

if (! empty($_POST['acf'])) {
	$data = contribute_submission($_POST['acf']);
	$feedback = [];
	if (empty($data['contribute_name'])) {
		$feedback[] = "Please enter your name to continue.";
		$feedback_class = 'feedback--error';
	}
	if (empty($data['contribute_bio'])) {
		$feedback[] = "Please write a short bio for yourself to continue.";
		$feedback_class = 'feedback--error';
	}
	if (empty($data['contribute_agree'])) {
		$feedback[] = "You must agree to the code of conduct to continue.";
		$feedback_class = 'feedback--error';
	}
	if (empty($feedback)) {
		contribute_signup($data);
		$url = get_permalink($post);
		header("Location: $url");
		exit;
	} else {
		add_filter('acf/prepare_field', function($field) use ($data) {
			$name = $field['_name'];
			if (! empty($data[$name])) {
				$field['value'] = $data[$name];
			}
			return $field;
		});
	}
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
		<form action="<?php the_permalink(); ?>" method="post" enctype="multipart/form-data" class="contribute">
			<h1><?php the_title(); ?></h1>
			<section class="<?php echo $feedback_class; ?>">
				<p><?php echo implode('</p><p>', $feedback); ?></p>
			</section>
			<h2>1. Review the Code of Conduct</h2>
			<?php foreach (get_field('contribute_coc', 'options') as $slide) { ?>
				<section>
					<?php echo $slide['slide']; ?>
				</section>
			<?php } ?>
			<h2>2. Sign up below</h2>
			<section>
				<?php

				$post_id = 'new_post';
				\dbug($person);
				if (! empty($person)) {
					$post_id = $person->ID;
					if (empty(get_field('contribute_name', $post_id))) {
						update_field('contribute_name', $person->post_title, $post_id);
					}
					// if (empty(get_field('contribute_bio', $post_id))) {
						update_field('contribute_bio', wp_strip_all_tags(preg_replace('/<!-- \/?wp:[^>]+ -->\n/', '', $person->post_content)), $post_id);
					// }
				}

				acf_form([
					'post_id'            => $post_id,
					'form'               => true,
					'field_groups'       => ['group_63cd5f8d425dc'],
					'html_submit_button' => '<input type="submit" value="Continue" class="contribute-button">'
				]);

				?>
			</section>
		</form>
		<?php } ?>
		<?php wp_footer(); ?>
	</body>
</html>

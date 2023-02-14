<?php

acf_form_head();

$feedback = 'Please enter your email address to access the upload form.';

if (! empty($_POST['email'])) {
	$feedback = contribute_verify_email_challenge($_POST['email']);
} else if (! empty($_GET['email']) &&
           ! empty($_GET['verify'])) {
	$feedback = contribute_verify_email_response($_GET['email'], $_GET['verify']);
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
		<form action="<?php the_permalink(); ?>" method="post" enctype="multipart/form-data" class="contribute">
			<h1><?php the_title(); ?></h1>
			<section>
				<?php echo $feedback; ?>
			</section>
			<section>
				<label for="contribute-email">Your email address</label>
				<input name="email" id="contribute-email" type="email" placeholder="name@example.com" value="<?php echo @esc_attr($_REQUEST['email']); ?>">
				<input type="submit" value="Continue" class="contribute-button">
			</section>
		</form>
		<?php wp_footer(); ?>
	</body>
</html>

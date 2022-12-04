<?php
/*
Template Name: Upload
*/

$email_feedback = 'Please enter your email address to access the sound upload form.';

if (!empty($_POST['email'])) {
	if (!get_person_by_email($_POST['email'])) {
		$email_feedback = "Sorry, the email address you provided isn't on the list of known contributors. Please contact <a href=\"mailto:info@mediasanctuary.org\">info@mediasanctuary.org</a>.";
	} else {
		$nonce = wp_create_nonce('upload_' . $_POST['email']);
		$email = urlencode($_POST['email']);
		$verify_url = "https://www.mediasanctuary.org/upload/?email=$email&verify=$nonce";
		error_log("Upload verification sent: $verify_url");
		$email_sent = wp_mail($_POST['email'], 'Verify your email address', <<<END
Hello,

Please click on the link below to verify your email address.
$verify_url

Thank you!
END);
		if ($email_sent) {
			$email_feedback = "Please check your inbox for a verification email. If you don't see the message, you may want to look in your spam folder.";
		} else {
			$email_feedback = 'Sorry, there was a problem sending the verification email. Please contact <a href="mailto:info@mediasanctuary.org">info@mediasanctuary.org</a>.';
		}
	}
} else if (!empty($_GET['email']) && !empty($_GET['verify'])) {
	$person = get_person_by_email($_GET['email']);
	$verified = wp_verify_nonce($_GET['verify'], "upload_{$_GET['email']}");
	if ($person && $verified) {
		wp_signon([
			// This should live somewhere else
			'user_login' => get_field('upload_login', 'options'),
			'user_password' => get_field('upload_password', 'options'),
			'remember' => true
		]);
		$_SESSION['upload_email'] = $_GET['email'];
		header('Location: /upload/');
		exit;
	} else {
		$email_feedback = "Sorry the email verification was incorrect. Please contact <a href=\"mailto:info@mediasanctuary.org\">info@mediasanctuary.org</a>.";
	}
} else if (!empty($_GET['signout'])) {
	$_SESSION['upload_email'] = null;
} else if (wp_get_current_user()) {
	$user = wp_get_current_user();
	$_SESSION['upload_email'] = $user->user_email;
}

acf_form_head();

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Upload</title>
		<link rel="stylesheet" href="<?php asset_url('dist/upload.css'); ?>">
		<?php wp_head(); ?>
	</head>
	<body class="upload">
		<form action="/upload/" method="post" class="upload-form" enctype="multipart/form-data">
			<h1>Sound Upload Form</h1>
			<?php if (empty($_SESSION['upload_email'])) { ?>
				<?php if (!empty($email_feedback)) { ?>
					<p><?php echo $email_feedback; ?></p>
				<?php } ?>
				<label for="upload-email">Your email</label>
				<input name="email" id="upload-email" type="email" placeholder="name@example.com" value="<?php echo @esc_attr($_POST['email']); ?>">
				<input type="submit" value="Continue">
			<?php } else { ?>
				<?php

				$posts = get_posts([
					'post_type' => 'acf-field-group'
				]);

				acf_form([
					'post_id' => 'new_post',
					'field_groups' => ['group_637a88d633bb4'],
					'form' => true,
					'return' => '%post_url%',
					'html_before_fields' => '',
					'html_after_fields' => '',
					'submit_value' => 'Save'
				]);

				?>
			<?php } ?>
		</form>
		<script src="<?php asset_url('js/upload.js'); ?>"></script>
		<?php wp_footer(); ?>
	</body>
</html>

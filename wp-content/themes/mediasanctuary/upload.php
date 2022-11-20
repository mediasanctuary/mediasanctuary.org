<?php
/*
Template Name: Upload
*/

$email_feedback = '';
if (!empty($_POST['email'])) {
	if (!upload_person_by_email($_POST['email'])) {
		$email_feedback = "Sorry, the email address you provided isn't on the list of known contributors. Please contact <a href=\"mailto:info@mediasanctuary.org\">info@mediasanctuary.org</a>.";
	} else {
		$nonce = wp_create_nonce('upload_' . $_POST['email']);
		$email = urlencode($_POST['email']);
		$verify_url = "https://www.mediasanctuary.org/upload?email=$email&verify=$nonce";
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
	$person = upload_person_by_email($_GET['email']);
	$verified = wp_verify_nonce($_GET['verify'], "upload_{$_GET['email']}");
	if ($person && $verified) {
		$_SESSION['upload_email'] = $_GET['email'];
		header('Location: /upload/');
		exit;
	} else {
		$email_feedback = "Sorry the email verification was incorrect. Please contact <a href=\"mailto:info@mediasanctuary.org\">info@mediasanctuary.org</a>.";
	}
} else if (!empty($_GET['signout'])) {
	$_SESSION['upload_email'] = null;
}

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Upload</title>
		<link rel="stylesheet" href="<?php asset_url('dist/upload.css'); ?>">
	</head>
	<body>
		<form action="." method="post" id="upload">
			<h1>Upload to Hudson Mohawk Magazine</h1>
			<?php if (!empty($_POST['email'])) { ?>
				<p><?php echo $email_feedback; ?></p>
			<?php } else if (empty($_SESSION['upload_email'])) { ?>
				<?php if (!empty($email_feedback)) { ?>
					<p><?php echo $email_feedback; ?></p>
				<?php } ?>
				<p>This is where you can submit your stories for the <a href="https://www.mediasanctuary.org/project/hudson-mohawk-magazine/">Hudson Mohawk Magazine</a>. To get started, enter your email address below.</p>
				<label for="email">Your email address</label>
				<input name="email" id="email" type="email" placeholder="name@example.com">
				<input type="submit" value="Continue">
			<?php } else { ?>
				<?php $person = upload_person_by_email($_SESSION['upload_email']); ?>
				<p>You are signed in as <b><?php echo $person->post_title; ?></b>. (<a href="?signout=1">Sign out</a>)
			<?php } ?>
		</form>
		<script src="<?php asset_url('js/upload.js'); ?>"></script>
	</body>
</html>

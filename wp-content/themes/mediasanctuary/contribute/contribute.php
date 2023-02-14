<?php
/*
Template Name: Contribute
*/

require_once __DIR__ . '/functions.php';

if (! session_id()) {
	// Remember the session cookie for one year
	$lifetime = 60 * 60 * 24 * 365;
	session_start();
	setcookie(session_name(), session_id(), time() + $lifetime);
}

add_filter('acf/pre_save_post', 'contribute_pre_save_post');
add_action('wp_enqueue_scripts', 'contribute_enqueue_scripts');

if (! empty($_GET['signup'])) {
	$base_url = get_bloginfo('url');
	if (is_user_logged_in() && current_user_can('publish_posts')) {
		$person = contribute_verify_signup($_GET['signup']);
		if ($person) {
			$edit_url = "$base_url/wp-admin/post.php?post=$person->ID&action=edit";
			$feedback = "Thank you for verifying $person->post_title. They have been emailed. You can <a href=\"$edit_url\">edit their details</a>.";
		} else {
			$feedback = "Something went wrong verifying the signup.";
		}
		require_once __DIR__ . '/message.php';
	} else {
		$verify_url = "$base_url{$_SERVER['REQUEST_URI']}";
		header("Location: $base_url/wp-login.php?redirect_to=$verify_url");
	}
	exit;
}

if (empty($_SESSION['contribute_email'])) {
	require_once __DIR__ . '/auth.php';
} else {
	$person = contribute_person($_SESSION['contribute_email']);
	$accepted_coc = false;
	if ($person) {
		$accepted_coc = get_field('accepted_coc', $person->ID);
	}
	if (! $accepted_coc) {
		require_once __DIR__ . '/signup.php';
	} else if ($person->post_status != 'publish') {
		$admin_email = get_field('contribute_admin_email', 'options');
		$feedback = "Once your account is approved you can contribute stories from this page. You can contact <a href=\"mailto:$admin_email\">$admin_email</a> with any questions.";
		require_once __DIR__ . '/message.php';
	} else if (! is_user_logged_in()) {
		contribute_login();
		$upload_url = get_permalink($post);
		header("Location: $upload_url");
		exit;
	} else {
		require_once __DIR__ . '/upload.php';
	}
}

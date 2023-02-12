<?php

function contribute_pre_save_post($post_id) {
	$data = contribute_submission($_POST['acf']);
	wp_update_post([
		'ID'           => $post_id,
		'post_title'   => $data['title'],
		'post_content' => contribute_content($data['description']),
		'tags_input'   => array_map('intval', $data['tags'])
	]);
	update_post_meta($post_id, '_thumbnail_id', $data['image']);
	$person = contribute_person($_SESSION['contribute_email']);
	update_field('byline', [$person->ID], $post_id);
	return $post_id;
}

function contribute_submission($data) {
	$submission = [];
	foreach ($data as $key => $value) {
		if (substr($key, 0, 1) == '_') {
			continue;
		}
		$field = get_field_object($key);
		$name = $field['name'];
		$submission[$name] = $value;
	}
	return $submission;
}

function contribute_content($content) {
	// Input:
	// line one
	//
	// line two
	//
	// Output:
	// <!-- wp:paragraph -->
	// <p>line one</p>
	// <!-- /wp:paragraph -->
	// <!-- wp:paragraph -->
	// <p>line two</p>
	// <!-- /wp:paragraph -->

	$content = wpautop($content);
	libxml_use_internal_errors(true);
	$dom = new \DomDocument('1.0', 'UTF-8');
	$prefix = "<!DOCTYPE html>\n<html><head><meta charset=\"utf-8\"></head><body>";
	$postfix = "</body></html>";
	$dom->loadHTML("$prefix$content$postfix");
	$paragraphs = $dom->getElementsByTagName('p');
	if (! empty($paragraphs)) {
		foreach ($paragraphs as $p) {
			$parent = $p->parentNode;
			$next = $p->nextSibling;
			$block_open = $dom->createComment(' wp:paragraph ');
			$block_close = $dom->createComment(' /wp:paragraph ');
			$nl = $dom->createTextNode("\n");
			$parent->insertBefore($block_open, $p);
			$parent->insertBefore($nl, $p);
			if ($next) {
				$nl = $dom->createTextNode("\n");
				$parent->insertBefore($nl, $next);
				$parent->insertBefore($block_close, $next);
			} else {
				$nl = $dom->createTextNode("\n");
				$parent->appendChild($block_close);
				$parent->appendChild($nl);
			}
		}
	}
	$body_list = $dom->getElementsByTagName('body');
	$output = $dom->saveHTML($body_list[0]);
	$output = trim($output);
	return substr($output, 6, -7); // strip <body>...</body> tags
}

function contribute_person($email) {
	$posts = get_posts([
		'post_type' => 'peoplepower',
		'meta_key' => 'email',
		'meta_value' => $email,
		'post_status' => ['publish', 'draft']
	]);
	if (empty($posts)) {
		return false;
	} else {
		return $posts[0];
	}
}

function contribute_verify_email_challenge($email) {
	global $post;
	$base_url = get_permalink($post);
	$email_encoded = urlencode($email);
	$verify_nonce = wp_create_nonce('contribute_' . $email);
	$verify_url = "$base_url?email=$email_encoded&verify=$verify_nonce";
	$admin_email = get_field('contribute_admin_email', 'options');
	$email_sent = wp_mail($email, 'Verify your email address', <<<END
Hello,

Please click on the link below to verify your email address.
$verify_url

Thank you!
END);
	if ($email_sent) {
		\dbug("Email sent: Verify your email address / $email / $verify_url");
		return "Please check your inbox for a verification email. If you don't see the message, you may want to look in your spam folder.";
	} else {
		\dbug("Email not sent: Verify your email address / $email / $verify_url");
		return "Sorry, there was a problem sending the verification email. Please contact <a href=\"mailto:$admin_email\">$admin_email</a>.";
	}
}

function contribute_verify_email_response($email, $verify_nonce) {
	global $post;
	$base_url = get_permalink($post);
	$admin_email = get_field('contribute_admin_email', 'options');
	if (wp_verify_nonce($verify_nonce, "contribute_$email")) {
		$_SESSION['contribute_email'] = $email;
		header("Location: $base_url");
		exit;
	} else {
		return "Sorry the email verification was incorrect. Please try again or contact <a href=\"mailto:$admin_email\">$admin_email</a> if retrying does not work.";
	}
}

function contribute_login() {
	wp_signon([
		'user_login' => get_field('contribute_login', 'options'),
		'user_password' => get_field('contribute_password', 'options'),
		'remember' => true
	]);
}

function contribute_signup($data) {
	global $post;
	$base_url = get_bloginfo('url');
	$page_url = get_permalink($post);
	$email = $_SESSION['contribute_email'];
	$post_id = wp_insert_post([
		'post_type'    => 'peoplepower',
		'post_status'  => 'draft',
		'post_title'   => $data['contribute_name'],
		'post_content' => contribute_content($data['contribute_bio'])
	]);
	update_field('email', $email, $post_id);
	update_field('accepted_coc', true, $post_id);
	$verify_url = "$page_url?signup=$post_id";
	$admin_email = get_field('contribute_admin_email', 'options');
	$email_sent = wp_mail($admin_email, "Contributor signup: {$data['contribute_name']}", <<<END
Hello,

Please click on the link below to accept the new contributor signup:
$verify_url

Name: {$data['contribute_name']}
Email: $email
Bio: {$data['contribute_bio']}

Clicking on the link above will do three things:
1. A new People Power page will be published to the website
2. {$data['contribute_name']} will be able to upload new stories
3. Send an email to $email letting them know they can contribute

You can also edit the details here:
$base_url/wp-admin/post.php?post=$post_id&action=edit

Thank you!
END);
	if ($email_sent) {
		\dbug("Email sent: Contributor signup: {$data['contribute_name']} / $verify_url");
	} else {
		\dbug("Email not sent: Contributor signup: {$data['contribute_name']} / $verify_url");
	}
}

function contribute_verify_signup($post_id) {
	global $post;
	$person = get_post($post_id);
	if (! $person) {
		return false;
	}
	if ($person->post_status != 'publish') {
		wp_update_post([
			'ID' => $post_id,
			'post_status' => 'publish'
		]);
		$email = get_field('email', $post_id);
		$contribute_url = get_permalink($post);
		$email_sent = wp_mail($email, "Welcome, $person->post_title", <<<END
Hello $person->post_title,

You have been approved to contribute:
$contribute_url

Thank you!
END);
		if ($email_sent) {
			\dbug("Email sent: Welcome, $person->post_title");
		} else {
			\dbug("Email not sent: Welcome, $person->post_title");
		}
	}
	return $person;
}

function contribute_story($data) {
	global $feedback;
	if (!is_user_logged_in()) {
		$_SESSION['upload_email'] = null;
		$feedback = 'Sorry, something went wrong with your story upload. Please try again.';
		return;
	}
	$email = $_SESSION['upload_email'];
	$post_id = wp_insert_post([
		'post_status'  => 'draft',
		'post_title'   => $data['title'],
		'post_content' => $data['description'],
		// 'post_tags'    => $data['tags']
	]);
	$admin_email = get_field('upload_admin_email', 'options');
	$edit_url = "https://www.mediasanctuary.org/wp-admin/post.php?post=$post_id&action=edit";
	$email_sent = wp_mail($admin_email, "New upload: {$data['title']}", <<<END
Hello,

A new story has been uploaded.

Title: {$data['title']}
Description: {$data['description']}

You can edit the details here:
$edit_url

Thank you!
END);
	\dbug("story email sent: $edit_url");
}

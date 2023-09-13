<?php

if (have_posts()) {
	the_post();
	$redirect_url = get_field('redirect_url');
	if (empty($redirect_url)) {
		$redirect_url = '/';
	}
	header("Location: $redirect_url");
	exit;
}

get_template_part('404');

?>

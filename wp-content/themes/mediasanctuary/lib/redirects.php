<?php

function setup_redirects() {

	// Check a configured list of redirects and if the current path matches
	// the 'from_path' field, redirect to the 'redirect_to' field.

	$redirects = get_field('redirects', 'options');
	$url = parse_url($_SERVER['REQUEST_URI']);
	$path = normalize_path($url['path']);
	$redirect_to = false;

	foreach ($redirects as $redirect) {
		if (strpos($redirect['from_path'], '*') !== false) {
			$redirect_to = check_wildcard_redirect($redirect, $path);
			if (! empty($redirect_to)) {
				break;
			}
		} else {
			$from_path = normalize_path($redirect['from_path']);
			if ($path == $from_path) {
				$redirect_to = $redirect['redirect_to'];
				break;
			}
		}
	}

	$redirect_to = apply_filters('redirect_to', $redirect_to, $redirect, $path);
	if (! empty($redirect_to)) {
		wp_redirect($redirect_to);
		exit;
	}
}

function normalize_path($path) {
	// Strip trailing slashes
	if (substr($path, -1, 1) == '/') {
		$path = substr($path, 0, -1);
	}
	return $path;
}

function check_wildcard_redirect($redirect, $path) {
	// Return a redirect URL with wildcard replacements, if a match is found.
	// Return false if the path does not match.
	$from_pattern = str_replace('*', '(.*)', $redirect['from_path']);
	$from_regex = '@^' . $from_pattern . '@i';
	$redirect_to = $redirect['redirect_to'];
	if (preg_match($from_regex, $path, $matches)) {
		foreach ($matches as $index => $value) {
			if ($index == 0) {
				continue;
			}
			$count = 1;
			$redirect_to = str_replace('*', $value, $redirect_to, $count);
		}
		return $redirect_to;
	}
	return false;
}

add_filter('redirect_to', function($redirect_to, $redirect) {

	if (empty($redirect_to)) {
		return null;
	}

	if ($redirect['from_path'] == '/podcasts/*') {
		// Input: /stories/[slug]
		// Output: /stories/[year]/[slug]
		$regex = '@/stories/([^/]+)@';
		if (preg_match($regex, $redirect_to, $matches)) {
			$posts = get_posts([
				'name' => $matches[1]
			]);
			if (! empty($posts)) {
				return get_permalink($posts[0]->ID);
			}
		}
	}

	if ($redirect['from_path'] == '/*') {
		// Input: /sanctuary-news/[slug]
		// Output: /sanctuary-news/[year]/[slug]
		$regex = '@/sanctuary-news/([^/]+)@';
		if (preg_match($regex, $redirect_to, $matches)) {
			$posts = get_posts([
				'name' => $matches[1],
				'category_name' => 'sanctuary-news'
			]);
			if (empty($posts)) {
				return null;
			} else {
				return get_permalink($posts[0]->ID);
			}
		}
	}

	return $redirect_to;
}, 10, 2);

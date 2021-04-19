<?php

require_once 'post-types.php';
require_once 'db/migrate.php';

add_filter('show_admin_bar', '__return_false');

add_filter('pre_get_posts', function($query) {
	if (is_archive()) {
		$query->set('posts_per_page', 20);
	}
	return $query;
});

add_filter('get_the_archive_title', function ($title) {
	if (is_category()) {
		return single_cat_title( '', false );
	}
	return $title;
});

add_filter('category_link', function($url) {
	$home_url = home_url();
	return str_replace("$home_url/category", $home_url, $url);
});

add_action('after_setup_theme', function() {
	add_theme_support('post-thumbnails');
	add_theme_support('title-tag');
	add_theme_support('post-formats', [
		'audio',
		'video'
	]);
});

add_action('wp_enqueue_scripts', function() {
	list($src, $version) = get_asset_url('js/main.js', true);
	wp_enqueue_script('main', $src, ['jquery'], $version, true);
});

add_action('acf/init', function() {
	require_once('blocks/blocks.php');
	if (function_exists('acf_add_options_page')) {
		acf_add_options_page([
			'page_title' => 'Site Options',
			'menu_title' => 'Site Options',
			'menu_slug'  => 'options',
			'capability' => 'edit_others_posts'
		]);
		acf_add_options_page([
			'page_title' => 'Redirects',
			'menu_title' => 'Redirects',
			'menu_slug'  => 'redirects',
			'position'   => '20',
			'icon_url'   => 'dashicons-redo',
			'capability' => 'activate_plugins'
		]);
	}
});

add_filter('acf/settings/load_json', function($path) {
	return get_stylesheet_directory() . '/acf';
});

add_filter('acf/settings/save_json', function($path) {
	return get_stylesheet_directory() . '/acf';
});

add_action('wp_head', function() {
	if (! function_exists('get_field')) {
		return;
	}
	$ua_code = get_field('ga_ua_code', 'options');
	if (empty($ua_code)) {
		return;
	}
	echo <<<END

<script async src="https://www.googletagmanager.com/gtag/js?id=$ua_code"></script>
<script>
window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
gtag('js', new Date());
gtag('config', '$ua_code');
</script>

END;
});

add_action('admin_enqueue_scripts', function() {
	$dir = get_template_directory();
	$css_src = get_template_directory_uri() . '/css/admin/admin.css';
	$css_version = filemtime("$dir/css/admin/admin.css");
	wp_enqueue_style('custom-admin', $css_src, [], $css_version);
});

add_action('init', function() {
	setup_post_types();
});

add_action('template_redirect', function() {

	// Check a configured list of redirects and if the current path matches
	// the 'from_path' field, redirect to the 'redirect_to' field.

	$redirects = get_field('redirects', 'options');
	$url = parse_url($_SERVER['REQUEST_URI']);
	$path = normalize_path($url['path']);
	$redirect_to = false;

	foreach ($redirects as $redirect) {
		if (strpos($redirect['from_path'], '*') !== false) {
			$redirect_to = check_wildcard_redirect($redirect, $path);
			break;
		} else {
			$from_path = normalize_path($redirect['from_path']);
			if ($path == $from_path) {
				$redirect_to = $redirect['redirect_to'];
				break;
			}
		}
	}

	if (! empty($redirect_to)) {
		$redirect_to = apply_filters('redirect_to', $redirect_to, $redirect, $path);
		wp_redirect($redirect_to);
		exit;
	}
});

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
	return $redirect_to;
}, 10, 2);

function asset_url($file) {
	echo get_asset_url($file);
}

function get_asset_url($file, $return_version = false) {
	$url  = get_stylesheet_directory_uri() . "/$file";
	$path = get_stylesheet_directory() . "/$file";
	$ver  = filemtime($path);
	if ($return_version) {
		return [$url, $ver];
	} else {
		return "$url?$ver";
	}
}

function get_category_links($categories, $parent = null) {
	$list = [];
	foreach ($categories as $category) {
		// Skip parent category
		if ($category->term_id == $parent) {
			continue;
		}
		// Skip categories that aren't children of the parent
		if (! empty($parent) && $category->parent != $parent) {
			continue;
		}
		$url = esc_url(get_category_link($category->term_id));
		$label = esc_html($category->name);
		$list[] = '<a href="' . $url . '" class="category" >' . $label . '</a>';
	}
	return $list;
}

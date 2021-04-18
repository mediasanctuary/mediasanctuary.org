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

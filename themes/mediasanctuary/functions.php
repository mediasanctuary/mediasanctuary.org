<?php

add_filter('show_admin_bar', '__return_false');

add_action('after_setup_theme', function() {
	add_theme_support('title-tag');
});

add_action('wp_enqueue_scripts', function() {
	list($src, $version) = get_asset_url('js/main.js', true);
	wp_enqueue_script('main', $src, ['jquery'], $version, true);
});

add_action('acf/init', function() {
	require_once('blocks/blocks.php');
});

add_filter('acf/settings/save_json', function($path) {
	return get_stylesheet_directory() . '/acf';
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

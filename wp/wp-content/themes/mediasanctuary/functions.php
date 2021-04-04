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

add_filter('acf/settings/load_json', function($path) {
	return get_stylesheet_directory() . '/acf';
});

add_filter('acf/settings/save_json', function($path) {
	return get_stylesheet_directory() . '/acf';
});

add_action('admin_enqueue_scripts', function() {
	$dir = get_template_directory();
	$css_src = get_template_directory_uri() . '/css/admin/admin.css';
	$css_version = filemtime("$dir/css/admin/admin.css");
	wp_enqueue_style('custom-admin', $css_src, [], $css_version);
});

// Change the 'post' type to be labeled 'News'
add_action('admin_menu', function() {
	global $menu;
	global $submenu;
	$menu[5][0] = 'News';
	$submenu['edit.php'][5][0] = 'News Posts';
	$submenu['edit.php'][10][0] = 'Add News Post';
});

add_action('init', function() {
	global $wp_post_types;
	$labels = &$wp_post_types['post']->labels;
	$labels->name = 'News';
	$labels->singular_name = 'News Post';
	$labels->add_new = 'Add News Post';
	$labels->add_new_item = 'Add News Post';
	$labels->edit_item = 'Edit News Post';
	$labels->new_item = 'News';
	$labels->view_item = 'View News Post';
	$labels->search_items = 'Search News';
	$labels->not_found = 'No News Posts found';
	$labels->not_found_in_trash = 'No News Posts found in Trash';
	$labels->all_items = 'All News Posts';
	$labels->menu_name = 'News';
	$labels->name_admin_bar = 'News';
	$wp_post_types['post']->menu_icon = 'dashicons-welcome-widgets-menus';
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

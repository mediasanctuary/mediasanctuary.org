<?php

function setup_post_types() {
	news_post_type();
	podcast_post_type();
	project_post_type();
}

function news_post_type() {
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
}

function podcast_post_type() {
	$labels = [
		'name'               => 'Podcasts',
		'singular_name'      => 'Podcast Episode',
		'add_new'            => 'Add New Podcast Episode',
		'add_new_item'       => 'Add New Podcast Episode',
		'edit_item'          => 'Edit Podcast Episode',
		'new_item'           => 'Podcast Episode',
		'view_item'          => 'View Podcast Episode',
		'search_items'       => 'Search Podcasts',
		'not_found'          => 'No Podcast Episodes found',
		'not_found_in_trash' => 'No Podcast Episodes found in Trash',
		'all_items'          => 'All Podcast Episodes',
		'menu_name'          => 'Podcasts',
		'name_admin_bar'     => 'Podcasts'
	];

	register_post_type(
		'podcast',
		array(
			'labels'        => $labels,
			'public'        => true,
			'show_ui'       => true,
			'menu_position' => 4,
			'menu_icon'     => 'dashicons-microphone',
			'supports'      => ['title', 'editor', 'thumbnail'],
			'taxonomies'    => [],
			'rewrite'       => [
				'slug'      => 'podcasts'
			]
		)
	);
}

function project_post_type() {
	$labels = [
		'name'               => 'Projects',
		'singular_name'      => 'Project',
		'add_new'            => 'Add New Project',
		'add_new_item'       => 'Add New Project',
		'edit_item'          => 'Edit Project',
		'new_item'           => 'Project',
		'view_item'          => 'View Project',
		'search_items'       => 'Search Projects',
		'not_found'          => 'No Projects found',
		'not_found_in_trash' => 'No Projects found in Trash',
		'all_items'          => 'All Projects',
		'menu_name'          => 'Projects',
		'name_admin_bar'     => 'Projects'
	];

	register_post_type(
		'project',
		array(
			'labels'        => $labels,
			'public'        => true,
			'show_ui'       => true,
			'menu_position' => 4,
			'menu_icon'     => 'dashicons-format-aside',
			'supports'      => ['title', 'editor', 'thumbnail'],
			'taxonomies'    => [],
		)
	);
}

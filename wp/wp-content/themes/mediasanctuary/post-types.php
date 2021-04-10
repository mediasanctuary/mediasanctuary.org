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
			'supports'      => ['title', 'editor', 'thumbnail', 'revisions'],
			'has_archive'   => true,
			'show_in_rest'  => true,
			'taxonomies'    => [],
			'rewrite'       => [
				'slug'      => 'podcasts'
			]
		)
	);

	$podcast_category_labels = [
		'name'                       => 'Podcast Categories',
		'singular_name'              => 'Podcast Category',
		'menu_name'                  => 'Podcast Categories',
		'all_items'                  => 'All Podcast Categories',
		'parent_item'                => 'Parent Category',
		'parent_item_colon'          => 'Parent Category:',
		'new_item_name'              => 'New Podcast Category',
		'add_new_item'               => 'Add New Podcast Category',
		'edit_item'                  => 'Edit Podcast Category',
		'update_item'                => 'Update Podcast Category',
		'view_item'                  => 'View Podcast Category',
		'separate_items_with_commas' => 'Separate Podcast Categories with commas',
		'add_or_remove_items'        => 'Add or remove Podcast Categories',
		'choose_from_most_used'      => 'Choose from the most used',
		'popular_items'              => 'Popular Podcast Categories',
		'search_items'               => 'Search Podcast Categories',
		'not_found'                  => 'Not Found',
		'no_terms'                   => 'No Podcast Category',
		'items_list'                 => 'Podcast Category list',
		'items_list_navigation'      => 'Podcast Category list navigation'
	];

	$podcast_category_args = [
		'labels'             => $podcast_category_labels,
		'hierarchical'       => false,
		'public'             => true,
		'show_ui'            => true,
		'show_in_quick_edit' => false,
		'meta_box_cb'        => false,
		'show_admin_column'  => false,
		'show_in_nav_menus'  => true,
		'show_in_rest'       => true,
		'show_tagcloud'      => false
	];

	register_taxonomy('podcast_category', ['podcast'], $podcast_category_args);
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
			'has_archive'   => true,
			'show_in_rest'  => true,
			'supports'      => ['title', 'editor', 'thumbnail', 'revisions'],
			'taxonomies'    => [],
		)
	);
}

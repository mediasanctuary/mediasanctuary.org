<?php

function setup_post_types() {
	initiatives_taxonomy();
	project_post_type();
	peoplepower_post_type();
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
			'hierarchical'  => true,
			'show_ui'       => true,
			'menu_position' => 4,
			'menu_icon'     => 'dashicons-format-aside',
			'has_archive'   => true,
			'show_in_rest'  => true,
			'supports'      => ['title', 'editor', 'thumbnail', 'revisions', 'page-attributes'],
			'taxonomies'    => [],
		)
	);
}

function peoplepower_post_type() {
	$labels = [
		'name'               => 'People Power',
		'singular_name'      => 'Person',
		'add_new'            => 'Add New Person',
		'add_new_item'       => 'Add New Person',
		'edit_item'          => 'Edit Person',
		'new_item'           => 'Person',
		'view_item'          => 'View Person',
		'search_items'       => 'Search People Power',
		'not_found'          => 'No People found',
		'not_found_in_trash' => 'No People found in Trash',
		'all_items'          => 'All People',
		'menu_name'          => 'People Power',
		'name_admin_bar'     => 'People Power'
	];

	register_post_type(
		'peoplepower',
		array(
			'labels'        => $labels,
			'public'        => true,
			'hierarchical'  => true,
			'show_ui'       => true,
			'menu_position' => 4,
			'menu_icon'     => 'dashicons-groups',
			'has_archive'   => true,
			'show_in_rest'  => true,
			'supports'      => ['title', 'editor', 'thumbnail', 'revisions', 'page-attributes'],
			'taxonomies'    => [],
		)
	);
}

function initiatives_taxonomy() {
	$labels = [
		'name'                       => 'Initiatives',
		'singular_name'              => 'Initiative',
		'menu_name'                  => 'Initiatives',
		'all_items'                  => 'All Initiatives',
		'parent_item'                => 'Parent Initiative',
		'parent_item_colon'          => 'Parent Initiative:',
		'new_item_name'              => 'New Initiative',
		'add_new_item'               => 'Add New Initiative',
		'edit_item'                  => 'Edit Initiative',
		'update_item'                => 'Update Initiative',
		'view_item'                  => 'View Initiative',
		'separate_items_with_commas' => 'Separate Initiatives with commas',
		'add_or_remove_items'        => 'Add or remove Initiatives',
		'choose_from_most_used'      => 'Choose from the most used',
		'popular_items'              => 'Popular Initiatives',
		'search_items'               => 'Search Initiatives',
		'not_found'                  => 'Not Found',
		'no_terms'                   => 'No Initiatives',
		'items_list'                 => 'Initiatives list',
		'items_list_navigation'      => 'Initiatives list navigation',
	];
	register_taxonomy('initiatives', ['project'], [
		'labels'             => $labels,
		'hierarchical'       => true,
		'public'             => true,
		'show_ui'            => true,
		'show_in_quick_edit' => true,
		'meta_box_cb'        => false,
		'show_admin_column'  => true,
		'show_in_nav_menus'  => true,
		'show_in_rest'       => true,
		'show_tagcloud'      => false,
		'rewrite'            => array( 'slug' => 'projects' )
	]);
}

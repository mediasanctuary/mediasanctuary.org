<?php

function setup_post_types() {
	project_post_type();
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

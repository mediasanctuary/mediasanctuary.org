<?php

function setup_roles() {
	add_sanctuarian_role();
	add_superadmin_role();
	assign_roles();
	remove_extra_roles();
}

// Create a new 'Sanctuarian' role that is a step below a built-in Editor -
// they only have access to the posts and not pages, and events.
// https://wordpress.org/support/article/roles-and-capabilities/
function add_sanctuarian_role() {

	$role = get_role('sanctuarian');

	if (empty($role)) {
		$role = add_role('sanctuarian', 'Sanctuarian', [
			//'delete_others_pages',
			'delete_others_posts',
			//'delete_pages',
			'delete_posts',
			//'delete_private_pages',
			'delete_private_posts',
			//'delete_published_pages',
			'delete_published_posts',
			//'edit_others_pages',
			'edit_others_posts',
			//'edit_pages',
			'edit_posts',
			//'edit_private_pages',
			'edit_private_posts',
			//'edit_published_pages',
			'edit_published_posts',
			'manage_categories',
			'manage_links',
			'moderate_comments',
			'publish_pages',
			'publish_posts',
			'read',
			//'read_private_pages',
			'read_private_posts',
			'unfiltered_html',
			'upload_files'
		]);
		update_option('default_role', 'sanctuarian');
	}
}

function add_superadmin_role() {

	$role = get_role('superadmin');

	if (empty($role)) {
		$admin = get_role('administrator');
		add_role('superadmin', 'Superadmin', $admin->capabilities);
		$admin->remove_cap('activate_plugins');
		$admin->remove_cap('import');
		$admin->remove_cap('export');
		$admin->remove_cap('switch_themes');
		$admin->remove_cap('manage_options');
	}
}

function assign_roles() {
	$users = [
		'brandamiller' => 'sanctuarian',
		'bromley' => 'administrator',
		'dphiffer' => 'superadmin',
		'melissamykal' => 'superadmin',
		'mstellato' => 'superadmin',
		'pierce' => 'administrator',
		'sina' => 'sanctuarian'
	];
	foreach ($users as $login => $role) {
		$user = get_user_by('login', $login);
		if (! empty($user)) {
			$user->set_role($role);
		}
	}
}

function remove_extra_roles() {
	$subscriber = get_role('subscriber');
	if ($subscriber) {
		remove_role('subscriber');
	}

	$contributor = get_role('contributor');
	if ($contributor) {
		remove_role('contributor');
	}

	$author = get_role('author');
	if ($author) {
		remove_role('author');
	}

	$editor = get_role('editor');
	if ($author) {
		remove_role('editor');
	}
}

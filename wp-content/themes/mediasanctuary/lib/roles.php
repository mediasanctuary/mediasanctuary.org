<?php

function setup_roles() {
	add_sanctuarian_role();
	add_superadmin_role();
	//assign_roles();
	remove_extra_roles();
}

// Create a new 'Sanctuarian' role that is a step below a built-in Editor -
// they only have access to the posts and not pages, and events.
// https://wordpress.org/support/article/roles-and-capabilities/
function add_sanctuarian_role() {

	$role = get_role('sanctuarian');

	if (! empty($role)) {
		$role->add_cap('moderate_comments');
		$role->add_cap('manage_categories');
		$role->add_cap('manage_links');
		$role->add_cap('upload_files');
		$role->add_cap('unfiltered_html');
		$role->add_cap('edit_posts');
		$role->add_cap('edit_others_posts');
		$role->add_cap('edit_published_posts');
		$role->add_cap('publish_posts');
		$role->remove_cap('edit_pages');
		$role->add_cap('read');
		$role->add_cap('level_7');
		$role->add_cap('level_6');
		$role->add_cap('level_5');
		$role->add_cap('level_4');
		$role->add_cap('level_3');
		$role->add_cap('level_2');
		$role->add_cap('level_1');
		$role->add_cap('level_0');
		$role->remove_cap('manage_options');
		$role->remove_cap('edit_others_pages');
		$role->remove_cap('edit_published_pages');
		$role->remove_cap('publish_pages');
		$role->remove_cap('delete_pages');
		$role->remove_cap('delete_others_pages');
		$role->remove_cap('delete_published_pages');
		$role->add_cap('delete_posts');
		$role->add_cap('delete_others_posts');
		$role->add_cap('delete_published_posts');
		$role->add_cap('delete_private_posts');
		$role->add_cap('edit_private_posts');
		$role->add_cap('read_private_posts');
		$role->remove_cap('delete_private_pages');
		$role->remove_cap('edit_private_pages');
		$role->remove_cap('read_private_pages');

	} else {
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
			'upload_files',
			'level_0',
			'level_1',
			'level_2',
			'level_3',
			'level_4',
			'level_5',
			'level_6',
			'level_7'
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

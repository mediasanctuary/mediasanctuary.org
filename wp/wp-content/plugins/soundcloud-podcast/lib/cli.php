<?php

add_action('after_setup_theme', function() {
	if ( class_exists( '\WP_CLI' ) ) {
		\WP_CLI::add_command('soundcloud-podcast', function($args) {
			if (! defined('SOUNDCLOUD_PODCAST_CLIENT_ID')) {
				echo "Please define SOUNDCLOUD_PODCAST_CLIENT_ID\n";
				return;
			}

			if (! defined('SOUNDCLOUD_PODCAST_USER_ID')) {
				echo "Please define SOUNDCLOUD_PODCAST_USER_ID\n";
				return;
			}

			if ($args[0] == 'inventory') {
				soundcloud_podcast_inventory();
			} else if ($args[0] == 'import') {
				$import_all = in_array('--all', $args);
				soundcloud_podcast_import($import_all);
			}
		});
	}
});
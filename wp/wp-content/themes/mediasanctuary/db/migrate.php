<?php

add_action('after_setup_theme', function() {
	if ( class_exists( '\WP_CLI' ) ) {
		\WP_CLI::add_command('migrate', 'db_migrate', [
			'shortdesc' => 'Run a content migration'
		]);
	}
});

function db_migrate($args) {
	echo "Migrating content\n";

	$version = get_option('db_migrate_version');
	if (empty($version)) {
		$version = 0;
	}

	$version++;

	while ($migrate_step = db_migrate_step($version)) {
		global $wpdb;
		$wpdb->query("START TRANSACTION");
		try {
			echo "\n";
			echo "Migration $version\n";
			echo "----------------\n";
			$migrate_step();
			echo "\n";
			//update_option('db_migrate_version', $version, false);
		} catch (\Exception $err) {
			echo "ERROR: " . $err->getMessage() . "\n";
			echo "Rolling back database transaction\n";
			$wpdb->query("ROLLBACK");
			break;
		}
		$wpdb->query("COMMIT");
		$version++;
	}
	echo "Finished migration\n";
}

function db_migrate_step($version) {
	$theme_dir = get_template_directory();
	$version_padded = str_pad($version, 4, '0', STR_PAD_LEFT);
	$migrate_path = "$theme_dir/db/migrate_$version_padded.php";
	if (! file_exists($migrate_path)) {
		//echo "Could not find $migrate_path\n";
		return false;
	}
	require_once($migrate_path);
	return "db_migrate_v$version";
}

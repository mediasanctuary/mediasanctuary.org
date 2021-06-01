<?php

function db_migrate_v1() {
	echo "Migration number 1:\n";
	echo "- For each 'podcast' add a 'soundcloud_podcast_id' or 'soundcloud_podcast_url'\n";
	echo "- For each 'podcast' remove 'WOOC 105.3 FM: ' prefix from title\n";
	echo "\n";

	$posts = get_posts([
		'post_type' => 'podcast',
		'posts_per_page' => -1
	]);

	foreach ($posts as $post) {
		echo "Migrating $post->post_title ($post->ID)\n";

		$regex = '/^WOOC 105.3 FM: /';
		if (preg_match($regex, $post->post_title, $matches)) {
			$title = preg_replace($regex, '', $post->post_title);
			echo "    new title: $title\n";
			wp_update_post([
				'ID' => $post->ID,
				'post_title' => $title
			]);
		}

		$track_id = get_post_meta($post->ID, 'soundcloud_podcast_id', true);
		if (! empty($track_id)) {
			echo "    skipped (has track id)\n";
			continue;
		}
		$url = get_post_meta($post->ID, 'soundcloud_podcast_url', true);
		if (! empty($url)) {
			echo "    skipped (has url)\n";
			continue;
		}

		$regex = '#https://soundcloud.com/mediasanctuary/[a-z0-9-]+#';
		if (preg_match($regex, $post->post_content, $matches)) {
			$url = $matches[0];
			update_post_meta($post->ID, 'soundcloud_podcast_url', $url);
			echo "    added url: $url\n";
			continue;
		}

		$regex = '#api.soundcloud.com/tracks/(\d+)#';
		if (preg_match($regex, $post->post_content, $matches)) {
			$track_id = $matches[1];
			update_post_meta($post->ID, 'soundcloud_podcast_id', $track_id);
			echo "    added track id: $track_id\n";
			continue;
		}

		echo "    WARNING: could not migrate track id or url\n";
	}
}

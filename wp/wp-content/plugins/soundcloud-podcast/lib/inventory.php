<?php

function soundcloud_podcast_inventory($url = null) {
	global $wpdb, $soundcloud_podcast_inventory;

	$stdout = fopen('php://stdout', 'w');
	$stderr = fopen('php://stderr', 'w');

	if (empty($soundcloud_podcast_inventory)) {
		$soundcloud_podcast_inventory = [
			'table' => [
				[
					'status',
					'wp_id',
					'wp_status',
					'wp_url',
					'wp_title',
					'wp_content',
					'wp_date',
					'sc_id',
					'sc_url',
					'sc_title',
					'sc_content',
					'sc_date'
				]
			],
			'post_index' => [],
			'track_index' => [],
			'url_index' => [],
			'wp_only_count' => 0,
			'sc_only_count' => 0,
			'connected_count' => 0
		];

		$wp_rows = $wpdb->get_results("
			SELECT ID AS wp_id,
			       post_status AS wp_status,
			       post_name AS wp_slug,
			       post_title AS wp_title,
			       post_content AS wp_content,
			       post_date AS wp_date
			FROM wp_posts
			WHERE post_type = 'podcast'
			ORDER BY post_date DESC
		");
		foreach ($wp_rows as $num => $row) {
			$soundcloud_podcast_inventory['table'][] = [
				'wp only',
				$row->wp_id,
				$row->wp_status,
				"https://www.mediasanctuary.org/podcasts/$row->wp_slug",
				$row->wp_title,
				$row->wp_content,
				$row->wp_date,
				null,
				null,
				null,
				null,
				null
			];
			$soundcloud_podcast_inventory['post_index'][$row->wp_id] = $num;
			$soundcloud_podcast_inventory['wp_only_count']++;
		}

		$track_index = [];
		$url_index = [];
		$meta_rows = $wpdb->get_results("
			SELECT post_id,
			       meta_key,
			       meta_value
			FROM wp_postmeta
			WHERE meta_key = 'soundcloud_podcast_id'
			   OR meta_key = 'soundcloud_podcast_url'
		");
		foreach ($meta_rows as $row) {
			if ($row->meta_key == 'soundcloud_podcast_id') {
				$soundcloud_podcast_inventory['track_index'][$row->meta_value] = $row->post_id;
			} else if ($row->meta_key == 'soundcloud_podcast_url') {
				$soundcloud_podcast_inventory['url_index'][$row->meta_value] = $row->post_id;
			}
		}
	}

	if (empty($url)) {
		$client_id = SOUNDCLOUD_PODCAST_CLIENT_ID;
		$user_id = SOUNDCLOUD_PODCAST_USER_ID;
		$args = http_build_query([
			'client_id'           => $client_id,
			'limit'               => 200,
			'linked_partitioning' => 'true'
		]);
		$url = "https://api.soundcloud.com/users/$user_id/tracks?$args";
	} else {
		$client_id = SOUNDCLOUD_PODCAST_CLIENT_ID;
		$url .= "&client_id=$client_id";
	}

	fwrite($stderr, "Importing from $url\n");

	$rsp = wp_remote_get($url);
	if (is_wp_error($rsp)) {
		fwrite($stderr, "Error: " . $rsp->get_error_message() . "\n");
		return;
	}
	$status = wp_remote_retrieve_response_code($rsp);
	if ($status != 200) {
		$msg = wp_remote_retrieve_body($rsp);
		fwrite($stderr, "Error: HTTP $status\n");
		if (! empty($msg)) {
			fwrite($stderr, "$msg\n");
			//file_put_contents('last-request.json', $msg);
			return;
		}
	}
	$json = wp_remote_retrieve_body($rsp);
	//file_put_contents('last-request.json', $json);

	$tracks = json_decode($json, 'as hash');
	foreach ($tracks['collection'] as $track) {

		$index = null;
		$id = $track['id'];
		$url = "https://soundcloud.com/mediasanctuary/{$track['permalink']}";
		$title = $track['title'];
		$content = $track['description'];
		$date = new \DateTime($track['created_at'], wp_timezone());
		$date = $date->format('Y-m-d H:i:s');

		if (! empty($soundcloud_podcast_inventory['track_index'][$id])) {
			$post = $soundcloud_podcast_inventory['track_index'][$id];
			$index = $soundcloud_podcast_inventory['post_index'][$post];
		} else if (! empty($soundcloud_podcast_inventory['url_index'][$url])) {
			$post = $soundcloud_podcast_inventory['url_index'][$url];
			$index = $soundcloud_podcast_inventory['post_index'][$post];
		}
		if (! empty($index)) {
			$soundcloud_podcast_inventory['wp_only_count']--;
			$soundcloud_podcast_inventory['connected_count']++;
			$soundcloud_podcast_inventory['table'][$index][0] = 'connected';
			$soundcloud_podcast_inventory['table'][$index][7] = $id;
			$soundcloud_podcast_inventory['table'][$index][8] = $url;
			$soundcloud_podcast_inventory['table'][$index][9] = $title;
			$soundcloud_podcast_inventory['table'][$index][10] = $content;
			$soundcloud_podcast_inventory['table'][$index][11] = $date;
		} else {
			$soundcloud_podcast_inventory['sc_only_count']++;
			$soundcloud_podcast_inventory['table'][] = [
				'sc only',
				null, // wp_id
				null, // wp_status
				null, // wp_url
				null, // wp_title
				null, // wp_content
				null, // wp_date
				$id,
				$url,
				$title,
				$content,
				$date
			];
		}
	}

	if (! empty($tracks['next_href'])) {
		soundcloud_podcast_inventory($tracks['next_href']);
	} else {
		foreach ($soundcloud_podcast_inventory['table'] as $row) {
			fputcsv($stdout, $row);
		}
		fwrite($stderr, "connected: {$soundcloud_podcast_inventory['connected_count']}\n");
		fwrite($stderr, "wp-only: {$soundcloud_podcast_inventory['wp_only_count']}\n");
		fwrite($stderr, "sc-only: {$soundcloud_podcast_inventory['sc_only_count']}\n");
	}

	fclose($stdout);
	fclose($stderr);
}

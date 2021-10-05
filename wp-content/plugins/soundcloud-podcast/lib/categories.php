<?php

function soundcloud_podcast_categories() {
	$stderr = fopen('php://stderr', 'w');
	$categories = apply_filters('soundcloud_podcast_categories', []);
	if (empty($categories)) {
		fwrite($stderr, "Error: no categories to import\n");
		return;
	}
	$count = 0;
	foreach ($categories as $category => $playlist) {
		$count += soundcloud_podcast_category_import($category, $playlist);
	}
	fwrite($stderr, "Assigned $count categories\n");
	fclose($stderr);
}

function soundcloud_podcast_category_import($term_id, $playlist_id) {

	global $wpdb;
	$stdout = fopen('php://stdout', 'w');
	$stderr = fopen('php://stderr', 'w');

	$default_category = (int) get_option('default_category', null);

	$count = 0;
	$playlists = soundcloud_podcast_playlists();
	foreach ($playlists['list'] as $list) {
		if ($list['id'] == $playlist_id) {
			if (empty($list['tracks'])) {
				fwrite($stderr, "Playlist is empty, skipping\n");
				return;
			}

			$track_ids = array_filter($list['tracks'], 'is_numeric');
			$track_ids = "'" . implode("', '", $track_ids) . "'";

			$results = $wpdb->get_results("
				SELECT pm.post_id, p.post_title
				FROM wp_postmeta AS pm, wp_posts AS p
				WHERE pm.post_id = p.ID
				  AND p.post_type = 'post'
				  AND pm.meta_key = 'soundcloud_podcast_id'
				  AND pm.meta_value IN ($track_ids)
			");

			$cat_id = intval($term_id);
			foreach ($results as $result) {
				$cats = wp_get_post_categories($result->post_id);
				if (! in_array($cat_id, $cats)) {
					$cats[] = $cat_id;
					wp_update_post([
						'ID' => $result->post_id,
						'post_category' => $cats
					]);
					$term = get_term($term_id, 'category');
					$term_name = html_entity_decode($term->name);
					fwrite($stderr, "Added '$result->post_title' ($result->post_id) to $term_name\n");
					fputcsv($stdout, [
						date('Y-m-d H:i:s'),
						$result->post_id,
						$term_id,
						$playlist_id
					]);
					$count++;
				}
			}

		}
	}

	fclose($stderr);
	return $count;
}

function soundcloud_podcast_playlists() {
	$stderr = fopen('php://stderr', 'w');
	fwrite($stderr, "Retrieving category list\n");

	$cache_ttl = 60 * 30; // Thirty minutes
	$cache_key = "soundcloud_podcast_playlists";

	$playlists = null;
	$cached_json = get_option($cache_key, null);

	if (! empty($cached_json)) {
		$playlists = json_decode($cached_json, 'as hash');
	}

	if (! empty($playlists) && time() - $playlists['updated'] < $cache_ttl) {
		$ttl = $cache_ttl - time() + $playlists['updated'];
		fwrite($stderr, "Loading from cache ($ttl ttl)\n");
	} else {
		$url = 'https://api.soundcloud.com/me/playlists';
		fwrite($stderr, "Loading from $url\n");

		$access_token = soundcloud_podcast_token();
		$rsp = wp_remote_get($url, [
			'headers' => [
				'Accept' => 'application/json; charset=utf-8',
				'Authorization' => "OAuth $access_token"
			]
		]);

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
			}
			return;
		}
		$json = wp_remote_retrieve_body($rsp);
		$list = json_decode($json, 'as hash');
		$playlists = [
			'list' => [],
			'updated' => time()
		];

		foreach ($list as $item) {
			$tracks = [];
			foreach ($item['tracks'] as $track) {
				$tracks[] = $track['id'];
			}
			$playlists['list'][] = [
				'id'     => $item['id'],
				'title'  => $item['title'],
				'slug'   => $item['permalink'],
				'tracks' => $tracks
			];
		}

		$playlists_json = json_encode($playlists);
		update_option($cache_key, $playlists_json, false);
	}

	fclose($stderr);
	return $playlists;
}

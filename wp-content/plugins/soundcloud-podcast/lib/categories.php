<?php

function soundcloud_podcast_categories($cat = null) {
	if (! empty($cat)) {
		soundcloud_podcast_category_import($cat);
	} else {
		$stderr = fopen('php://stderr', 'w');
		$categories = apply_filters('soundcloud_podcast_categories', []);
		if (empty($categories)) {
			fwrite($stderr, "Error: no categories to import\n");
			return;
		}
		foreach ($categories as $cat) {
			soundcloud_podcast_category_import($cat);
		}
		fclose($stderr);
	}
}

function soundcloud_podcast_category_import($cat) {

	$stderr = fopen('php://stderr', 'w');
	fwrite($stderr, "Importing category $cat\n");

	$id = 1;
	$cache_key = "soundcloud_podcast_playlist_$id";
	$cached = get_option($cache_key, null);
	if (empty($cached)) {
		$playlists = soundcloud_podcast_playlists();

	}

	fclose($stderr);
}

function soundcloud_podcast_playlists() {
	$stderr = fopen('php://stderr', 'w');
	fwrite($stderr, "Retrieving category list\n");

	$cache_ttl = 60 * 60; // One hour
	$cache_key = "soundcloud_podcast_playlists";

	$playlists = null;
	$cached_json = get_option($cache_key, null);

	if (! empty($cached_json)) {
		$playlists = json_decode($cached_json, 'as hash');
	}

	if (! empty($playlists) && time() - $playlists['updated'] < $cache_ttl) {
		fwrite($stderr, "Loading from cache\n");
	} else {
		$client_id = SOUNDCLOUD_PODCAST_CLIENT_ID;
		$user_id = SOUNDCLOUD_PODCAST_USER_ID;
		$args = http_build_query([
			'client_id' => $client_id
		]);
		$url = "https://api.soundcloud.com/users/$user_id/playlists?$args";
		$rsp = wp_remote_get($url);

		fwrite($stderr, "Loading from $url\n");
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

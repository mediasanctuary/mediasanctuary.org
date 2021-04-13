<?php

function soundcloud_podcast_import($import_all = false, $url = null) {
	$stdout = fopen('php://stdout', 'w');
	$stderr = fopen('php://stderr', 'w');

	if (empty($url)) {
		$client_id = SOUNDCLOUD_PODCAST_CLIENT_ID;
		$user_id = SOUNDCLOUD_PODCAST_USER_ID;
		$args = http_build_query([
			'client_id'           => $client_id,
			'limit'               => 10,
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
			return;
		}
	}
	$json = wp_remote_retrieve_body($rsp);
	$tracks = json_decode($json, 'as hash');
	foreach ($tracks['collection'] as $track) {

		if (preg_match('/^HMM \d+ - \d+ - \d+$/', $track['title'])) {
			// For now we skip the full shows
			fwrite($stderr, "Skipping full show {$track['title']}\n");
			continue;
		}

		$post = soundcloud_podcast_get_post($track);
		$wp_hash = null;
		$sc_hash = soundcloud_podcast_hash($track);

		if (! empty($post)) {
			$wp_hash = get_post_meta($post->ID, 'soundcloud_podcast_hash', true);
		}

		/*if ($wp_hash == $sc_hash) {
			fwrite($stderr, "No change to {$track['title']}\n");
			continue;
		}*/

		if (empty($post)) {
			fwrite($stderr, "Creating new post for {$track['title']}\n");
			$id = wp_insert_post([
				'post_type' => 'podcast',
				'post_status' => 'draft',
				'post_title' => $track['title'],
				'post_content' => $track['description']
			]);
		} else {
			fwrite($stderr, "Updating existing post for {$track['title']}\n");
			$id = $post->ID;
			wp_update_post([
				'ID' => $id,
				'post_title' => $track['title'],
				'post_content' => $track['description']
			]);
		}
		update_post_meta($id, 'soundcloud_podcast_id', $track['id']);
		update_post_meta($id, 'soundcloud_podcast_hash', $sc_hash);
		update_post_meta($id, 'soundcloud_podcast_url', $track['permalink_url']);

		$image_id = get_post_meta($id, '_thumbnail_id');
		if (! empty($image_id)) {
			$image = get_post($image_id);
			if (! empty($image)) {
				continue;
			}
		}

		if (empty($track['artwork_url'])) {
			continue;
		}

		$image_url = preg_replace('/-large\.(\w+)$/', '-original.$1', $track['artwork_url']);
		$filename = preg_replace('/\/([^\/]+)-large\.(\w+)$/', '$1.$2', $track['artwork_url']);
		$filename = basename($filename);

		fwrite($stderr, "Saving image $image_url\n");

		$rsp = wp_remote_get($image_url, [
			'timeout' => '90',
			'user-agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.11; rv:44.0) Gecko/20100101 Firefox/44.0'
		]);
		$status = wp_remote_retrieve_response_code($rsp);
		if ($status != 200) {
			fwrite($stderr, "Warning: could not load image {$track['artwork_url']}\n");
			continue;
		}

		$image_data = wp_remote_retrieve_body($rsp);
		$content_type = $rsp['headers']['content-type'];

		$upload_dir = wp_upload_dir();
		$dir = $upload_dir['path'];
		if (! file_exists($dir)) {
			wp_mkdir_p($dir);
		}
		$path = "$dir/$filename";
		file_put_contents($path, $image_data);

		$filetype = wp_check_filetype($filename, null);
		$attachment = [
			'guid'           => "{$upload_dir['url']}/$filename",
			'post_mime_type' => $filetype['type'],
			'post_title'     => $filename,
			'post_content'   => '',
			'post_status'    => 'inherit'
		];
		$attach_id = wp_insert_attachment($attachment, $path);

		if (preg_match('/^image/', $content_type)) {
			require_once(ABSPATH . 'wp-admin/includes/image.php');
			$attach_data = wp_generate_attachment_metadata($attach_id, $path);
			wp_update_attachment_metadata($attach_id, $attach_data);
		}

		update_post_meta($id, '_thumbnail_id', $attach_id);
	}

	if (! empty($tracks['next_href']) && $import_all) {
		soundcloud_podcast_import($import_all, $tracks['next_href']);
	}
}

function soundcloud_podcast_get_post($track) {
	$username = $track['user']['permalink'];
	$url = "https://soundcloud.com/$username/{$track['permalink']}";
	$posts = get_posts([
		'post_type' => 'podcast',
		'post_status' => ['publish', 'pending', 'draft', 'future'],
		'meta_query' => [
			'relation' => 'OR',
			[
				'key' => 'soundcloud_podcast_id',
				'value' => $track['id'],
			], [
				'key' => 'soundcloud_podcast_url',
				'value' => $url
			]
		]
	]);
	if (empty($posts)) {
		return null;
	} else {
		return $posts[0];
	}
}

function soundcloud_podcast_hash($track) {
	$plaintext = $track['id'];
	$plaintext .= "|{$track['title']}";
	$plaintext .= "|{$track['description']}";
	$plaintext .= "|{$track['permalink_url']}";
	$plaintext .= "|{$track['artwork_url']}";
	return md5($plaintext);
}

function soundcloud_podcast_track_content($track) {
	return $track['description'];
}

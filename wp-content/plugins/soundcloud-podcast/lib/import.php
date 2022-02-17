<?php

function soundcloud_podcast_import($num = null, $url = null, $slack_msg = '') {

	$stdout = fopen('php://stdout', 'w');
	$stderr = fopen('php://stderr', 'w');

	$import_all = false;
	if ($num == 'all') {
		$num = 200;
		$import_all = true;
		if (empty($url)) {
			fwrite($stderr, "*** Importing all SoundCloud tracks ***\n");
		}
	} else if (empty($num)) {
		$num = 30;
	} else if (! is_numeric($num)) {
		fwrite($stderr, "Error: invalid argument $num\n");
		return;
	}

	if (empty($url)) {
		$args = http_build_query([
			'limit'               => $num,
			'linked_partitioning' => 'true'
		]);
		$url = "https://api.soundcloud.com/me/tracks?$args";
	}

	fwrite($stderr, "Importing from $url\n");

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
	$tracks = json_decode($json, 'as hash');

	if (! isset($tracks['collection'])) {
		fwrite($stderr, "Error: invalid JSON\n");
		return;
	}

	foreach ($tracks['collection'] as $track) {

		if ($track['sharing'] != 'public') {
			fwrite($stderr, "Skipping private track {$track['title']}\n");
			continue;
		}

		$post = soundcloud_podcast_get_post($track);
		$wp_hash = null;
		$sc_hash = soundcloud_podcast_hash($track);

		if (! empty($post)) {
			$wp_hash = get_post_meta($post->ID, 'soundcloud_podcast_hash', true);
		}

		if ($wp_hash == $sc_hash) {
			fwrite($stderr, "No change to {$track['title']}\n");
			continue;
		}

		if (empty($post)) {
			fwrite($stderr, "Creating new post for {$track['title']}\n");
			$id = wp_insert_post([
				'post_status' => soundcloud_podcast_track_status($track),
				'post_title' => $track['title'],
				'post_content' => soundcloud_podcast_track_content($track),
				'post_date' => soundcloud_podcast_track_date($track),
				'post_category' => soundcloud_podcast_track_categories($track)
			]);
			set_post_format($id, 'audio');
			wp_set_post_tags($id, soundcloud_podcast_track_tags($track));

			fputcsv($stdout, [
				date('Y-m-d H:i:s'),
				$id,
				'create',
				$track['id'],
				$track['title'],
				join(', ', soundcloud_podcast_track_tags($track)),
				soundcloud_podcast_track_date($track),
				$track['permalink_url'],
				$track['artwork_url']
			]);

			if (! empty($slack_msg)) {
				$slack_msg .= "\n";
			}
			$edit_url = home_url("/wp-admin/post.php?post=$id&action=edit");
			$slack_msg .= "- <$edit_url|{$track['title']}> (scheduled)";
		} else {
			fwrite($stderr, "Updating existing post for {$track['title']}\n");
			$id = $post->ID;
			wp_update_post([
				'ID' => $id,
				'post_title' => $track['title'],
				'post_content' => soundcloud_podcast_track_content($track),
				'post_category' => soundcloud_podcast_track_categories($track)
			]);
			wp_set_post_tags($id, soundcloud_podcast_track_tags($track));

			fputcsv($stdout, [
				date('Y-m-d H:i:s'),
				$id,
				'update',
				$track['id'],
				$track['title'],
				join(', ', soundcloud_podcast_track_tags($track)),
				soundcloud_podcast_track_date($track),
				$track['permalink_url'],
				$track['artwork_url']
			]);

			if (! empty($slack_msg)) {
				$slack_msg .= "\n";
			}
			$edit_url = home_url("/wp-admin/post.php?post=$id&action=edit");
			$slack_msg .= "- <$edit_url|{$track['title']}> (updated)";
		}

		$tags = soundcloud_podcast_track_tags($track);
		if (empty($tags)) {
			fwrite($stderr, "    (no tags)\n");
		} else {
			fwrite($stderr, "    tags = " . implode($tags, ', ') . "\n");
		}

		update_post_meta($id, 'soundcloud_podcast_id', $track['id']);
		update_post_meta($id, 'soundcloud_podcast_hash', $sc_hash);
		update_post_meta($id, 'soundcloud_podcast_url', $track['permalink_url']);

		$image_url = preg_replace('/-large\.(\w+)$/', '-original.$1', $track['artwork_url']);
		$filename = preg_replace('/\/([^\/]+)-large\.(\w+)$/', '$1.$2', $track['artwork_url']);
		$filename = basename($filename);

		$image_id = get_post_meta($id, '_thumbnail_id', true);
		if (! empty($image_id)) {
			$image = get_post($image_id);
			if (! empty($image) && $image->post_title == $filename) {
				continue;
			}
		}

		if (empty($track['artwork_url'])) {
			continue;
		}

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
		soundcloud_podcast_import($import_all, $tracks['next_href'], $slack_msg);
	} else if (! empty($slack_msg)) {
		soundcloud_podcast_update_slack($slack_msg);
	}
}

function soundcloud_podcast_get_post($track) {
	$username = $track['user']['permalink'];
	$url = "https://soundcloud.com/$username/{$track['permalink']}";
	$posts = get_posts([
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
	$content = soundcloud_podcast_track_content($track);
	$plaintext = $track['id'];
	$plaintext .= "|{$track['title']}";
	$plaintext .= "|$content";
	$plaintext .= "|{$track['tag_list']}";
	$plaintext .= "|{$track['permalink_url']}";
	$plaintext .= "|{$track['artwork_url']}";
	return md5($plaintext);
}

function soundcloud_podcast_track_content($track) {
	$content = $track['description'];

	// The following looks for URL-shaped text and adds hyperlinks.
	// The regex is slightly modified from https://www.urlregex.com/
	$regex = '%(?:(?:https?|ftp)://)(?:\S+(?::\S*)?@|\d{1,3}(?:\.\d{1,3}){3}|(?:(?:[a-z\d\x{00a1}-\x{ffff}]+-?)*[a-z\d\x{00a1}-\x{ffff}]+)(?:\.(?:[a-z\d\x{00a1}-\x{ffff}]+-?)*[a-z\d\x{00a1}-\x{ffff}]+)*(?:\.[a-z\x{00a1}-\x{ffff}]{2,6}))(?::\d+)?(?:[^\s]*)?%iu';
	$content = preg_replace_callback($regex, function($matches) {

		$url = $matches[0];
		$last_char = substr($url, -1, 1);
		$punctuation = ['.', ',', '!', ';'];
		$postfix = '';

		if ($last_char == ')') {
			if (strpos($url, '(') === false) {
				// do not link ) of "(https://www.mediasanctuary.org/)"
				// but do link the ) of "https://en.wikipedia.org/wiki/Douglas_Davis_(artist)"
				$url = substr($url, 0, -1);
				$postfix = ')';
			}
		} else if (in_array($last_char, $punctuation)) {
			// do not link . of "https://www.mediasanctuary.org/."
			$url = substr($url, 0, -1);
			$postfix = $last_char;
		}

		$label = $url;

		// Remove the "https://www" part at the front of the label
		$label = preg_replace('%^https?://%i', '', $label);

		// Remove the trailing slash part of the label
		$label = preg_replace('%^([^/]+)/$%', '$1', $label);

		return "<a href=\"$url\">$label</a>$postfix";

	}, $content);

	return $content;
}

function soundcloud_podcast_track_date($track = null) {
	$stderr = fopen('php://stderr', 'w');
	$category = soundcloud_podcast_track_category_name($track);
	$four_days = 60 * 60 * 24 * 4;

	if (! empty($track)) {
		$date = new \DateTime($track['created_at'], wp_timezone());
		if ($category == 'Stories' &&
		    current_time('u') - $date->getTimestamp() < $four_days) {
			// If the track's timestamp is within 4 days, we should schedule
			// it for the next weekday at 6pm.
			$date = null;
		}
	}

	if (empty($date)) {
		$schedule_at = 'Today 6pm';

		// If it's after Friday at 7pm, schedule for Monday at 6pm.
		if (current_time('w') == 5 && current_time('H') > 19 ||
		    current_time('w') == 6 ||
		    current_time('w') == 0) {
			$schedule_at = 'Monday 6pm';
		}

		$date = new \DateTime($schedule_at, wp_timezone());
	}

	return $date->format('Y-m-d H:i:s');
}

function soundcloud_podcast_track_status($track) {
	$stderr = fopen('php://stderr', 'w');
	$date = soundcloud_podcast_track_date($track);
	if ($date > current_time('Y-m-d H:i:s')) {
		fwrite($stderr, "    date = $date, status = future\n");
		return 'future';
	} else {
		fwrite($stderr, "    date = $date, status = publish\n");
		return 'publish';
	}
}

function soundcloud_podcast_track_tags($track) {
	$tag_list = strtolower($track['tag_list']);
	$in_quotes = false;
	$tags = [];
	$curr_tag = '';
	for ($i = 0; $i < mb_strlen($tag_list); $i++) {
		$char = mb_substr($tag_list, $i, 1);
		if ($char == '"') {
			$in_quotes = ! $in_quotes;
			continue;
		}
		if ($char == ' ' && ! $in_quotes) {
			if (! empty($curr_tag)) {
				$tags[] = $curr_tag;
			}
			$curr_tag = '';
		} else {
			$curr_tag .= $char;
		}
	}
	if (! empty($curr_tag)) {
		$tags[] = $curr_tag;
	}
	return $tags;
}

function soundcloud_podcast_track_category_name($track) {
	$category = 'Stories';
	if (preg_match('/^HMM\s+\d+\s*-\s*\d+\s*-\s*\d+\s*$/i', $track['title'])) {
		$category = 'Hudson Mohawk Magazine';
	}
	return $category;
}

function soundcloud_podcast_track_categories($track) {
	$stderr = fopen('php://stderr', 'w');
	$category = soundcloud_podcast_track_category_name($track);
	$cat = get_term_by('name', $category, 'category', ARRAY_A);
	if (empty($cat)) {
		$cat = wp_create_term($category, 'category');
	}
	fwrite($stderr, "    category = $category ({$cat['term_id']})\n");
	return [$cat['term_id']];
}

function soundcloud_podcast_update_slack($message) {
	if (! defined('SOUNDCLOUD_PODCAST_SLACK_URL')) {
		return false;
	}
	$payload = [
		'type' => 'mrkdwn',
		'text' => $message
	];
	$rsp = wp_remote_post(SOUNDCLOUD_PODCAST_SLACK_URL, [
		'body' => [
			'payload' => json_encode($payload)
		]
	]);
	return $rsp['response']['code'] == 200;
}

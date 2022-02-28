<?php

function soundcloud_podcast_export($post_id = null) {
	if ($post_id) {
		$post = get_post($post_id);
	} else {
		$post = soundcloud_podcast_export_next_post();
	}
	if ($post) {
		$track_id = get_post_meta($post->ID, 'soundcloud_podcast_id', true);
		$dir = soundcloud_podcast_export_dir($post);
		$files = soundcloud_podcast_export_files($post, $track_id, $dir);
		print_r($files);
	}
}

function soundcloud_podcast_export_next_post() {
	$posts = get_posts([
		'post_status' => 'publish',
		'meta_query' => [
			'relation' => 'AND',
			'soundcloud_clause' => [
				'key' => 'soundcloud_podcast_id',
				'compare' => 'EXISTS'
			],
			'internet_archive_clause' => [
				'key' => 'internet_archive_id',
				'compare' => 'NOT EXISTS'
			]
		],
		'post_count' => 1
	]);
	if (! empty($posts)) {
		return $posts[0];
	}
	return false;
}

function soundcloud_podcast_export_id($post) {
	return "media-sanctuary-" . $post->post_name;
}

function soundcloud_podcast_export_dir($post) {
	$dir = $time = time();
	$dir = "/tmp/export-$post->ID-$time";
	mkdir($dir);
	return $dir;
}

function soundcloud_podcast_export_files($post, $track_id, $dir) {
	$wav = soundcloud_podcast_export_wav($post, $track_id, $dir);
	$mp3 = soundcloud_podcast_export_mp3($post, $track_id, $dir);
	if (! $wav || ! $mp3) {
		return false;
	}
	$files = [$wav, $mp3];
	$image = soundcloud_podcast_export_image($post);
	if ($image) {
		$files[] = $image;
	}
	$thumb = soundcloud_podcast_export_thumb($post);
	if ($thumb) {
		$files[] = $thumb;
	}
	return $files;
}

function soundcloud_podcast_export_wav($post, $track_id, $dir) {
	$url = "https://api.soundcloud.com/tracks/$track_id/download";
	$data = soundcloud_podcast_export_request($url);
	if (! $data) {
		return false;
	}
	$filename = soundcloud_podcast_export_id($post) . '.wav';
	$path = "$dir/$filename";
	$fh = fopen($path, 'w');
	fwrite($fh, $data);
	fclose($fh);
	return $path;
}

function soundcloud_podcast_export_mp3($post, $track_id, $dir) {
	$url = "https://api.soundcloud.com/tracks/$track_id/stream";
	$data = soundcloud_podcast_export_request($url);
	if (! $data) {
		return false;
	}
	$filename = soundcloud_podcast_export_id($post) . '.mp3';
	$path = "$dir/$filename";
	$fh = fopen($path, 'w');
	fwrite($fh, $data);
	fclose($fh);
	return $path;
}

function soundcloud_podcast_export_image($post) {
	$attachment_id = get_post_thumbnail_id($post->ID);
	if (! $attachment_id) {
		return false;
	}
	$attachment = wp_get_attachment_metadata($attachment_id);
	$uploads = wp_upload_dir();
	return "{$uploads['basedir']}/{$attachment['file']}";
}

function soundcloud_podcast_export_thumb($post) {
	$attachment_id = get_post_thumbnail_id($post->ID);
	if (! $attachment_id) {
		return false;
	}
	$attachment = wp_get_attachment_metadata($attachment_id);
	$image_path = soundcloud_podcast_export_image($post);
	$dir = dirname($image_path);
	return "$dir/{$attachment['sizes']['thumbnail']['file']}";
}

function soundcloud_podcast_export_request($url) {
	$stderr = fopen('php://stderr', 'w');
	$access_token = soundcloud_podcast_token();

	fwrite($stderr, "requesting $url\n");
	$rsp = wp_remote_get($url, [
		'headers' => [
			'Accept' => 'application/json; charset=utf-8',
			'Authorization' => "OAuth $access_token"
		],
		'timeout' => 60
	]);

	if (is_wp_error($rsp)) {
		fwrite($stderr, "Error: " . $rsp->get_error_message() . "\n");
		return false;
	}

	$status = wp_remote_retrieve_response_code($rsp);
	$body = wp_remote_retrieve_body($rsp);

	if ($status != 200) {
		fwrite($stderr, "Error: HTTP $status\n");
		fwrite($stderr, "$body\n");
		return false;
	}

	return $body;
}

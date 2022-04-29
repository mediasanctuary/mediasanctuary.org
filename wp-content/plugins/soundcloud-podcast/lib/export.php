<?php

class ContentException extends Exception { }

function soundcloud_podcast_export($post_id = null) {
	$stderr = fopen('php://stderr', 'w');
	// There are two nested try/catch blocks here. This outer one will disable
	// exporting if it catches any kind of exception.
	try {
		$exporting = get_option('soundcloud_podcast_exporting');
		if ($exporting) {
			fwrite($stderr, "Internet Archive export is already running\n");
			return;
		}
		$enabled = get_field('internet_archive_export', 'options');
		if (empty($enabled)) {
			fwrite($stderr, "Internet Archive export is disabled\n");
			return;
		}
		update_option('soundcloud_podcast_exporting', true, false);
		if ($post_id) {
			$post = get_post($post_id);
		} else {
			$post = soundcloud_podcast_export_next_post();
		}
		if ($post) {
			$url = get_permalink($post->ID);
			echo "exporting $post->post_title ($post->ID)\n";
			$track_id = get_post_meta($post->ID, 'soundcloud_podcast_id', true);
			$dir = soundcloud_podcast_export_dir($post);

			// This inner try/catch assigns the post with an Internet Archive ID
			// of -1 and does *not* disable exporting if it catches a
			// ContentException. Other kinds of exceptions should get caught by
			// the outer try/catch.
			try {
				$files = soundcloud_podcast_export_files($post, $track_id, $dir);
				$id = soundcloud_podcast_export_upload($post, $files);
			} catch(ContentException $err) {
				update_post_meta($post->ID, 'internet_archive_error', $err->getMessage());
				$errormsg = "Error exporting <$url|$post->post_title> ($post->ID): " . $err->getMessage();
				soundcloud_podcast_update_slack($errormsg);
				fwrite($stderr, "$errormsg\n");
				$id = -1;
				$files = $dir;
			}

			if ($id) {
				update_post_meta($post->ID, 'internet_archive_id', $id);
			}
			soundcloud_podcast_export_cleanup($files);
		}
		if ($id != -1) {
			$export_url = "https://archive.org/details/$id";
			soundcloud_podcast_update_slack("Exported <$url|$post->post_title> to <$export_url|archive.org>");
		}
		echo "exported $export_url\n";
	} catch (Exception $err) {
		update_field('internet_archive_export', false, 'options');
		$errormsg = $err->getMessage();
		if (! empty($post)) {
			$errormsg = "Error exporting <$url|$post->post_title> ($post->ID): $errormsg";
		}
		soundcloud_podcast_update_slack($errormsg);
		fwrite($stderr, "$errormsg\n");
	}
	fclose($stderr);
	update_option('soundcloud_podcast_exporting', false, false);
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
	$maxlength = 100;
	$words = explode('-', "media-sanctuary-{$post->post_name}");
	$id = array_shift($words);
	foreach ($words as $word) {
		if (strlen("$id-$word") > $maxlength) {
			break;
		}
		$id = "$id-$word";
	}
	return $id;
}

function soundcloud_podcast_export_dir($post) {
	$time = time();
	$dir = "/tmp/export-$post->ID-$time";
	mkdir($dir);
	return $dir;
}

function soundcloud_podcast_export_files($post, $track_id, $dir) {
	$audio = soundcloud_podcast_export_audio($post, $track_id, $dir);
	if (! $audio) {
		return false;
	}
	$files = [$audio];
	$image = soundcloud_podcast_export_image($post);
	if ($image) {
		$files[] = $image;
	}
	$thumb = soundcloud_podcast_export_thumb($post, $dir);
	if ($thumb) {
		$files[] = $thumb;
	}
	return $files;
}

function soundcloud_podcast_export_audio($post, $track_id, $dir) {
	$url = "https://api.soundcloud.com/tracks/$track_id/download";
	echo "downloading $url\n";
	list($data, $file_ext) = soundcloud_podcast_export_request($url);
	if (! $data) {
		return false;
	}
	$filename = soundcloud_podcast_export_id($post) . $file_ext;
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

function soundcloud_podcast_export_thumb($post, $dir) {
	$attachment_id = get_post_thumbnail_id($post->ID);
	if (! $attachment_id) {
		return false;
	}
	$attachment = wp_get_attachment_metadata($attachment_id);
	$image_path = soundcloud_podcast_export_image($post);
	$image_dir = dirname($image_path);
	if (empty($attachment['sizes']['internet_archive_thumbnail'])) {
		return false;
	}
	$from_path = "$image_dir/{$attachment['sizes']['internet_archive_thumbnail']['file']}";
	if (! file_exists($from_path)) {
		return false;
	}
	$to_path = "$dir/__ia_thumb.jpg";
	copy($from_path, $to_path);
	return $to_path;
}

function soundcloud_podcast_export_request($url) {
	$access_token = soundcloud_podcast_token();

	$rsp = wp_remote_get($url, [
		'headers' => [
			'Accept' => 'application/json; charset=utf-8',
			'Authorization' => "OAuth $access_token"
		],
		'timeout' => 60
	]);

	if (is_wp_error($rsp)) {
		throw new Exception("Error downloading $url (" . $rsp->get_error_message() . ")");
	}

	$status = wp_remote_retrieve_response_code($rsp);
	$body = wp_remote_retrieve_body($rsp);

	if ($status != 200) {
		$base_url = get_bloginfo('wpurl');
		$auth_url = "$base_url/wp-admin/admin-ajax.php?action=soundcloud_podcast_login";
		soundcloud_podcast_update_slack("It looks like the SoundCloud API key has expired. <$auth_url|Reconnect>");
		throw new Exception("Error downloading $url (HTTP $status)");
	}

	$type = $rsp['headers']['content-type'];
	if ($type == 'audio/wav') {
		$file_ext = '.wav';
	} else if ($type == 'audio/mpeg') {
		$file_ext = '.mp3';
	} else if ($type == 'audio/aac') {
		$file_ext = '.m4a';
	} else if ($type == 'audio/aiff') {
		$file_ext = '.aiff';
	} else {
		throw new ContentException("Invalid content-type: $type");
	}

	return [$body, $file_ext];
}

function soundcloud_podcast_export_upload($post, $file_list) {
	if (empty($post) || empty($file_list)) {
		return false;
	}

	$ia = getenv('HOME') . '/bin/ia';
	$id = soundcloud_podcast_export_id($post);
	$files = implode(' ', $file_list);

	$date = substr($post->post_date, 0, 10);
	$year = substr($post->post_date, 0, 4);
	$subject = soundcloud_podcast_export_subject($post);

	$metadata_list = [
		'mediatype'   => 'audio',
		'identifier'  => $id,
		'title'       => $post->post_title,
		'description' => $post->post_content,
		'date'        => $date,
		'year'        => $year,
		'publicdate'  => $post->post_date,
		'addeddate'   => $post->post_date,
		'subject'     => $subject,
		'language'    => 'eng',
		'collection'  => 'mediasanctuaryaudio',
		'creator'     => 'The Sanctuary for Independent Media'
	];

	$metadata = [];
	foreach ($metadata_list as $key => $value) {
		if (empty($value)) {
			continue;
		}
		$item = escapeshellarg("$key:$value");
		$metadata[] = "--metadata=$item";
	}
	$metadata = implode(' ', $metadata);

	$command = "$ia --log upload $id $files $metadata";
	$result = null;
	$retval = null;

	exec($command, $result, $retval);

	if ($retval != 0) {
		$result = implode("\n", $result);
		echo "Error uploading files to archive.org: $result\n";
		throw new Exception("Error uploading files to archive.org: $result");
	}
	return $id;
}

function soundcloud_podcast_export_subject($post) {
	$categories = wp_get_post_terms($post->ID, 'category');
	$categories = array_map(function($cat) {
		return $cat->name;
	}, $categories);
	return implode('; ', $categories);
}

function soundcloud_podcast_export_cleanup($file_list) {
	if (empty($file_list)) {
		return false;
	} else if (is_string($file_list)) {
		$dir = $file_list;
		$file_list = [];
	}
	foreach ($file_list as $file) {
		if (substr($file, 0, 4) != '/tmp') {
			continue;
		}
		$dir = dirname($file);
		unlink($file);
	}
	if (! empty($dir)) {
		rmdir($dir);
	}
}

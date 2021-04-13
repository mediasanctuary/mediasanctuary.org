<?php
/**
 * Plugin Name: Soundcloud Podcast
 * Description: Converts RSS feed items with Soundcloud embeds into podcast episodes.
 * Version:     0.0.1
 * Author:      dphiffer
 * Author URI:  https://phiffer.org/
 */

function soundcloud_podcast_rss2_ns() {
	echo 'xmlns:itunes="http://www.itunes.com/dtds/podcast-1.0.dtd"';
}
add_action( 'rss2_ns', 'soundcloud_podcast_rss2_ns' );

function soundcloud_podcast_title( $rss_title ) {
	$title = get_bloginfo( 'name' );
	if ( preg_match( "/(.+) &#8211; $title/", $rss_title, $matches ) ) {
		$rss_title = $matches[1];
	}
	return $rss_title;
}
add_filter( 'wp_title_rss', 'soundcloud_podcast_title' );

function soundcloud_podcast_rss2_head() {
	$title = get_bloginfo( 'name' );
	$image = 'https://www.mediasanctuary.org/wp-content/uploads/2020/04/hmm-podcast.jpg';
	echo "\t<itunes:author><![CDATA[" . $title . "]]></itunes:author>\n";
	echo "\t<itunes:category text=\"News\">\n";
	echo "\t\t<itunes:category text=\"Daily News\" />\n";
	echo "\t</itunes:category>\n";
	echo "\t<itunes:image href=\"$image\" />\n";
	echo "\t<itunes:explicit>false</itunes:explicit>\n";
}
add_action( 'rss2_head', 'soundcloud_podcast_rss2_head' );

function soundcloud_podcast_rss2_item() {
	global $post;

	if ( ! defined( 'SOUNDCLOUD_PODCAST_CLIENT_ID' ) ) {
		return;
	}

	$regex = '/api\.soundcloud\.com\/tracks\/(\d+)/';
	if ( preg_match( $regex, $post->post_content, $matches ) ) {
		$track_id = $matches[1];
		$path = "/soundcloud-podcast/$post->ID/$track_id";
		$url = get_site_url( null, $path, 'https' );
		$length = soundcloud_podcast_get_length( $post, $track_id );
		if ( ! empty( $length ) ) {
			echo "<enclosure url=\"$url\" length=\"$length\" type=\"audio/mpeg\" />\n";
		}
	}
}
add_action( 'rss2_item', 'soundcloud_podcast_rss2_item' );

function soundcloud_podcast_content( $content ) {
	if ( is_feed() ) {
		$regex = '#<p><iframe[^>]+></iframe></p>#';
		$content = preg_replace( $regex, '', $content );
	}
	return $content;
}
add_action( 'the_content', 'soundcloud_podcast_content' );

function soundcloud_podcast_get_length( $post, $track_id ) {

	try {
		$cache_key = "soundcloud_podcast_length_$track_id";
		$length = get_post_meta( $post->ID, $cache_key, true );
		if ( ! empty( $length ) ) {
			return $length;
		}

		$client_id = 'client_id=' . SOUNDCLOUD_PODCAST_CLIENT_ID;
		$url = "https://api.soundcloud.com/tracks/$track_id/stream?$client_id";
		$rsp = wp_remote_request( $url, array(
			'method' => 'HEAD',
			'redirection' => 5
		) );

		if ( is_array( $rsp ) && ! is_wp_error( $rsp ) ) {
			$length = $rsp['headers']['content-length'];
			update_post_meta( $post->ID, $cache_key, $length );
			return $length;
		}
	} catch (Exception $err) {
		return null;
	}
	return null;
}

function soundcloud_podcast_template_redirect() {
	try {
		$regex = '/^\/soundcloud-podcast\/(\d+)\/(\d+)/';
		if ( preg_match( $regex, $_SERVER['REQUEST_URI'], $matches ) ) {
			$post_id = $matches[1];
			$track_id = $matches[2];
			$client_id = 'client_id=' . SOUNDCLOUD_PODCAST_CLIENT_ID;
			$url = "https://api.soundcloud.com/tracks/$track_id/stream?$client_id";
			$rsp = wp_remote_get( $url, array(
				'redirection' => 0
			) );

			if ( is_array( $rsp ) && ! is_wp_error( $rsp ) ) {
				$url = $rsp['headers']['location'];
				header("Location: $url");
				exit;
			}
		}
	} catch (Exception $err) {
		return;
	}
}
add_action( 'template_redirect', 'soundcloud_podcast_template_redirect' );

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
				'key' => 'soundcloud_podcast_track_id',
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
			WHERE meta_key = 'soundcloud_podcast_track_id'
			   OR meta_key = 'soundcloud_podcast_url'
		");
		foreach ($meta_rows as $row) {
			if ($row->meta_key == 'soundcloud_podcast_track_id') {
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
			file_put_contents('last-request.json', $msg);
			return;
		}
	}
	$json = wp_remote_retrieve_body($rsp);
	file_put_contents('last-request.json', $json);

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

function soundcloud_podcast() {
	global $post;

	if (empty($post)) {
		return;
	}

	$track_id = get_post_meta($post->ID, 'soundcloud_podcast_id', true);
	if (empty($track_id)) {
		return;
	}

	$client_id = SOUNDCLOUD_PODCAST_CLIENT_ID;
	$audio_src = "https://api.soundcloud.com/tracks/$track_id/stream?client_id=$client_id";

	$soundcloud_link = '';
	$soundcloud_url = get_post_meta($post->ID, 'soundcloud_podcast_url', true);
	if (! empty($soundcloud_url)) {
		$soundcloud_link = "<a href=\"$soundcloud_url\" class=\"soundcloud-podcast__link\" target=\"_blank\">Listen on SoundCloud</a>";
	}

	echo <<<END
<div class="soundcloud-podcast">
	<audio src="$audio_src" controls class="soundcloud-podcast__player">
		<a href="$audio_src">Listen</a>
	</audio>
	$soundcloud_link
</div>
END;
}

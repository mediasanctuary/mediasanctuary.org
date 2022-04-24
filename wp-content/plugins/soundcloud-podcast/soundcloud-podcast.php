<?php
/**
 * Plugin Name: Soundcloud Podcast
 * Description: Converts RSS feed items with Soundcloud embeds into podcast episodes.
 * Version:     0.0.2
 * Author:      dphiffer
 * Author URI:  https://phiffer.org/
 */

require_once __DIR__ . '/lib/auth.php';
require_once __DIR__ . '/lib/rss.php';
require_once __DIR__ . '/lib/cli.php';
require_once __DIR__ . '/lib/import.php';
require_once __DIR__ . '/lib/export.php';
require_once __DIR__ . '/lib/inventory.php';
require_once __DIR__ . '/lib/categories.php';

add_image_size('internet_archive_thumbnail', 280, 0);

function soundcloud_podcast() {
	global $post;

	if (empty($post)) {
		return;
	}

	$track_id = get_post_meta($post->ID, 'soundcloud_podcast_id', true);
	if (empty($track_id)) {
		return;
	}

	$sources = [];

	$soundcloud_link = '';
	$soundcloud_url = get_post_meta($post->ID, 'soundcloud_podcast_url', true);
	if (! empty($soundcloud_url)) {
		$soundcloud_link = "<a href=\"$soundcloud_url\" class=\"soundcloud-podcast__link\">Listen on SoundCloud</a>";
	}

	$internet_archive_link = '';
	$internet_archive_id = get_post_meta($post->ID, 'internet_archive_id', true);
	if (! empty($internet_archive_id) && $internet_archive_id != -1) {
		$internet_archive_link = "<a href=\"https://archive.org/details/$internet_archive_id\" class=\"soundcloud-podcast__link\">Listen on Internet Archive</a>";
		$sources[] = "https://archive.org/download/$internet_archive_id/$internet_archive_id.mp3";
	}

	$sources[] = "/wp-json/soundcloud-podcast/v1/stream/$track_id";

	$source_elements = '';
	foreach ($sources as $src) {
		$source_elements .= "<source src=\"$src\" type=\"audio/mpeg\"/>\n";
	}

	echo <<<END
<div class="soundcloud-podcast">
	<audio controls class="soundcloud-podcast__player">
		$source_elements
	</audio>
	$internet_archive_link
	$link_separator
	$soundcloud_link
</div>
END;
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

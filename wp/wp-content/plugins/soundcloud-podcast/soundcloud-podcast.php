<?php
/**
 * Plugin Name: Soundcloud Podcast
 * Description: Converts RSS feed items with Soundcloud embeds into podcast episodes.
 * Version:     0.0.2
 * Author:      dphiffer
 * Author URI:  https://phiffer.org/
 */

require_once __DIR__ . '/lib/rss.php';
require_once __DIR__ . '/lib/cli.php';
require_once __DIR__ . '/lib/import.php';
require_once __DIR__ . '/lib/inventory.php';

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

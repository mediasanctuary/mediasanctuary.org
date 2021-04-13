<?php

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

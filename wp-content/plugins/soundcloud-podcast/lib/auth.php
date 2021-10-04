<?php

function soundcloud_podcast_token() {
	$now = time();
	$token = get_option('soundcloud_podcast_token', null);
	if ($token) {
		$token = json_decode($token, 'as hash');
	}
	if (empty($token) || $now >= $token['expires']) {
		$rsp = wp_remote_post('https://api.soundcloud.com/oauth2/token', [
			'headers' => [
				'Content-Type' => 'application/x-www-form-urlencoded'
			],
			'body' => [
				'client_id' => SOUNDCLOUD_PODCAST_CLIENT_ID,
				'client_secret' => SOUNDCLOUD_PODCAST_CLIENT_SECRET,
				'grant_type' => 'client_credentials'
			]
		]);
		$body = wp_remote_retrieve_body($rsp);
		$token = json_decode($body, 'as hash');
		$token['expires'] = time() + $token['expires_in'];
		$token_json = json_encode($token);
		update_option('soundcloud_podcast_token', $token_json);
	}
	return $token['access_token'];
}

add_action('rest_api_init', function() {
	register_rest_route('soundcloud-podcast/v1', '/stream/(?P<id>\d+)', [
		'methods' => 'GET',
		'callback' => 'soundcloud_podcast_stream'
	]);
});

function soundcloud_podcast_stream($params) {
	$access_token = soundcloud_podcast_token();
	header('Content-Type: audio/mpeg');
	$url = "https://api.soundcloud.com/tracks/{$params['id']}/stream";
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HTTPHEADER, [
		'Accept: application/json; charset=utf-8',
		"Authorization: OAuth $access_token"
	]);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
	curl_setopt($ch, CURLOPT_WRITEFUNCTION, function($curl, $data) {
		echo $data;
		ob_flush();
		flush();
		return strlen($data);
	});
	curl_exec($ch);
	curl_close($ch);
}

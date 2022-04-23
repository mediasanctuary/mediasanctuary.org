<?php

add_action('wp_ajax_soundcloud_podcast_login', function() {
	$base_url = get_bloginfo('wpurl');
	$query = http_build_query([
		'client_id' => SOUNDCLOUD_PODCAST_CLIENT_ID,
		'redirect_uri' => "$base_url/wp-admin/admin-ajax.php?action=soundcloud_podcast_auth_code",
		'response_type' => 'code'
	]);
	$url = "https://api.soundcloud.com/connect?$query";
	header("Location: $url");
	exit;
});

add_action('wp_ajax_soundcloud_podcast_auth_code', function() {
	$base_url = get_bloginfo('wpurl');
	$rsp = wp_remote_post('https://api.soundcloud.com/oauth2/token', [
		'headers' => [
			'Content-Type' => 'application/x-www-form-urlencoded'
		],
		'body' => [
			'client_id' => SOUNDCLOUD_PODCAST_CLIENT_ID,
			'client_secret' => SOUNDCLOUD_PODCAST_CLIENT_SECRET,
			'grant_type' => 'authorization_code',
			'code' => $_GET['code'],
			'redirect_uri' => "$base_url/wp-admin/admin-ajax.php?action=soundcloud_podcast_auth_code"
		]
	]);
	$body = wp_remote_retrieve_body($rsp);
	$token = json_decode($body, 'as hash');
	soundcloud_podcast_save_token($token);
	header('Location: /wp-admin/admin.php?page=soundcloud');
	exit;
});

function soundcloud_podcast_save_token($token) {
	$token['expires'] = time() + $token['expires_in'];
	$token_json = json_encode($token);
	update_option('soundcloud_podcast_token', $token_json);
}

function soundcloud_podcast_token() {
	$base_url = get_bloginfo('wpurl');
	$now = time();
	$next_run = $now + 36 * 60;
	$token = get_option('soundcloud_podcast_token', null);
	if (empty($token)) {
		error_log("No SoundCloud auth token found.");
		exit;
	}
	$token = json_decode($token, 'as hash');
	if ($next_run >= $token['expires']) {
		$rsp = wp_remote_post('https://api.soundcloud.com/oauth2/token', [
			'headers' => [
				'Content-Type' => 'application/x-www-form-urlencoded'
			],
			'body' => [
				'client_id' => SOUNDCLOUD_PODCAST_CLIENT_ID,
				'client_secret' => SOUNDCLOUD_PODCAST_CLIENT_SECRET,
				'grant_type' => 'refresh_token',
				'refresh_token' => $token['refresh_token'],
				'redirect_uri' => "$base_url/wp-admin/admin-ajax.php?action=soundcloud_podcast_auth_code"
			]
		]);
		$body = wp_remote_retrieve_body($rsp);
		$token = json_decode($body, 'as hash');
		soundcloud_podcast_save_token($token);
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

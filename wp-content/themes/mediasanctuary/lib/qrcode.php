<?php

$labels = [
	'name'               => 'QR Codes',
	'singular_name'      => 'QR Codes',
	'add_new'            => 'Add New QR Code',
	'add_new_item'       => 'Add New QR Code',
	'edit_item'          => 'Edit QR Code',
	'new_item'           => 'QR Code',
	'view_item'          => 'View QR Code',
	'search_items'       => 'Search QR Codes',
	'not_found'          => 'No QR Codes found',
	'not_found_in_trash' => 'No QR Codes found in Trash',
	'all_items'          => 'All QR Codes',
	'menu_name'          => 'QR Codes',
	'name_admin_bar'     => 'QR Codes'
];

register_post_type(
	'qrcode',
	[
		'labels'        => $labels,
		'public'        => true,
		'hierarchical'  => false,
		'show_ui'       => true,
		'menu_position' => 40,
		'menu_icon'     => 'dashicons-admin-links',
		'has_archive'   => true,
		'show_in_rest'  => true,
		'supports'      => ['title', 'revisions'],
		'taxonomies'    => [],
		'rewrite'       => [
			'slug'      => 'qr'
		]
	]
);

add_action('wp_ajax_qrcode', function() {
	$id = null;
	if (!empty($_GET['id'])) {
		$id = intval($_GET['id']);
	}
	$url = qr_code_url($id);
	header('Content-Type: application/json');
	echo json_encode([
		'url' => $url
	]);
	exit;
});

function qr_code_url($id) {
	$uploads = wp_get_upload_dir();
	$uploads_dir = $uploads['basedir'];
	$uploads_url = $uploads['baseurl'];

	if ($id) {
		$post = get_post($id);
		$permalink = get_permalink($post);
		$rendered_url = get_post_meta($id, 'qr_rendered_url', true);
	}

	// QR Code is not published yet
	if (empty($post) || isset($post) && $post->post_status != 'publish') {
		return get_asset_url('img/qr-default.png');
	}

	$qr_path = "$uploads_dir/qrcodes/qr-$post->post_name.png";
	$qr_url = "$uploads_url/qrcodes/qr-$post->post_name.png";

	// QR Code is published, the URL is up to date, and the file exists
	if ($rendered_url == $permalink && file_exists($qr_path)) {
		return $qr_url;
	}

	// Delete a QR Code with an outdated URL if it exists
	if (!empty($rendered_url)) {
		$rendered_post_name = basename($rendered_url);
		$rendered_filename = "$uploads_dir/qrcodes/qr-$rendered_post_name.png";
		if (file_exists($rendered_filename)) {
			unlink($rendered_filename);
		}
	}

	// Okay, let's make a QR Code!
	$dir = dirname(__DIR__);
	$filename = tempnam('/tmp', 'qrcode');
	exec("$dir/node_modules/qrcode/bin/qrcode --width 980 --output $filename $permalink", $output, $return_code);

	// Something went wrong generating the QR Code
	if ($return_code !== 0) {
		error_log("Error generating QR Code $filename to $permalink in $dir");
		error_log(implode("\n", $output));
		return get_asset_url('img/qr-error.png');
	}

	// Ensure there's a 'qrcodes' folder
	if (!file_exists("$uploads_dir/qrcodes")) {
		@mkdir("$uploads_dir/qrcodes", 0755);
	}

	// Add human-readable URL to the image
	preg_match('/^https?:\/\/(.+?)\/$/', $permalink, $link);
	$image = imagecreatefrompng($filename);
	$black = imagecolorallocate($image, 0, 0, 0);
	$font = dirname(__DIR__) . '/fonts/IBMPlexMono-Regular.ttf';
	imagettftext($image, 18, 0, 104, 910, $black, $font, $link[1]);
	imagepng($image, $qr_path);
	imagedestroy($image);

	// Double check that the file exists where we expect it to
	if (!file_exists($qr_path)) {
		return get_asset_url('img/qr-error.png');
	}

	// Delete the temp file
	unlink($filename);

	// Update the metadata
	update_post_meta($id, 'qr_rendered_url', $permalink);

	// Done!
	return $qr_url;
}

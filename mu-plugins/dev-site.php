<?php
/*

Loading via the $dev_host hostname or with X-Dev-Site: 1 header set will
adjust the site to use the $dev_theme and load $dev_plugins.

See: https://addons.mozilla.org/en-US/firefox/addon/modify-header-value/

*/
$dev_host = 'local.mediasanctuary.org';
$dev_theme = 'mediasanctuary';
$dev_plugins = array(
	'advanced-custom-fields-pro/acf.php'
);

$headers = array();
if ( function_exists( 'apache_request_headers' ) ) {
	$headers = apache_request_headers();
}

if ( ! empty( $headers['Host'] ) && $headers['Host'] == $dev_host ||
     ! empty( $headers['X-Dev-Site'] ) && $headers['X-Dev-Site'] == '1' ) {
	add_filter( 'template', function() use ( $dev_theme ) {
		return $dev_theme;
	});
	add_filter( 'stylesheet', function() use ( $dev_theme ) {
		return $dev_theme;
	});
	add_filter( 'option_active_plugins', function() use ( $dev_plugins ) {
		return $dev_plugins;
	});
}

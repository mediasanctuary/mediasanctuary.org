<?php
/**
 * Plugin Name: Feed Import
 * Description: Imports RSS feed items and creates new posts.
 * Version:     0.0.1
 * Author:      dphiffer
 * Author URI:  https://phiffer.org/
 */

require_once __DIR__ . '/plugin.php';
require_once __DIR__ . '/feed.php';
require_once __DIR__ . '/post.php';

add_action('plugins_loaded', function() {
	if (!defined('FEED_IMPORT') || !is_array(FEED_IMPORT)) {
		return;
	}
	$plugin = new \FeedImport\Plugin(FEED_IMPORT);
});
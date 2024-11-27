<?php

namespace FeedImport;

class Plugin {

	public $feeds;

	function __construct($feeds = []) {
		$this->feeds = $feeds;
		if (class_exists('WP_CLI')) {
			\WP_CLI::add_command('feed-import', [$this, 'import']);
		}
	}

	function import($args) {
		foreach ($this->feeds as $url) {
			$feed = new Feed($url);
			$feed_data = $feed->import();
			foreach ($feed_data as $post_data) {
				$post = new Post($post_data);
				if (!empty($args)) {
					if ($post->has_id($args[0])) {
						$post->save();
						echo $post->title() . "\n";
						break;
					}
				} else if ($post->has_updates()) {
					$post->save();
					echo $post->title() . "\n";
				}
			}
		}
	}

}
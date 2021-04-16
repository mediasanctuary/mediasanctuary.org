<?php

function db_migrate_v3() {
	echo "Migration number 3:\n";
	echo "- Convert each 'press-coverage' post into a generic 'post'\n";
	echo "- Add each migrated post to the 'Press Coverage' category\n";
	echo "\n";

	$news = term_exists('Sanctuary News', 'category');
	$news_id = $news['term_id'];

	$press = term_exists('Press Coverage', 'category');
	if (! empty($press)) {
		$press_id = $press['term_id'];
	} else {
		$press = wp_insert_term('Press Coverage', 'category', [
			'parent' => $news_id
		]);
		$press_id = $press['term_id'];
	}

	$posts = get_posts([
		'post_type' => 'press-coverage',
		'posts_per_page' => -1
	]);
	foreach ($posts as $post) {
		echo "Migrating $post->post_title ($post->ID)\n";
		wp_update_post([
			'ID' => $post->ID,
			'post_type' => 'post',
			'post_category' => [$news_id, $press_id]
		]);
	}
}

<?php

function db_migrate_v4() {
	echo "Migration number 4:\n";
	echo "- Update HMM stories with old Internet Archive embeds\n";
	echo "- Remove redundant images in the post_content\n";
	echo "\n";

	global $post;

	$all = new WP_Query([
		'posts_per_page' => -1
	]);

	$ia_regex = '#<iframe.+?src="https://archive.org/embed/([^&"]+).+?</iframe>#ms';
	$img_regex = '#<img[^>]+>#ms';

	while ($all->have_posts()) {
		$all->the_post();
		if (! is_story_post($post)) {
			continue;
		}
		if (preg_match($ia_regex, $post->post_content, $matches)) {
			$internet_archive_id = str_replace('+', ' ', $matches[1]);
			echo "Updating $post->post_title ($post->ID) with Internet Archive ID $internet_archive_id\n";
			echo "    " . get_permalink($post) . "\n";
			$content = preg_replace($ia_regex, '', $post->post_content);
			wp_update_post([
				'ID' => $post->ID,
				'post_content' => $content
			]);
			update_post_meta($post->ID, 'internet_archive_id', $internet_archive_id);
		}
		if (preg_match($img_regex, $post->post_content, $matches) &&
		    has_post_thumbnail($post)) {
			echo "Updating $post->post_title ($post->ID) with redundant content image\n";
			echo "    " . get_permalink($post) . "\n";
			$content = preg_replace($img_regex, '', $post->post_content);
			wp_update_post([
				'ID' => $post->ID,
				'post_content' => $content
			]);
		}
	}
}

<?php

function db_migrate_v2() {
	echo "Migration number 2:\n";
	echo "- For each 'post' post type add it to the 'Sanctuary News' category\n";
	echo "- For each 'podcast' post type convert it into a 'post' and apply an 'audio' format\n";
	echo "\n";

	$terms = get_terms([
		'taxonomy' => 'category',
		'hide_empty' => false
	]);
	$cats = [];
	foreach ($terms as $term) {
		$cats[$term->slug] = $term->term_id;
	}

	if (empty($cats['sanctuary-news'])) {
		$term = wp_create_term('Sanctuary News', 'category');
		$cats['sanctuary-news'] = $term['term_id'];
	}

	$news = get_posts([
		'post_type' => 'post',
		'posts_per_page' => -1
	]);
	$news_cat_id = $cats['sanctuary-news'];
	foreach ($news as $post) {
		echo "Migrating $post->post_title ($post->ID)\n";
		echo "    assigning category 'Sanctuary News' ($news_cat_id)\n";
		wp_set_post_terms($post->ID, [$news_cat_id], 'category');
	}

	$podcasts = get_posts([
		'post_type' => 'podcast',
		'posts_per_page' => -1
	]);

	foreach ($podcasts as $post) {
		echo "Migrating $post->post_title ($post->ID)\n";

		$terms = wp_get_post_terms($post->ID, 'podcast_categories');
		$stories_cat_id = $cats['stories'];
		$post_cats = [$stories_cat_id];

		foreach ($terms as $term) {
			if (empty($cats[$term->slug])) {
				$t = wp_insert_term($term->name, 'category', [
					'parent' => $cats['stories'],
					'slug' => $term->slug
				]);
				$term_id = $t['term_id'];
				$post_cats[] = $term_id;
				$cats[$term->slug] = $term_id;
				echo "    created new category '$term->name' ($term_id)\n";
			} else {
				$post_cats[] = $cats[$term->slug];
				echo "    assigning category '$term->name' ({$cats[$term->slug]})\n";
			}
		}

		wp_update_post([
			'ID' => $post->ID,
			'post_type' => 'post',
			'post_category' => $post_cats
		]);
		set_post_format($post->ID, 'audio');
		echo "    set post type to 'post' format to 'audio'\n";
	}
}

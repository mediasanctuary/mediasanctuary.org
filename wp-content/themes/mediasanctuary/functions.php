<?php

require_once 'lib/post-types.php';
require_once 'lib/redirects.php';
require_once 'lib/roles.php';
require_once 'lib/qrcode.php';
require_once 'lib/dbug.php';
require_once 'db/migrate.php';

add_filter('wp_nav_menu_items', function($items) {
	$items .= <<<END
		<li class="menu-item nav-link--mobile"><a href="http://stream.woocfm.org:8000/wooc">Sanctuary Radio</a></li>
		<li class="menu-item nav-link--mobile"><a href="/initiatives/sanctuary-tv/">Sanctuary TV</a></li>
		<li class="menu-item nav-link--mobile"><a href="/get-involved/donate/">Donate</a></li>
END;
	return $items;
});

add_filter('acf/prepare_field/name=category_soundcloud_playlist', function($field) {
	if (function_exists('soundcloud_podcast_playlists')) {
		$playlists = soundcloud_podcast_playlists();
		foreach ($playlists['list'] as $playlist) {
			$id = $playlist['id'];
			$title = $playlist['title'];
			$field['choices'][$id] = $title;
		}
	}
	return $field;
});

add_filter('soundcloud_podcast_categories', function($categories) {
	global $wpdb;
	$results = $wpdb->get_results("
		SELECT term_id, meta_value AS playlist_id
		FROM {$wpdb->prefix}termmeta
		WHERE meta_key = 'category_soundcloud_playlist'
	");
	$categories = [];
	foreach ($results as $result) {
		$categories[$result->term_id] = $result->playlist_id;
	}
	return $categories;
});

add_filter('pre_get_posts', function($query) {
	if (is_archive()) {
		$query->set('posts_per_page', 20);
	}
	return $query;
});

add_filter('get_the_archive_title', function ($title) {
	if (is_category()) {
		return single_cat_title( '', false );
	} else if ($title == 'Archives: <span>People Power</span>') {
		return 'People Power';
	}
	return $title;
});

add_filter('category_link', function($url) {
	$home_url = home_url();
	return str_replace("$home_url/category", $home_url, $url);
});

add_action('after_setup_theme', function() {
	add_theme_support('post-thumbnails');
	// add_theme_support('title-tag');
	add_theme_support('post-formats', [
		'audio',
		'video'
	]);
});

add_action('wp_enqueue_scripts', function() {
	list($src, $version) = get_asset_url('js/main.js', true);
	wp_enqueue_script( '_sanctuary_slick', get_template_directory_uri() . '/js/slick.min.js', array(), $version, true );
	wp_enqueue_script('main', $src, ['jquery'], $version, true);
});

add_action('acf/init', function() {
	require_once('blocks/blocks.php');
	if (function_exists('acf_add_options_page')) {
		acf_add_options_page([
			'page_title' => 'Site Options',
			'menu_title' => 'Site Options',
			'menu_slug'  => 'options',
			'capability' => 'activate_plugins',
		]);
		acf_add_options_page([
			'page_title' => 'Redirects',
			'menu_title' => 'Redirects',
			'menu_slug'  => 'redirects',
			'position'   => '20',
			'icon_url'   => 'dashicons-redo',
			'capability' => 'activate_plugins'
		]);
		acf_add_options_page([
			'page_title' => 'SoundCloud',
			'menu_title' => 'SoundCloud',
			'menu_slug'  => 'soundcloud',
			'capability' => 'create_users',
		]);
	}
});

add_filter('acf/settings/load_json', function($path) {
	return get_stylesheet_directory() . '/acf';
});

add_filter('acf/settings/save_json', function($path) {
	return get_stylesheet_directory() . '/acf';
});

add_action('wp_head', function() {
	if (! function_exists('get_field')) {
		return;
	}
	$ua_code = get_field('ga_ua_code', 'options');
	if (empty($ua_code)) {
		return;
	}
	echo <<<END

<script async src="https://www.googletagmanager.com/gtag/js?id=$ua_code"></script>
<script>
window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
gtag('js', new Date());
gtag('config', '$ua_code');
</script>

END;
});

add_action('admin_enqueue_scripts', function() {
	$dir = get_template_directory();
	$css_src = get_template_directory_uri() . '/dist/admin.css';
	$css_version = filemtime("$dir/dist/admin.css");
	wp_enqueue_style('custom-admin', $css_src, [], $css_version);

	$js_src = get_template_directory_uri() . '/js/qrcode.js';
	$js_version = filemtime("$dir/js/qrcode.js");
	wp_enqueue_script('admin', $js_src, [], $js_version);

	$js_src = get_template_directory_uri() . '/js/admin.js';
	$js_version = filemtime("$dir/js/admin.js");
	wp_enqueue_script('admin', $js_src, ['jquery'], $js_version);
});

// Change 'Description' label to 'Credit' (wp-admin/post.php)
add_action('edit_form_after_title', function($post) {
	if ($post->post_type == 'attachment') {
		add_filter('gettext', function($translation) {
			if ($translation == 'Description') {
				return 'Credit';
			}
			return $translation;
		});
	}
});

// Change 'Description' label to 'Credit' (wp-admin/upload.php)
add_action('pre-upload-ui', function() {
	add_filter('gettext', function($translation) {
		if ($translation == 'Description') {
			return 'Credit';
		}
		return $translation;
	});
});

// Disable comments
add_action('admin_menu', function() {
	remove_menu_page( 'edit-comments.php' );
	remove_menu_page( 'tools.php' );
});

add_action('init', function() {
	remove_post_type_support( 'post', 'comments' );
	remove_post_type_support( 'page', 'comments' );
}, 100);

add_action('wp_before_admin_bar_render', function() {
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu('comments');
});

add_action('init', function() {
	setup_post_types();
	setup_redirects();
	setup_roles();
});

function asset_url($file) {
	echo get_asset_url($file);
}

function get_asset_url($file, $return_version = false) {
	$url  = get_stylesheet_directory_uri() . "/$file";
	$path = get_stylesheet_directory() . "/$file";
	$ver  = filemtime($path);
	if ($return_version) {
		return [$url, $ver];
	} else {
		return "$url?$ver";
	}
}

function get_category_links($categories, $parent = null) {
	$list = [];
	foreach ($categories as $category) {
		// Skip parent category
		if ($category->term_id == $parent) {
			continue;
		}
		// Skip categories that aren't children of the parent
		if (! empty($parent) && $category->parent != $parent) {
			continue;
		}
		$url = esc_url(get_category_link($category->term_id));
		$label = esc_html($category->name);
		$list[] = '<a href="' . $url . '" class="category" >' . $label . '</a>';
	}
	return $list;
}


function register_main_menu() {
  register_nav_menu('main-navigation',__( 'Main Navigation' ));
}
add_action( 'init', 'register_main_menu' );


// Social Meta Tags
function social_meta_tags() {
    global $post;
    $title = get_field('meta_title') ?: get_the_title();
    $url = get_the_permalink();
    $description = '';
    $type = 'article';
    $canonical = get_field('canonical_link');

    // Featured Image
    $thumb_url = get_asset_url('img/share.jpg');
    if ( has_post_thumbnail() ) {
    	$thumb_id = get_post_thumbnail_id();
    	$thumb_url_array = wp_get_attachment_image_src($thumb_id, 'full', true);
    	$thumb_url = $thumb_url_array[0];
    }

    // Conditionals
    if ( is_singular() ) {
      $d01 = strip_tags( $post->post_content );
      $d02 = strip_shortcodes( $d01 );
      $d03 = str_replace( array("\n", "\r", "\t"), '', $d02 );
      $description = get_field('meta_description') ?: mb_substr( $d03, 0, 300, 'utf8' );
    }
    if ( is_front_page() ) {
			$title = get_bloginfo( 'name' ).' - '.get_bloginfo( 'description' );
      $type = 'website';
    } else {
			$title = $title.' - '.get_bloginfo( 'name' );
		}
    if ( is_category() ) {
      $postType = get_post_type() == 'post' ? 'Stories' : get_post_type();
      $title = get_the_archive_title().' '.$postType.' - '.get_bloginfo( 'name' );;
      $term = get_queried_object();
      $description = strip_tags(get_field('category_description', "category_$term->term_id" ));
      $thumb_url = get_asset_url('img/share.jpg');
      $url = get_category_link( $term->term_id );
    }


    echo "\n";
    echo '<title>'.$title.'</title>' . "\n";
    echo '<meta name="description" content="'.$description.'"/>' . "\n";
    echo '<meta property="og:title" content="'.$title.'">' . "\n";
    echo '<meta property="og:description" content="'.$description.'">' . "\n";
    echo '<meta property="og:image" content="'.$thumb_url.'">' . "\n";
    echo '<meta property="og:url" content="'.$url.'">' . "\n";
    echo '<meta property="og:type" content="'.$type.'">' . "\n";

    echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
    echo '<meta name="twitter:title" content="'.$title.'">' . "\n";
    echo '<meta name="twitter:description" content="'.$description.'">' . "\n";
    echo '<meta name="twitter:image" content="'.$thumb_url.'">';

    if($canonical){
      echo '<link rel="canonical" href="'.$canonical.'" />';
    } else {
      echo '<link rel="canonical" href="'.$url.'" />';
    }
}
add_action( 'wp_head', 'social_meta_tags' );

add_action( 'wp_ajax_soundcloud_token_info', function() {
	header('Content-Type: application/json');
	$token = get_option('soundcloud_podcast_token', null);
	if (! $token) {
		$token_info = 'No auth token found.';
	} else {
		$token = json_decode($token, 'as hash');
		if ($token['expires'] > time()) {
			$token_info = 'API token will expire at ' . wp_date( DATE_RFC3339, $token['expires'] );
		} else {
			$token_info = 'API token expired at ' . wp_date( DATE_RFC3339, $token['expires'] );
		}
	}
	echo json_encode([
		'token_info' => $token_info
	]);
	exit;
});

function is_story_post($post) {
	$terms = get_the_terms($post, 'category');
	foreach ($terms as $term) {
		if ($term->slug == 'stories') {
			return true;
		}
	}
	$special_episode = get_field('special_episode', $post);
	if (!empty($special_episode)) {
		return true;
	}
	return false;
}

add_filter('the_title', function($title, $post) {
	if (get_field('special_episode', $post)) {
		return get_field('special_episode_title', $post);
	}
	return $title;
}, 10, 2);

add_action('pre_get_posts', function($query) {
	if ($query->is_main_query() && $query->get('post_type') == 'peoplepower') {
		if (empty($_GET['sort']) || $_GET['sort'] == 'recent') {
			$query->set('orderby', 'post_modified');
			$query->set('order', 'DESC');
		} else if ($_GET['sort'] == 'name') {
			$query->set('orderby', 'post_title');
			$query->set('order', 'ASC');
		}
	}
	return $query;
});

function audio_player() {
	global $post;

	if (empty($post)) {
		return;
	}

	$sources = [];
	$feed_import_link = '';
	$soundcloud_link = '';
	$internet_archive_link = '';

	$feed_import_audio = get_post_meta($post->ID, 'feed_import_audio', true);
	if (! empty($feed_import_audio)) {
		$sources[] = $feed_import_audio;
	}

	$feed_import_link = get_post_meta($post->ID, 'feed_import_link', true);
	if (! empty($feed_import_link)) {
		$feed_import_link = "<a href=\"$feed_import_link\" class=\"soundcloud-podcast__link\">Listen on SoundCloud</a>";
	}

	if (empty($feed_import_link)) {
		$soundcloud_id = get_post_meta($post->ID, 'soundcloud_podcast_id', true);
		if (! empty($soundcloud_id)) {
			$sources[] = "/wp-json/soundcloud-podcast/v1/stream/$soundcloud_id";
		}
		$soundcloud_url = get_post_meta($post->ID, 'soundcloud_podcast_url', true);
		if (! empty($soundcloud_url)) {
			$soundcloud_link = "<a href=\"$soundcloud_url\" class=\"soundcloud-podcast__link\">Listen on SoundCloud</a>";
		}
	}

	$internet_archive_id = get_post_meta($post->ID, 'internet_archive_id', true);
	if (! empty($internet_archive_id) && $internet_archive_id != -1) {
		$internet_archive_id = str_replace('https://archive.org/download/', '', $internet_archive_id);
		$internet_archive_link = "<a href=\"https://archive.org/details/$internet_archive_id\" class=\"soundcloud-podcast__link\">Listen on Internet Archive</a>";
		if (strpos($internet_archive_id, '/') == false) {
			$internet_archive_id = "$internet_archive_id/$internet_archive_id.mp3";
		}
		$internet_archive_id = preg_replace('/\.wav$/', '.mp3', $internet_archive_id);
		$sources[] = "https://archive.org/download/$internet_archive_id";
	}

	if (empty($sources)) {
		return;
	}

	$source_elements = '';
	foreach ($sources as $src) {
		$source_elements .= "<source src=\"$src\" type=\"audio/mpeg\"/>\n";
	}

	echo <<<END
<div class="soundcloud-podcast">
	<audio controls class="soundcloud-podcast__player">
		$source_elements
	</audio>
	$feed_import_link
	$internet_archive_link
	$soundcloud_link
</div>
END;
}

add_filter('feed_import_existing_query', function($query, $data) {
	// e.g., tag:soundcloud,2010:tracks/1964923891
	$guid_parts = explode('/', $data['guid']);
	$soundcloud_id = $guid_parts[1];
	return [
		'post_type' => 'post',
		'post_status' => 'any',
		'meta_query' => [
			'relation' => 'OR',
			[
				'key' => 'feed_import_guid',
				'value' => $data['guid'],
			], [
				'key' => 'soundcloud_podcast_id',
				'value' => $soundcloud_id,
			], [
				'key' => 'soundcloud_podcast_url',
				'value' => $data['link'],
			],
		]
	];
}, 10, 2);

add_filter('feed_import_post_category', function($category, $post) {
	if (preg_match('/^HMM/i', $post->data['title'])) {
		return 'Hudson Mohawk Magazine Episodes';
	}
	return 'Stories';
}, 10, 2);

function feed_import_post_date($date, $post) {
	$category = $post->category();
	$four_days = 60 * 60 * 24 * 4;
	$timezone = $date->getTimezone();

	if ($category == 'Stories' &&
		current_time('u') - $date->getTimestamp() < $four_days) {
		// If the track's timestamp is within 4 days, we should schedule
		// it for the next weekday at 6pm.
		$date = null;
	}

	if (empty($date)) {
		$schedule_at = 'Today 6pm';

		// If it's after Friday at 7pm, schedule for Monday at 6pm.
		if (current_time('w') == 5 && current_time('H') > 19 ||
		    current_time('w') == 6 ||
		    current_time('w') == 0) {
			$schedule_at = 'Monday 6pm';
		}

		$date = new \DateTime($schedule_at, $timezone);
	}

	return $date;
}
add_filter('feed_import_post_date', 'feed_import_post_date', 10, 2);
add_filter('feed_import_post_date_gmt', 'feed_import_post_date', 10, 2);

add_filter('feed_import_post_status', function($status, $post) {
	$date = $post->date();
	if ($date > current_time('Y-m-d H:i:s')) {
		return 'future';
	} else {
		return 'publish';
	}
}, 10, 2);

add_action('feed_import_post_saved', function($post, $action) {
	if (! defined('SLACK_WEBHOOK')) {
		return false;
	}
	$edit_url = home_url("/wp-admin/post.php?post=$post->id&action=edit");
	$view_url = get_permalink($post->id);
	$payload = [
		'type' => 'mrkdwn',
		'text' => "$action <$view_url|{$post->title()}> from <{$post->data['link']}|soundcloud.com> (<$edit_url|edit>)"
	];
	$rsp = wp_remote_post(SLACK_WEBHOOK, [
		'body' => [
			'payload' => json_encode($payload)
		]
	]);
}, 10, 2);
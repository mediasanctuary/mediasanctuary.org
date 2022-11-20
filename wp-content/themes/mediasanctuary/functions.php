<?php

require_once 'lib/post-types.php';
require_once 'lib/redirects.php';
require_once 'lib/roles.php';
require_once 'lib/dbug.php';
require_once 'db/migrate.php';

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
	return false;
}

function upload_init() {
	$url = parse_url($_SERVER['REQUEST_URI']);
	if (!session_id() && ($url['path'] == '/upload' || $url['path'] == '/upload/')) {
		session_start();
	}
}
add_action('init', 'upload_init');

function upload_person_by_email($email) {
	$posts = get_posts([
		'post_type' => 'peoplepower',
		'meta_key' => 'email',
		'meta_value' => $email
	]);
	if (empty($posts)) {
		return false;
	} else {
		$person = $posts[0];
		return $person;
	}
}

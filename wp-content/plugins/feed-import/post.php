<?php

namespace FeedImport;

class Post {

	public $id;
	public $data;

	function __construct($data) {
		$this->data = $data;
	}

	function save() {
		$existing = $this->get_existing();
		if ($existing) {
			$this->id = $existing->ID;
			wp_update_post([
				'ID'            => $this->id,
				'post_title'    => $this->title(),
				'post_content'  => $this->content(),
				'post_category' => $this->post_category(),
			]);
		} else {
			$this->id = wp_insert_post([
				'post_status'   => $this->status(),
				'post_title'    => $this->title(),
				'post_content'  => $this->content(),
				'post_date'     => $this->date(),
				'post_date_gmt' => $this->date_gmt(),
				'post_category' => $this->post_category(),
			]);
		}
		$this->update_metadata();
		$this->attach_image();
	}

	function has_updates() {
		$existing = $this->get_existing();
		if (empty($existing)) {
			return true;
		}
		$db_hash = get_post_meta($existing->ID, 'feed_import_hash', true);
		return ($this->get_content_hash() != $db_hash);
	}

	function has_id($id) {
		$existing = $this->get_existing();
		if (empty($existing)) {
			return false;
		}
		return $existing->ID == $id;
	}

	function update_metadata() {
		set_post_format($this->id, 'audio');
		update_post_meta($this->id, 'feed_import_guid', $this->data['guid']);
		update_post_meta($this->id, 'feed_import_link', $this->data['link']);
		update_post_meta($this->id, 'feed_import_audio', $this->data['audio']);
		update_post_meta($this->id, 'feed_import_duration', $this->data['duration']);
		update_post_meta($this->id, 'feed_import_hash', $this->get_content_hash());
	}

	function get_content_hash() {
		$plaintext = $this->data['guid'];
		$plaintext .= '|' . $this->title();
		$plaintext .= '|' . $this->content();
		$plaintext .= '|' . $this->data['link'];
		$plaintext .= '|' . $this->data['audio'];
		$plaintext .= '|' . $this->data['image'];
		$plaintext .= '|' . $this->data['duration'];
		return md5($plaintext);
	}

	function get_existing() {
		$existing_query = apply_filters('feed_import_existing_query', [
			'post_type' => 'post',
			'post_status' => 'any',
			'meta_query' => [
				[
					'key' => 'feed_import_guid',
					'value' => $this->data['guid']
				]
			]
		], $this->data);
		$posts = get_posts($existing_query);
		if (! empty($posts)) {
			return $posts[0];
		} else {
			return null;
		}
	}

	function status() {
		return apply_filters('feed_import_post_status', 'publish', $this);
	}

	function title() {
		return apply_filters('feed_import_post_title', $this->data['title'], $this);
	}

	function content() {
		$content = $this->data['description'];
		$content = $this->autolink_urls($content);
		$content = $this->format_paragraphs($content);
		$content = apply_filters('feed_import_post_content', $content, $this);
		return $content;
	}

	function autolink_urls($content) {
		// Look for URL-shaped text and add hyperlinks.
		// The regex is slightly modified from https://www.urlregex.com/
		$regex = '%(?:(?:https?|ftp)://)(?:\S+(?::\S*)?@|\d{1,3}(?:\.\d{1,3}){3}|(?:(?:[a-z\d\x{00a1}-\x{ffff}]+-?)*[a-z\d\x{00a1}-\x{ffff}]+)(?:\.(?:[a-z\d\x{00a1}-\x{ffff}]+-?)*[a-z\d\x{00a1}-\x{ffff}]+)*(?:\.[a-z\x{00a1}-\x{ffff}]{2,6}))(?::\d+)?(?:[^\s]*)?%iu';
		return preg_replace_callback($regex, function($matches) {

			$url = $matches[0];
			$last_char = substr($url, -1, 1);
			$punctuation = ['.', ',', '!', ';'];
			$postfix = '';

			if ($last_char == ')') {
				if (strpos($url, '(') === false) {
					// do not link ) of "(https://www.mediasanctuary.org/)"
					// but do link the ) of "https://en.wikipedia.org/wiki/Douglas_Davis_(artist)"
					$url = substr($url, 0, -1);
					$postfix = ')';
				}
			} else if (in_array($last_char, $punctuation)) {
				// do not link . of "https://www.mediasanctuary.org/."
				$url = substr($url, 0, -1);
				$postfix = $last_char;
			}

			$label = $url;

			// Remove the "https://www" part at the front of the label
			$label = preg_replace('%^https?://%i', '', $label);

			// Remove the trailing slash part of the label
			$label = preg_replace('%^([^/]+)/$%', '$1', $label);

			return "<a href=\"$url\">$label</a>$postfix";

		}, $content);
	}

	function format_paragraphs($content) {
		// Replace double-newlines (of various kinds) with paragraph elements,
		// each <p>...</p> wrapped in a WordPress core/paragraph block.
		return str_replace(
			["\r\n\r\n", "\n\r\n\r", "\n\n", "\r\r"],
			"</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>",
			"<!-- wp:paragraph -->\n<p>" . $content . "</p>\n<!-- /wp:paragraph -->"
		);
	}

	function date() {
		$date = new \DateTime($this->data['pubDate'], wp_timezone());
		$date = apply_filters('feed_import_post_date', $date, $this);
		return $date->format('Y-m-d H:i:s');
	}

	function date_gmt() {
		$date = new \DateTime($this->data['pubDate']);
		$date = apply_filters('feed_import_post_date_gmt', $date, $this);
		return $date->format('Y-m-d H:i:s');
	}

	function category() {
		return apply_filters('feed_import_post_category', '', $this);
	}

	function post_category() {
		// The wp_insert_post and wp_update_post functions expect an array of
		// term IDs, so we convert a more useful string to that format at the
		// very last minute.
		if (empty($this->category())) {
			return [];
		}
		$term = get_term_by('name', $this->category(), 'category');
		return [$term->term_id];
	}

	function attach_image() {
		if (empty($this->data['image'])) {
			return;
		}

		$image_url = $this->data['image'];
		$filename = basename($image_url);

		$image_id = get_post_meta($this->id, '_thumbnail_id', true);
		if (! empty($image_id)) {
			$image = get_post($image_id);
			if (! empty($image) && $image->post_title == $filename) {
				return;
			}
		}

		$rsp = wp_remote_get($image_url, [
			'timeout' => '90',
			'user-agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.11; rv:44.0) Gecko/20100101 Firefox/44.0'
		]);
		$status = wp_remote_retrieve_response_code($rsp);
		if ($status != 200) {
			error_log("Could not load image $image_url");
			return;
		}

		$image_data = wp_remote_retrieve_body($rsp);
		$content_type = $rsp['headers']['content-type'];

		$upload_dir = wp_upload_dir();
		$dir = $upload_dir['path'];
		if (! file_exists($dir)) {
			wp_mkdir_p($dir);
		}
		$path = "$dir/$filename";
		file_put_contents($path, $image_data);

		$filetype = wp_check_filetype($filename, null);
		$attachment = [
			'guid'           => "{$upload_dir['url']}/$filename",
			'post_mime_type' => $filetype['type'],
			'post_title'     => $filename,
			'post_content'   => '',
			'post_status'    => 'inherit'
		];
		$attach_id = wp_insert_attachment($attachment, $path);

		if (preg_match('/^image/', $content_type)) {
			require_once(ABSPATH . 'wp-admin/includes/image.php');
			$attach_data = wp_generate_attachment_metadata($attach_id, $path);
			wp_update_attachment_metadata($attach_id, $attach_data);
		}

		update_post_meta($this->id, '_thumbnail_id', $attach_id);
	}

}

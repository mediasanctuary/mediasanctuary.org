<?php

namespace FeedImport;

class Feed {

	public $url;
	public $xml;
	public $doc;
	public $items = [];

	function __construct($url) {
		$this->url = $url;
	}

	function import() {
		if ($this->load()) {
			$this->parse();
		}
		// print_r($this->items);
	}

	function load() {
		$cache_key = 'feed-import-cache-' . md5($this->url);
		$cached = get_option($cache_key);
		if ($this->valid_cache($cached)) {
			$this->xml = $cached['xml'];
		} else {
			$response = wp_remote_get($this->url);
			if (is_array($response) && !is_wp_error($response)) {
				$this->xml = $response['body'];
			} else {
				return false;
			}
			update_option($cache_key, [
				'created' => current_time('U', true),
				'xml' => $this->xml
			], false);
		}
		return true;
	}

	function valid_cache($cache) {
		$ttl = 60 * 60; // one hour
		$now = current_time('U', true);
		if (empty($cache)) {
			return false;
		}
		if (empty($cache['created']) || empty($cache['xml'])) {
			return false;
		}
		echo $now - $cache['created'] . "\n";
		return $now - $cache['created'] < $ttl;
	}

	function parse() {
		$this->doc = new \DOMDocument;
		$this->doc->loadXML($this->xml, LIBXML_NOWARNING | LIBXML_NOERROR | LIBXML_NOCDATA);
		$items = $this->doc->getElementsByTagName('item');
		foreach ($items as $item) {
			$this->items[] = [
				'guid'        => $this->get_child($item, 'guid')->nodeValue,
				'title'       => $this->get_child($item, 'title')->nodeValue,
				'pubDate'     => $this->get_child($item, 'pubDate')->nodeValue,
				'link'        => $this->get_child($item, 'link')->nodeValue,
				'description' => $this->get_child($item, 'description')->nodeValue,
				'image'       => $this->get_child($item, 'itunes:image')->getAttribute('href'),
				'audio'       => $this->get_child($item, 'enclosure')->getAttribute('url'),
				'duration'    => $this->get_child($item, 'itunes:duration')->nodeValue,
			];
		}
	}

	function get_child($node, $tag) {
		$tag = explode(':', $tag);
		if (count($tag) == 1) {
			return $node->getElementsByTagName($tag[0])->item(0);
		} else {
			$ns = $this->doc->lookupNamespaceURI($tag[0]);
			return $node->getElementsByTagNameNS($ns, $tag[1])->item(0);
		}
	}

}
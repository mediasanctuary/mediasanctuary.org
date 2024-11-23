<?php

namespace FeedImport;

class Post {

	public $item;
	public $feed;

	function __construct($item, $feed) {
		$this->item = $item;
		$this->feed = $feed;
	}

	function import() {
		// $ns = $this->feed->getNamespaces(true);
		// print_r($this->feed);
		print_r($this->item);
		$ns = 'http://www.itunes.com/dtds/podcast-1.0.dtd';
		print_r($this->item->children($ns));
	}

}

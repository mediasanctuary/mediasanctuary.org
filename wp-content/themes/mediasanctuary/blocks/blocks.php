<?php

// See: https://www.advancedcustomfields.com/resources/acf_register_block_type/

$block_defaults = [
	'category'        => 'common',
	'post_types'      => ['post', 'page', 'project'],
	'mode'            => 'auto',
	'supports'        => [
		'align'       => false,
	]
];

$blocks = [
	'introduction' => [
		'title'       => 'Introduction',
		'description' => 'Larger text section.',
		'icon'        => 'text',
	],
	'features' => [
		'title'       => 'Features',
		'description' => 'Hero images with buttons.',
		'icon'        => 'format-image'
	],
	'cta' => [
		'title'       => 'CTA Box',
		'description' => 'Hero images with buttons.',
    'category'    => 'formatting',
    'icon'        => 'admin-comments',
	],
	'gallery' => [
		'title'       => 'Photo Gallery Block',
		'description' => 'Photo Gallery slider with thumbnails',
		'icon'        => 'format-gallery',
	],
	'progressbar' => [
		'title'       => 'Progress Bar',
		'description' => 'Percentage of total',
		'icon'        => 'format-image'
	]
];

$dir = __DIR__;
foreach ($blocks as $name => $block) {
	$block = array_merge($block_defaults, $block);
	$block['name'] = $name;
	$block['render_template'] = "$dir/$name.php";
	acf_register_block_type($block);
}

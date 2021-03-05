<?php

// See: https://www.advancedcustomfields.com/resources/acf_register_block_type/

$block_defaults = [
	'category'        => 'common',
	'post_types'      => ['post', 'page'],
	'mode'            => 'auto',
	'supports'        => [
		'align'       => false,
	]
];

$blocks = [
	'introduction' => [
		'title'           => 'Introduction',
		'description'     => 'Larger text section.',
		'icon'            => 'text',
	]
];

$dir = __DIR__;
foreach ($blocks as $name => $block) {
	$block = array_merge($block_defaults, $block);
	$block['name'] = $name;
	$block['render_template'] = "$dir/$name.php";
	acf_register_block_type($block);
}

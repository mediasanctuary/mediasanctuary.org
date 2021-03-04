<?php

// See: https://www.advancedcustomfields.com/resources/acf_register_block_type/

$defaults = [
	'category'        => 'common',
	'post_types'      => ['post', 'page'],
	'mode'            => 'auto',
	'supports'        => [
		'align'       => false
	]
];

$blocks = [
	'introduction' => [
		'title'           => 'Introduction',
		'description'     => 'Larger text section.',
		'icon'            => 'text',
	]
];

foreach ($blocks as $name => $block) {
	$block['name'] = $name;
	$block['render_template'] = __DIR__ . "/$name.php";
	acf_register_block_type($block);
}

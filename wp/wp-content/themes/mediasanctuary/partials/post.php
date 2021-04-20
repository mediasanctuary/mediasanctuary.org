<?php
  global $data;
  $mobileClass = ($data['number'] > 2) ? 'desktop' : '';
  
	$thumb_url = get_asset_url('img/default.jpg');
	if ( has_post_thumbnail() ) {
		$thumb_id = get_post_thumbnail_id();
		$thumb_url_array = wp_get_attachment_image_src($thumb_id, 'full', true);
		$thumb_url = $thumb_url_array[0];
	}

	$more = 'Read More';
	if('audio' == get_post_format()){
		$more = 'Listen Now';
	}
	if('video' == get_post_format()){
		$more = 'Watch Now';
	}

?>

<li class="col <?php echo $mobileClass; ?>">
	<a href="<?php the_permalink();?>" class="posts__item">
		<span class="post__thumbnail" style="background-image:url(<?php echo $thumb_url; ?>)">
			<strong><?php echo $more; ?></strong>
		</span>
		<h5><?php the_title();?></h5>
		<span class="posts__date"><?php the_time('F d, Y');?></span>
	</a>
</li>

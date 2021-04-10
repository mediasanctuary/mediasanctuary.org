<?php 
	if ( has_post_thumbnail() ) {
		$thumb_id = get_post_thumbnail_id();
		$thumb_url_array = wp_get_attachment_image_src($thumb_id, 'full', true);
		$thumb_url = $thumb_url_array[0];
		if($thumb_url === get_bloginfo('wpurl').'/wp-includes/images/media/default.png') {
			$thumb_url = get_bloginfo('template_directory').'/dist/img/default.jpg';
		}
	} else {
		$thumb_url = get_bloginfo('template_directory').'/dist/img/default.jpg';
	}
	
	$more = 'Read More';
	if('podcast' == get_post_type()){
  	$more = 'Listen Now';
	}
	
?>

<li class="col">			
	<a href="<?php the_permalink();?>" class="posts__item">
		<span class="post__thumbnail" style="background-image:url(<?php echo $thumb_url; ?>)">					
			<strong><?php echo $more; ?></strong>
		</span>												
		<h5><?php the_title();?></h5>
		<span class="posts__date"><?php the_time('F d, Y');?></span>
	</a>
</li>
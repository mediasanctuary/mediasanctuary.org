<?php 
/**
Template Page for the image browser

Follow variables are useable :

	$image : Contain all about the image 
	$meta  : Contain the raw Meta data from the image 
	$exif  : Contain the clean up Exif data 
	$iptc  : Contain the clean up IPTC data 
	$xmp   : Contain the clean up XMP data 

 You can check the content when you insert the tag <?php var_dump($variable) ?>
 If you would like to show the timestamp of the image ,you can use <?php echo $exif['created_timestamp'] ?>
**/
?>
<?php if (!defined ('ABSPATH')) die ('No direct access allowed'); ?><?php if (!empty ($image)) : ?>

<div class="ngg-imagebrowser ms-imagebrowser" id="<?php echo $image->anchor ?>" data-nextgen-gallery-id="<?php echo $displayed_gallery->id(); ?>">

	<div class="pic"><?php echo $image->href_link ?></div>
	
	<div class="ngg-imagebrowser-info">
		<h3><?php echo $image->alttext ?></h3>
		<div class="ngg-imagebrowser-desc"><p><?php echo $image->description ?></p></div>
		<div class="counter"><?php echo $image->number ?> <?php _e('of', 'nggallery')?> <?php echo $image->total ?></div>
	
	<div class="ngg-imagebrowser_nav_arrows">
		<div class="back">
			<a class="ngg-browser-prev" id="ngg-prev-<?php echo $image->previous_pid ?>" href="<?php echo nextgen_esc_url($image->previous_image_link) ?>"><img src="
<?php echo get_stylesheet_directory_uri(); ?>/images/arrows_img_browser_prev.png" /></a>
		</div>
		<div class="next">
			<a class="ngg-browser-next" id="ngg-next-<?php echo $image->next_pid ?>" href="<?php echo nextgen_esc_url($image->next_image_link) ?>"><img src="
<?php echo get_stylesheet_directory_uri(); ?>/images/arrows_img_browser_next.png" /></a>
		</div>
	  </div>
	  	
	</div>	
</div>	

<?php endif; ?>
<script type='text/javascript'>
	jQuery(function($) {
		new NggPaginatedGallery('<?php echo $displayed_gallery->id() ?>', '.ngg-imagebrowser');
	});
</script>
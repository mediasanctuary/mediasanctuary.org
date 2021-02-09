<?php 
/**
Template Page for the gallery overview

Follow variables are useable :

	$gallery     : Contain all about the gallery
	$images      : Contain all images, path, title
	$pagination  : Contain the pagination content

 You can check the content when you insert the tag <?php var_dump($variable) ?>
 If you would like to show the timestamp of the image ,you can use <?php echo $exif['created_timestamp'] ?>
**/
?>
<?php if (!defined ('ABSPATH')) die ('No direct access allowed'); ?><?php if (!empty ($gallery)) : ?>

<div class="ms-template ngg-galleryoverview" id="<?php echo $gallery->anchor ?>">

<?php //if ($gallery->show_slideshow) { ?>
	<!-- Slideshow link -->
	<!-- div class="slideshowlink">
		<a class="slideshowlink" href="<?php echo $gallery->slideshow_link ?>">
			<?php echo $gallery->slideshow_link_text ?>
		</a>
	</div -->
<?php //} ?>

<?php if ($gallery->show_piclens) { ?>
	<!-- Piclense link -->
	<div class="piclenselink">
		<a class="piclenselink" href="<?php echo $gallery->piclens_link ?>">
			<?php _e('[View with PicLens]','nggallery'); ?>
		</a>
	</div>
<?php } ?>
	
	<!-- Thumbnails -->
	<?php foreach ( $images as $image ) :
	 
	if (isset($image->meta_data['width'])){ 
			$img_path = $image->imageURL;
		} else {
			$img_path = 'https://www.mediasanctuary.org/files/images/'. $image->filename;
		}

	?>
	
	<div id="ngg-image-<?php echo $image->pid ?>" class="ngg-gallery-thumbnail-box" <?php echo $image->style ?> >
		<div class="ngg-gallery-thumbnail" >
			<a href="<?php echo $img_path ?>" title="<?php echo $image->description ?>" <?php echo $image->thumbcode ?> >
				<?php if ( !$image->hidden ) { ?>
				<img title="<?php echo $image->alttext ?>" alt="<?php echo $image->alttext ?>" src="<?php echo $img_path ?>" <?php echo $image->size ?> />
				<?php } ?>
			<span class="thumb-desc">
			<?php if ( $image->description ) { 
				echo $image->description;
				} ?>
			</span>
			</a>
			
			
			
			<?php 
			$data = $image->alttext;
			/* ////// link to orig file new galleries  RM */
			if (isset($image->meta_data['width']) &&  $pos = strpos($data, "||") == FALSE){   
				$bigimg =  $image->imageURL . '_backup'; 
				//$newname = $image->filename . '_backup.jpg';
				$newname = $image->filename;
			
				if (($pos = strpos($newname, "_backup")) !== FALSE) { 
    				$newname = substr($newname, $pos-1); 
				} ?>
				<div class="hirez_text"><a href="<?php echo $bigimg ?>" download="<?php echo $newname ?>">[orig file]</a></div>
			<?php } else {
			/* ////// link to orig file  migrated Drupal site galleries */
				//$data = $image->alttext;
				if (($pos = strpos($data, "||")) !== FALSE) { 
    				$pic_orig_url = substr($data, $pos+3); 
					}	
				// without test: $pic_orig_url = substr($data, strpos($data, "||") + 3);    					
					?>
				<div class="hirez_text"><a href="https://www.mediasanctuary.org/files/images/<?php echo $pic_orig_url ?>"  download="">[orig file]</a></div>
			<?php } //End orig file links ?>
		
		</div>
	</div>
	
	<?php if ( $image->hidden ) continue; ?>
	<?php if ( $gallery->columns > 0 && ++$i % $gallery->columns == 0 ) { ?>
		<br style="clear: both" />
	<?php } ?>

 	<?php endforeach; ?>
 	
	<!-- Pagination -->
 	<?php echo $pagination ?>
 	
</div>

<?php endif; ?>
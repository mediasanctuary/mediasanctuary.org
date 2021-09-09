<?php
/**
 * Block template file: blocks/storiesprojects
 * Stories or Projects Block
*/

$type = get_field('type');
$headline = get_field('headline') ?: ucfirst($type);
$more = 'Read More';
$single = 'story';
$cols = 'four-col';
if($type == 'projects'){
  $more = 'Learn More';
  $single = 'project';
  $cols = 'three-col';
}
?>

<?php if( have_rows($type) ): ?>
<section class="p40 story-project">
  <h2><?php echo $headline;?></h2>
  <div class="<?php echo $cols;?>">  
    <?php 
      while ( have_rows($type) ) : the_row(); 
       $post = get_sub_field($single); 
        if( $post ) {
          $postTitle = get_the_title( $post->ID );
          $postPhoto = get_asset_url('img/default.jpg');
          if ( has_post_thumbnail($post->ID) ) {
          	$thumb_id = get_post_thumbnail_id($post->ID);
          	$thumb_url_array = wp_get_attachment_image_src($thumb_id, 'medium', true);
          	$postPhoto = $thumb_url_array[0];
          }              
        }
    ?>
      <div class="col">
      	<a href="<?php echo get_permalink($post->ID);?>" class="posts__item">
      		<span class="post__thumbnail" style="background-image:url(<?php echo $postPhoto; ?>)">
      			<strong><?php echo $more; ?></strong>
      		</span>
      		<h5><?php echo $postTitle;?></h5>
      	</a>
      </div>
    <?php endwhile;?>  
  </div>
</section>
<?php endif; ?>  

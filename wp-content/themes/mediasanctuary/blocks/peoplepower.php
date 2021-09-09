<?php
/**
 * Block template file: blocks/peoplepower
 *
 * People Power Block Template.
 *
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'person-' . $block['id'];
if ( ! empty($block['anchor'] ) ) {
    $id = $block['anchor'];
}
?>

<div id="<?php echo esc_attr( $id ); ?>" class="personProfile">
  <?php
    $profile = get_field('people_power_profile');
    if( $profile ) {
      $personName = get_the_title( $profile->ID );
      $personTitle = get_field( 'person_title', $profile->ID );
      $personBio = substr($profile->post_content, 0, 300);
      $personPhoto = get_asset_url('img/default.jpg');
      $personLink = get_permalink( $profile->ID );
      if ( has_post_thumbnail($profile->ID) ) {
      	$thumb_id = get_post_thumbnail_id($profile->ID);
      	$thumb_url_array = wp_get_attachment_image_src($thumb_id, 'medium', true);
      	$personPhoto = $thumb_url_array[0];
      }          
    }
    $enabled = get_field('enable_bio');
    $bioOverride = get_field('bio_override');

  ?>
  <div class="photo">
    <img src="<?php echo esc_url( $personPhoto ); ?>" alt="<?php echo esc_attr( $personName ); ?>" />
  </div>
  <div class="bio">
    <h5><?php echo esc_html( $personName ); ?> <em><?php echo esc_html( $personTitle );?></em></h5>
    <?php 
      if($enabled){
        if($bioOverride){
          echo $bioOverride;
        } else {
          echo $personBio.'... <a href="'.$personLink.'">continue reading</a>';
        }
        
      }
    ?>    
  </div>
</div>

<?php
/**
 * Block template file: blocks/testimonials
 *
 * Testimonials Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'testimonials-' . $block['id'];
if ( ! empty($block['anchor'] ) ) {
    $id = $block['anchor'];
}

?>

<?php if( have_rows('testimonial') ): ?>

	</div>
</section>

<section class="single testimonialBlock p60">
	<div class="container">

  <div id="<?php echo esc_attr( $id ); ?>" class="testimonials-slider">
    <?php while( have_rows('testimonial') ): the_row(); 
        $quote = get_sub_field('quote');
        $profile = get_sub_field('people_power_profile');
        if( $profile ) {
          $personName = get_the_title( $profile->ID );
          $personTitle = get_field( 'person_title', $profile->ID );
          $personTestimonial = get_field( 'person_testimonial', $profile->ID );
          $personPhoto = get_asset_url('img/default.jpg');
          if ( has_post_thumbnail($profile->ID) ) {
          	$thumb_id = get_post_thumbnail_id($profile->ID);
          	$thumb_url_array = wp_get_attachment_image_src($thumb_id, 'medium', true);
          	$personPhoto = $thumb_url_array[0];
          }          
          if ($quote == null){
            $quote = $personTestimonial;
          }
        }
        ?>
        <div class="quote">
          <blockquote>
            <?php echo $quote; ?>
          </blockquote>
          <div class="profile">
            <div class="photo">
              <img src="<?php echo esc_url( $personPhoto ); ?>" alt="<?php echo esc_attr( $personName ); ?>" />
            </div>
            <p>
              <strong><?php echo esc_html( $personName ); ?></strong>
              <span><?php echo esc_html( $personTitle );?></span>
            </p>
          </div>
        </div>
    <?php endwhile; ?>
  </div>
  
	</div>
</section>

<section class="single p30">
	<div class="container">
  
<?php endif; ?>      

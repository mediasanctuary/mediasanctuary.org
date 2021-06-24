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
        $profile = get_sub_field('profile');
        ?>
        <div class="quote">
          <blockquote>
            <?php echo $quote; ?>
          </blockquote>
          <div class="profile">
            <div class="photo">
              <img src="<?php echo esc_url( $profile['profile_picture']['sizes']['thumbnail'] ); ?>" alt="<?php echo esc_attr( $profile['profile_picture']['alt'] ); ?>" />
            </div>
            <p>
              <strong><?php echo $profile['profile_name']?></strong>
              <span><?php echo $profile['profile_title']?></span>
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
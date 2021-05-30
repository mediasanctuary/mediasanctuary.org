<?php
/**
 * Block template file: blocks/photo-gallery
 *
 * Photo Gallery Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'slider-' . $block['id'];
if ( ! empty($block['anchor'] ) ) {
    $id = $block['anchor'];
}
?>

<?php 
  $images = get_field('photos');
  if( $images ): 
    $thumb=0;?>
    <div class="gallery">
      <div class="galleryContainer">
        <div id="<?php echo esc_attr( $id ); ?>" class="slider">
          
          <?php foreach( $images as $image ): ?>
            <div class="item">
              <img src="<?php echo esc_url($image['sizes']['large']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" data-caption="<?php echo esc_attr($image['caption']); ?>" />
            </div>
          <?php endforeach; ?>
            </ul>
        </div>
      </div>
      <ul id="thumbs-<?php echo esc_attr( $id ); ?>" class="thumbs">
        <?php foreach( $images as $image ): ?>
          <li class="s<?php echo $thumb;?>">
            <span data-slide="<?php echo $thumb;?>"><img src="<?php echo esc_url($image['sizes']['medium']); ?>" alt="Thumbnail of <?php echo esc_url($image['alt']); ?>" data-caption="<?php echo esc_attr($image['caption']); ?>" /></span>
          </li>
        <?php
          $thumb++;
          endforeach; ?>
      </ul>
  </div>
<?php endif; ?>           
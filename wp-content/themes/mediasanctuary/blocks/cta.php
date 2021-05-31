<?php

/**
 * CTA Callout Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'cta-block-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'ctaBlock';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}

// Load values and assign defaults.
$copy = get_field('headline-and-desc');
$button = get_field('button');
$ctaType = get_field('cta_type');
$ctaImage = get_field('callout_image');
$backgroundImage = $ctaImage ? 'background-image: url('.$ctaImage.')' : false;
?>
<div id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?><?php echo ' '.esc_attr($ctaType); ?>" style="<?php echo $backgroundImage;?>">
  <div class="content">
    <?php echo $copy['headline'] ? '<h3>'.$copy['headline'].'</h3>' : null; ?>
    <?php echo $copy['description'] ? '<p>'.$copy['description'].'</p>' : null; ?>    
    <a href="<?php echo $button['link_url'] ?: '/'; ?>" class="btn <?php echo $ctaType == 'dark' ? 'ladybug' : false; ?>"><?php echo $button['link_text'] ?: 'Learn more'; ?></a>
  </div>
</div>
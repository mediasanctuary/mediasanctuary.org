<?php
/**
 * Block template file: blocks/progressbar
 *
 * Progress Bar Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

$id = 'progress-' . $block['id'];
if ( ! empty($block['anchor'] ) ) {
    $id = $block['anchor'];
}
?>

<?php 
  $goal_title = get_field('goal_title');
  $goal = get_field('goal');
  $progress = get_field('progress');
?>

<div id="<?php echo esc_attr( $id ); ?>" class="progressBlock">
  <?php echo $goal_title ? '<h3>'.$goal_title.'</h3>' : null; ?>
  <div class="progressContainer">
    <div class="progressBar" data-progress='<?php echo $progress; ?>' data-goal='<?php echo $goal; ?>'></div>
    <span><?php echo $progress;?> of <?php echo $goal;?></span>
  </div>
</div>         
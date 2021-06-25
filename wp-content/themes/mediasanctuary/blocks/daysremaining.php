<?php
/**
 * Block template file: blocks/daysremaining
 *
 * Days Remaining Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */





$future = strtotime(get_field('date'));
$now = time();
$timeleft = $future-$now;
if ($timeleft < 0) { 
  $daysleft = 0; 
} else {
  $daysleft = round((($timeleft/24)/60)/60);  
}
 
?>     

<div class="days-remaining">
  <strong><?php echo sprintf('%02d', $daysleft); ?></strong>
  <span><?php echo get_field('countdown_label'); ?></span>
</div>

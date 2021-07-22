<?php
/**
 * Block template file: blocks/tabs
 *
 * Tabs and Accordion Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'tabs_' . $block['id'];
if ( ! empty($block['anchor'] ) ) {
    $id = $block['anchor'];
}
$type = get_field('type');
?>

<?php if( have_rows('items') ): ?>

  <?php if($type == 'tabs') { 
    // --------------- Tabs ---------------------- //
  ?>

    <div id="<?php echo esc_attr( $id ); ?>" class="tabs">

      <ul class="tab-nav">
      <?php $i = 1; while( have_rows('items') ): the_row(); 
        $item = get_sub_field('item');
        $heading = $item['name'];
      ?>
        <li><a href="#<?php echo esc_attr( $id ).'_'.$i;?>" class="tab-heading"><?php echo $heading;?></a></li>
      <?php $i++; endwhile; ?>
      </ul>      

      <?php $i = 1; while( have_rows('items') ): the_row(); 
        $item = get_sub_field('item');
        $heading = $item['name'];
        $content = $item['content'];
      ?>
        <a href="#<?php echo esc_attr( $id ).'_'.$i;?>" class="tab-heading mobile-tab"><h4><?php echo $heading;?></h4></a>      
        <div id="<?php echo esc_attr( $id ).'_'.$i;?>" class="tab-container">
          <div class="tab-content">
            <?php echo $content; ?>
          </div>
        </div>
      <?php $i++; endwhile; ?>
    </div>
    
    
    
  <?php } else { 
    // --------------- Accordion ---------------------- //
    
  ?>
  
    <div id="<?php echo esc_attr( $id ); ?>" class="tabs">
      <?php $i = 1; while( have_rows('items') ): the_row(); 
        $item = get_sub_field('item');
        $heading = $item['name'];
        $content = $item['content'];
      ?>
        <div id="tab_<?php echo $i;?>"class="tab">
          <a href="#tab_<?php echo $i;?>" class="accordion-heading"><h4><?php echo $heading;?></h4></a>
          <div class="tab-container">
            <div class="tab-content">
              <?php echo $content; ?>
            </div>
          </div>
        </div>
      <?php $i++; endwhile; ?>
    </div>
    
  <?php }  ?>
<?php endif; ?>      

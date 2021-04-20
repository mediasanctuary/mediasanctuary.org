<?php
  get_header();
  if (have_posts()) : while(have_posts()) : the_post();
?>

<section class="p40">
  <div class="container sm">
    <?php the_content();?>
  </div>
</section>


<?php
  endwhile; endif;
  get_footer();
?>

<?php
  get_header();
  if (have_posts()) : while(have_posts()) : the_post();
?>

<section class="pageHeading">
  <div class="wrap">
    <h1><?php the_title();?></h1>
  </div>
</section>

<section class="p40">
  <div class="container sm">
    <?php the_content();?>
  </div>
</section>


<?php
  endwhile; endif;
  get_footer();
?>

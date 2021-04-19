<div class="intro">
	<p>The Sanctuary operates several distinct initiatives in our mission to build a more just world using art, science, and creativity as our tools.</p>
</div>
<ul class="initiatives__list three-col">
<?php
  $args = array(
    'post_type' => 'page',
    'post_parent'=> 29640,
    'orderby' => 'title',
    'order' => 'ASC'
  );
  $queryInitiatives = new WP_Query($args);
  if ($queryInitiatives->have_posts()) :
      while ($queryInitiatives->have_posts()) : $queryInitiatives->the_post();?>
        <li class="col">
          <a href="<?php echo get_permalink();?>">
            <img src="<?php echo get_field('initiative_logo') ?>" alt="<?php the_title();?>">
          </a>
        </li>
      <?php endwhile;
  endif;
  wp_reset_query();
?>
</ul>

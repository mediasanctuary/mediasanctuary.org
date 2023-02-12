<?php
  get_header();
  if (have_posts()) : while(have_posts()) : the_post();

    if ( has_post_thumbnail() ) {
      $thumb_id = get_post_thumbnail_id();
      $thumb_url_array = wp_get_attachment_image_src($thumb_id, 'large', true);
      $thumb_url = $thumb_url_array[0];
      if($thumb_url === get_bloginfo('wpurl').'/wp-includes/images/media/default.png') {
        $thumb_url = false;
      }
    } else {
      $thumb_url = false;
    }

    if ($thumb_url) {
      $caption = '';
      $caption_content = wp_get_attachment_caption($thumb_id);
      if (! empty($caption_content)) {
        $caption = '<div class="photoCaption">' . $caption_content . '</div>';
      }
      $thumb_post = get_post($thumb_id);
      if (! empty($thumb_post)) {
        $caption .= '<div class="photoCredit">' . $thumb_post->post_content . '</div>';
      }
      $thumb = '<div class="mainPhoto"><img src="'.$thumb_url.'">' . $caption . '</div>';
    }
?>

<section class="p40">
<div class="container ">
  <article class="post post--single people">
    <main>
      <div class="categories">
        <a href="/peoplepower">&laquo; People Power</a>
      </div>
      <h1><?php the_title();?></h1>
      <?php

      $types = get_the_terms($post, 'person-type');
      if (! empty($types)) { ?>
        <div class="person-type">
          <?php foreach ($types as $index => $type) {
            if ($index > 0) {
              echo ', ';
            }
            echo esc_html($type->name);
          } ?>
        </div>
      <?php } ?>
      <div class="content">
        <?php
          if (! empty($thumb)) {
            echo $thumb;
          }
          echo '<div class="copy">'; the_content();

          $initiatives = get_field('initiatives');
          if (! empty($initiatives)) {
            echo '<p>Involved with: ';
            foreach ($initiatives as $index => $initiative) {
              if ($index > 0) {
                echo ', ';
              }
              echo '<a href="/initiatives/' . esc_attr($initiative->slug) . '/">';
              echo esc_html($initiative->name) . '</a>';
            }
            echo "</p>\n";
          }

          echo '</div">';
        ?>
      </div>

    </main>

    <?php
      /*
        Maybe Include Stories of Author?

        if (function_exists('get_field') && ! empty($parent)) {

      $categories = get_field('featured_categories', 'options');
      $category_links = get_category_links($categories, $parent->term_id);

      ?>
      <aside>
        <h4>Stories</h4>
        <ul>

        </ul>
      </aside>
      */
      ?>
    </article>

  </div>
</section>


<?php if( have_rows('person_projects') ): ?>
<section id="projects" class="p40">
  <div class="container">
    <h2>Projects</h2>
    <div class="three-col">
      <?php
        while ( have_rows('person_projects') ) : the_row();
          $post_object = get_sub_field('project');
          if( $post_object ) {
            $post = $post_object;
            setup_postdata( $post );
            get_template_part( 'partials/post', 'none' );
            wp_reset_postdata();
          }
        endwhile;
      ?>
    </div>
  </div>
</section>
<?php endif; ?>



<?php
  endwhile; endif;
  get_footer();
?>

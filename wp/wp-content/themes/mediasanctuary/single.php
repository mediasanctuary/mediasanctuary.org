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

    $parent = null;

    if (has_category('Stories')) {
      $parent = get_term_by('name', 'Stories', 'category');
    } else if (has_category('Sanctuary News')) {
      $parent = get_term_by('name', 'Sanctuary News', 'category');
    }

    $cat = '';
    if (! empty($parent)) {
      $categories = get_the_category();
      if (! empty($categories)) {
        $cat = get_category_links($categories, $parent->term_id);
        $cat = implode(', ', $cat);
      }
    }

    $tags = '';
    $terms = get_the_terms($post, 'post_tag');
    if (! empty($terms)) {
      foreach ($terms as $term) {
        if (! empty($tags)) {
          $tags .= ", ";
        }
        $tags .= '<a href="' . esc_url( get_term_link( $term ) ) . '" class="tag" >' . esc_html( $term->name ) . '</a>';
      }
    }

    if ($thumb_url) {
      $thumb = '<img src="'.$thumb_url.'" class="mainPhoto" />';
    }
?>

<section class="p40">
<div class="container ">
  <article class="post post--single">
    <main>
      <span class="date" ><?php the_time('F d, Y'); ?></span>
      <div class="categories">
        <?php echo $cat; ?>
      </div>
      <h1><?php the_title();?></h1>
      <div><?php

      if (function_exists('soundcloud_podcast') && get_post_format($post->ID) == 'audio') {
        soundcloud_podcast();
      }
      if (! empty($thumb)) {
        echo $thumb;
      }
      the_content();
      echo '<br class="clear">';
      ?>

      <?php if (! empty($tags)) { ?>
        <div class="tags">
          Tags: <?php echo $tags; ?>
        </div>
      <?php } ?>

      </div>
      <div class="meta">
        <ul class="social top" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="800">
          <li><strong>Share</strong></li>
          <li><a href="http://www.facebook.com/sharer/sharer.php?u=<?php echo get_permalink(); ?>" onclick="window.open(this.href,'targetWindow','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=550,height=450,left=30,top=50');return false;" class="fb">Facebook</a></li>
          <li><a href="http://twitter.com/share?text=<?php echo get_the_title(); ?>&url=<?php echo get_permalink(); ?>&via=mediasanctuary" onclick="window.open(this.href,'targetWindow','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=550,height=450,left=30,top=50');return false;" class="tw">Twitter</a></li>
          <li><a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo get_permalink(); ?>&title=<?php echo get_the_title(); ?>&summary=<?php echo strip_tags(get_the_excerpt());?>&source=mediasanctuary.org" target="_blank" onclick="window.open(this.href,'targetWindow','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=550,height=450,left=30,top=50');return false;" class="ln">LinkedIn</a></li>
          <li><a href="mailto:?subject=Article from the Sanctuary for Independent Media&body=Hi, this may be interesting to you: &ldquo;<?php echo get_the_title(); ?>&rdquo;! Visit the article: <?php echo get_permalink(); ?>" class="em">E-mail</a></li>
        </ul>
      </div>
    </main>

    <?php

    if (function_exists('get_field') && ! empty($parent)) {

      $categories = get_field('featured_categories', 'options');
      $category_links = get_category_links($categories, $parent->term_id);

      ?>
      <aside>
        <h4><?php echo $parent->name; ?></h4>
        <ul>
          <?php foreach ($category_links as $link) { ?>
            <li><?php echo $link; ?></li>
          <?php } ?>
        </ul>
      </aside>
    <?php } ?>
    </article>

  </div>
</section>



<?php
  endwhile; endif;
  get_footer();
?>

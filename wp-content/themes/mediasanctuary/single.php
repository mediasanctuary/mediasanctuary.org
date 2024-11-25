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
  <article class="post post--single">
    <main>
      <?php if ($post->post_type == 'peoplepower') { ?>
        <div class="categories">
          <a href="/peoplepower">People Power</a>
        </div>
      <?php } else { ?>
        <span class="date" ><?php the_time('F d, Y'); ?></span>
      <?php } ?>
      <?php /*
      <div class="categories">
        <?php echo $cat; ?>
      </div>
      */ ?>
      <h1><?php the_title();?></h1>
      <?php if ($post->post_type == 'post' && has_category('Stories')) {
        $byline = get_field('byline');
        if (! empty($byline)) { ?>
          <span class="byline">By <?php foreach ($byline as $index => $person) {
            if ($index == 1 && count($byline) == 2) {
              echo ' and ';
            } else if ($index > 0 && $index == count($byline) - 1) {
              echo ', and ';
            } else if ($index > 0) {
              echo ', ';
            }
            echo '<a href="' . get_permalink($person) . '">' . esc_html($person->post_title) . "</a>";
          } ?></span>
        <?php } ?>
      <?php } ?>
      <div class="content">
        <?php
          if (get_post_format($post->ID) == 'audio') {
            audio_player();
            if (! empty($thumb)) {
              echo $thumb;
            }
          } else if ($post->post_type == 'peoplepower' && ! empty($thumb)) {
            echo $thumb;
          }
          the_content();
        ?>
      </div>

      <?php if (! empty($tags)) { ?>
        <div class="tags">
          Tags: <?php echo $tags; ?>
        </div>
      <?php } ?>

      <div class="meta">
        <ul class="social">
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

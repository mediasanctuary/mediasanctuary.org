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

    $cat = '';
    $categories = get_the_category();
    foreach ($categories as $category) {
      if ($category->slug == 'stories') {
        continue;
      }
      if (! empty($cat)) {
        $cat .= ", ";
      }
      $cat .= '<span class="categoryTag"><a href="' . esc_url( get_category_link( $category->term_id ) ) . '" class="tag alt" >' . esc_html( $category->name ) . '</a></span>';
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
      echo $thumb;
      the_content();
      echo '<br class="clear">';

      ?></div>
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

    <aside>
        <?php // FPO - Sidebar Functionality to List Categories & Recent Posts ?>
        <h4>Podcast Categories</h4>
        <ul>
          <li><a href="https://www.mediasanctuary.org/podcast-categories/art-culture-entertainment/">Art, Culture &amp; Entertainment</a></li>
          <li><a href="https://www.mediasanctuary.org/podcast-categories/social-justice-activism/" >Social Justice &amp; Activism</a></li>
          <li><a href="https://www.mediasanctuary.org/podcast-categories/civic-education-government/">Civic Education &amp; Government</a></li>
          <li><a href="https://www.mediasanctuary.org/podcast-categories/environment-sustainability/">Environment &amp; Sustainability</a></li>
          <li><a href="https://www.mediasanctuary.org/podcast-categories/science-technology/">Science &amp; Technology</a></li>
          <li><a href="https://www.mediasanctuary.org/podcast-categories/entrepreneurism/">Entrepreneurism</a></li>
          <li><a href="https://www.mediasanctuary.org/podcast-categories/food-farming/">Food &amp; Farming</a></li>
          <li><a href="https://www.mediasanctuary.org/podcast-categories/climate/">Climate</a></li>
        </ul>

      </aside>
    </article>

  </div>
</section>



<?php
  endwhile; endif;
  get_footer();
?>

<?php
/**
 * Template Name: Initiatives
 * Description: The template used to display the Initiatives
 *
 * @package WordPress
 * @subpackage The Sanctuary for Indepeendent Media
 * @since Media Sanctuary 2.0
 */

get_header();
if (have_posts()) : while(have_posts()) : the_post(); ?>


<article>
  <section class="pageHeading">
    <div class="container">
      <h1><?php the_title();?></h1>
    </div>
  </section>
  
  
  <section class="p40">
    <div class="container">
      <?php the_content(); ?>
    </div>
  </section>
</article>

<?php if( have_rows('projects') ): ?>
<section id="projects" class="p40">
  <div class="container">
    <h2><?php the_title();?> - Featured Projects</h2>
    <ul class="three-col">  
      <?php 
        while ( have_rows('projects') ) : the_row();    
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
<?php
/**
 * Template Name: Initiatives Landing Page
 * Description: The template used to display the Initiatives
 *
 * @package WordPress
 * @subpackage The Sanctuary for Indepeendent Media
 * @since Media Sanctuary 2.0
 */

get_header();?>


<section id="initiatives" class="initiatives p60">
	<div class="container">
    <?php include get_template_directory() . '/sections/section-initiatives.php';?>
	</div>
</section>

<?php if( have_rows('projects') ): ?>
<section id="projects" class="p40">
  <div class="container">
    <h2 class="text-center">Featured Projects</h2>
    <div class="three-col p20">  
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
    <p class="text-center"><a href="/project/" class="btn lg">View All Projects</a></p>
  </div>
</section>
<?php endif; ?>


<?php
get_footer();
?>

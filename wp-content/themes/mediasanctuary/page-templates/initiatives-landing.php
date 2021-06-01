<?php
/**
 * Template Name: Initiatives Landing Page
 * Description: The template used to display the Initiatives
 *
 * @package WordPress
 * @subpackage The Sanctuary for Indepeendent Media
 * @since Media Sanctuary 2.0
 */

get_header(); 

$featuredProjects = false;
$title = 'Our';
if(get_field('display_options') == 'featured'){
  $title = 'Featured';
  $featuredProjects = true;
}

?>

<section id="initiatives" class="initiatives pb60">
	<div class="container">
    <?php include get_template_directory() . '/sections/section-initiatives.php';?>
	</div>
</section>

<section id="projects" class="p40">
  <div class="container">
    <h2 class="text-center"><?php echo $title;?> Projects</h2>
    <div class="three-col p20">  
      <?php
        if ($featuredProjects){
          while ( have_rows('projects') ) : the_row();    
            $post_object = get_sub_field('project'); 
            if( $post_object ) {
              $post = $post_object;
              setup_postdata( $post );
              get_template_part( 'partials/post', 'none' );
              wp_reset_postdata(); 
            }
          endwhile;
        } else {
          $args = array(
            'post_type' => 'project',
            'posts_per_page' => -1
          );
          $queryProjects = new WP_Query($args);
          if ($queryProjects->have_posts()) :
            while ($queryProjects->have_posts()) : $queryProjects->the_post();
              get_template_part( 'partials/post', 'none' );
            endwhile;
          endif;
          wp_reset_query();
        }
      ?> 
    </div>
    <p class="text-center"><a href="/project/" class="btn lg">View All Projects</a></p>
  </div>
</section>

<?php
get_footer();
?>

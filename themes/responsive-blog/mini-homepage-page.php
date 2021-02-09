<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * mini homepage Template
 *
 Template Name:  mini homepage
 *
 * @file           mini-homepage-page.php
 * @package        Responsive
 * @author         RM
 * @license        license.txt
 * @version        Release: 1.0
 * @filesource     wp-content/themes/responsive/page.php
 * @link           http://codex.wordpress.org/Theme_Development#Pages_.28page.php.29
 * @since          available since Release 1.0
 */

get_header('mhp'); ?>

<?php get_template_part( 'loop-header', get_post_type() ); ?>


<!-- mhp_intro_section -->
<div id="mhp_intro_section">
  <div id="mhp_intro_section_inner">
  <h1 class="entry-title post-title mhp"><?php the_title(); ?></h1>
	<?php echo get_post_meta($post->ID, 'mhp-meta-box-intro-text', true); ?>
  </div>	
</div>

<!-- mhp_slider_section -->
<?php $mhpslider = get_post_meta($post->ID, 'mhp-meta-box-slider', true); 
	if(!empty($mhpslider)) { ?>
<div id="mhp_slider_section">
	<?php echo do_shortcode(htmlspecialchars_decode(get_post_meta($post->ID, 'mhp-meta-box-slider', true)));
?>
</div>
<?php } ?>

<div id="content" class="grid-right col-620 fit" role="main">


	<?php if ( have_posts() ) : ?>

		<?php while( have_posts() ) : the_post(); ?>

			

			<?php responsive_entry_before(); ?>
			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<?php responsive_entry_top(); ?>

				<!-- <h1 class="entry-title post-title"><?php the_title(); ?></h1> -->
				
				<div class="post-meta">
					<?php
					responsive_blog_post_meta_data(); ?>

					<?php if ( comments_open() ) : ?>
						<span class="comments-link">
						<i class="fa fa-comment" aria-hidden="true"></i>
							<?php comments_popup_link( __( 'No Comments', 'responsive' ), __( '1 Comment', 'responsive' ), __( '% Comments', 'responsive' ) ); ?>
						</span>
					<?php endif; 
					 ?>
				</div><!-- end of .post-meta -->

				<div class="post-entry">
					<?php the_content( sprintf( __( 'Continue reading%s', 'responsive-blog' ), '<span class="screen-reader-text meta-nav">  '.get_the_title().'</span>' ) ); ?>
					<?php wp_link_pages( array( 'before' => '<div class="pagination">' . __( 'Pages:', 'responsive' ), 'after' => '</div>' ) ); ?>
				</div><!-- end of .post-entry -->

				<?php get_template_part( 'post-data', get_post_type() ); ?>

				<?php responsive_entry_bottom(); ?>
			</div><!-- end of #post-<?php the_ID(); ?> -->
			<?php responsive_entry_after(); ?>

			<?php responsive_comments_before(); ?>
			<?php comments_template( '', true ); ?>
			<?php responsive_comments_after(); ?>

		<?php
		endwhile;

		get_template_part( 'loop-nav', get_post_type() );

	else :

		get_template_part( 'loop-no-posts', get_post_type() );

	endif;
	?>


</div><!-- end of #content -->


<?php // mini-homepage tag from metadata
	$mhp_post_id = get_the_ID();
	$mhp_tag_id = get_post_meta($mhp_post_id, 'mini-homepage-tag', true);
	$term = get_term( $mhp_tag_id, 'post_tag' );
	$mhp_tag_name =  $term->name;
	$mhp_tag_url =  get_term_link( $term->term_id, 'post_tag' );
	$mhp_intro_text = 'Meet';
?>

<div id="mhp_event" class="class="grid-right col-300 rtl-fit">
	<?php do_action('mini_homepage_events_posts',$mhp_tag_id,$mhp_tag_name,1); ?>
</div>


<?php 

// do_action('mini_homepage_events_posts',$mhp_tag_id,$mhp_tag_name);

do_action('mini_homepage_podcasts_posts',$mhp_tag_id,$mhp_tag_name);

?>

<!-- mhp_projects_section -->
<?php $theprojects = get_post_meta($post->ID, 'mhp-meta-box-projects', true); 
	if(!empty($theprojects)) { ?>
<div id="mhp_projects_section">
	<h2 class="title"><?php echo $mhp_tag_name; ?> Projects:</h2>  <?php echo $theprojects; ?>
</div>
<?php } ?>


<?php 
get_sidebar('mini-homepage'); 

do_action('mini_homepage_people_profile_posts',$mhp_tag_id,$mhp_tag_name); 


do_action('mini_homepage_news_posts',$mhp_tag_id,$mhp_tag_name); 


get_footer('home'); ?>

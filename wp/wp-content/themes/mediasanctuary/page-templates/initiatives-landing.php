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

<?php
echo '<p class="text-center" style="padding:60px 0;"><a href="/project/" class="btn lg">View Our Projects</a></p>';
get_footer();
?>

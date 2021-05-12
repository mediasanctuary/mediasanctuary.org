<?php
/**
 * Template Name: Home Page
 * Description: The template used to display the Homepage
 *
 * @package WordPress
 * @subpackage The Sanctuary for Indepeendent Media
 * @since Media Sanctuary 2.0
 */

get_header();

the_content();

include get_template_directory() . '/sections/section-stories.php';
include get_template_directory() . '/sections/section-events.php';?>

<section id="initiatives" class="initiatives p60">
	<div class="container">
		<h2>Initiatives</h2>
    <?php include get_template_directory() . '/sections/section-initiatives.php';?>
	</div>
</section>

<?php include get_template_directory() . '/sections/section-news.php';

get_footer();

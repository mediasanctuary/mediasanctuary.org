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

the_content();

include get_template_directory() . '/sections/section-initiatives.php';

get_footer();

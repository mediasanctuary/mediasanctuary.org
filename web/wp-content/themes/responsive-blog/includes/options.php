<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Theme Options for Responsive Blog
 *
 */

/**
 * Call the options class
 */
require( $template_directory . '/includes/classes/Responsive_Blog_Options.php' );

// Adding responsive-blog template section in backend theme options
function responsive_blog_add_theme_option( $sections )
{
	// add new sections
	$new_sections = array(
		array(
			'title' => __( 'Responsive Blog Home Page', 'responsive-blog' ),
			'id'    => 'responsive_blog_template'
		)

	);
	$sections = array_merge(  $new_sections, $sections );

	return $sections;
}
add_filter('responsive_option_sections_filter', 'responsive_blog_add_theme_option' );


// Adding options under new Responsive Blog template
function responsive_blog_options( $options ) 
{
	// Remove the parent theme custom front page option
	unset($options['home_page'][0]);

	$options_home_page[] = array(
		 'title'       => '<div class="old_home_page">' . __( 'To customize the Responsive theme custom front page, please create a page and select the template "Responsive Front Page". This section can be used to customize that page.', 'responsive-blog' ) . '</div>',
				'subtitle'    => '',
				'heading'     => '',
				'type'        => 'description',
				'id'          => '',
				'description' => ''
	);
	$options['home_page'] = array_merge( $options_home_page, $options['home_page'] );

	$new_options = array(
		
		'responsive_blog_template' => array(
			array(
				'title'       => __( 'Enable Custom Front Page', 'responsive-blog' ),
				'subtitle'    => '',
				'heading'     => '',
				'type'        => 'checkbox',
				'id'          => 'front_page',
				'description' => sprintf( __( 'Overrides the WordPress %1sfront page option%2s', 'responsive' ), '<a href="options-reading.php">', '</a>' ),
				'placeholder' => ''
			),
			/* =============== Slider section ======================== */
			array(
				'title'       => '<strong class="responsive_blog_section_title">' . __( 'Slider section :', 'responsive-blog' ) . '</strong>',
				'subtitle'    => '',
				'heading'     => '',
				'type'        => 'description',
				'id'          => '',
				'description' => ''
			),
			array(
				'title'       => __( 'Show slider section ?', 'responsive-blog' ),
				'subtitle'    => '',
				'heading'     => '',
				'type'        => 'checkbox',
				'id'          => 'responsive_blog_slider_section',
				'description' => __( 'Check to disable', 'responsive-blog' ),
				'placeholder' => ''
			),
			array(
				'title'       => __( 'Choose post category for slider images <div class="options-description"><i>Recommended image size: 1363 x 609 px</i> </div>', 'responsive-blog' ),
				'subtitle'    => '',
				'heading'     => '',
				'id'          => 'responsive_blog_post_categories',
				'type'        => 'select',
				'options'     => Responsive_Blog_Options::responsive_blog_posts()
			),
			array(
				'title'       => __( 'Disable sliding effect ?', 'responsive-blog' ),
				'subtitle'    => '',
				'heading'     => '',
				'id'          => 'responsive_blog_slider_effect',
				'type'        => 'checkbox',
				'description' => __( 'Check to disable', 'responsive-blog' ),
			),
	
			/* =============== Callout section ======================== */
			array(
				'title'       => '<strong>' . __( 'Callout section:', 'responsive-blog' ) . '</strong>',
				'subtitle'    => '',
				'heading'     => '',
				'type'        => 'description',
				'id'          => '',
				'description' => ''
			),
			array(
				'title'       => __( 'Show callout section ?', 'responsive-blog' ),
				'subtitle'    => '',
				'heading'     => '',
				'type'        => 'checkbox',
				'id'          => 'responsive_blog_callout_section',
				'description' => __( 'Check to disable', 'responsive-blog' ),
				'placeholder' => ''
			),
			array(
				'title'       => __( 'Enter text to be highlighted', 'responsive-blog' ),
				'subtitle'    => '',
				'heading'     => '',
				'type'        => 'text',
				'id'          => 'responsive_blog_callout_text',
				'description' => '',
				'placeholder' => 'Callout text will be displayed here'
			),
			array(
				'title'       => __( 'Link URL', 'responsive-blog' ),
				'subtitle'    => '',
				'heading'     => '',
				'type'        => 'text',
				'id'          => 'responsive_blog_callout_link',
				'description' => '',
				'placeholder' => 'Link to read more button'
			),

			/* =============== Featured Category section ======================== */
			array(
				'title'       => '<strong>' . __( 'Featured Category section:', 'responsive-blog' ) . '</strong>',
				'subtitle'    => '',
				'heading'     => '',
				'type'        => 'description',
				'id'          => '',
				'description' => ''
			),
			array(
				'title'       => __( 'Show featured category section ?', 'responsive-blog' ),
				'subtitle'    => '',
				'heading'     => '',
				'type'        => 'checkbox',
				'id'          => 'responsive_blog_features_section',
				'description' => __( 'Check to disable', 'responsive-blog' ),
				'placeholder' => ''
			),
			array(
				'title'       => __( 'Title', 'responsive-blog' ),
				'subtitle'    => '',
				'heading'     => '',
				'type'        => 'text',
				'id'          => 'responsive_blog_features_title',
				'description' => '',
				'placeholder' => 'Featured Category Section title is displayed here'
			),
			array(
				'title'       => __( 'Description', 'responsive-blog' ),
				'subtitle'    => '',
				'heading'     => '',
				'type'        => 'text',
				'id'          => 'responsive_blog_features_desc',
				'description' => '',
				'placeholder' => 'Featured Category Section description is displayed here'
			),
			array(
				'title'       => __( 'Choose post category for feature icons <div class="options-description"><i>Recommended image size: 37 x 30 px</i> </div>', 'responsive-blog' ),
				'subtitle'    => '',
				'heading'     => '',
				'id'          => 'responsive_blog_feature_post_categories',
				'type'        => 'select',
				'options'     => Responsive_Blog_Options::responsive_blog_posts()
			),

			/* =============== Gallery section ========================  - RM
			array(
				'title'       => '<strong>' . __( 'Gallery section:', 'responsive-blog' ) . '</strong>',
				'subtitle'    => '',
				'heading'     => '',
				'type'        => 'description',
				'id'          => '',
				'description' => ''
			),
			array(
				'title'       => __( 'Show gallery section ?', 'responsive-blog' ),
				'subtitle'    => '',
				'heading'     => '',
				'type'        => 'checkbox',
				'id'          => 'responsive_blog_gallery_section',
				'description' => __( 'Check to disable', 'responsive-blog' ),
				'placeholder' => ''
			),
			array(
				'title'       => __( 'Title', 'responsive-blog' ),
				'subtitle'    => '',
				'heading'     => '',
				'type'        => 'text',
				'id'          => 'responsive_blog_gallery_title',
				'description' => '',
				'placeholder' => 'Gallery Section title is displayed here'
			),
			array(
				'title'       => __( 'Choose category for gallery images <div class="options-description"><i>Recommended image size: 800 x 531 px</i> </div>', 'responsive-blog' ),
				'subtitle'    => '',
				'heading'     => '',
				'id'          => 'responsive_blog_gallery_post_categories',
				'type'        => 'select',
				'options'     => Responsive_Blog_Options::responsive_blog_posts()
			),*/

			/* =============== Testimonial section ======================== */
			array(
				'title'       => '<strong>' . __( 'Testimonial section:', 'responsive-blog' ) . '</strong>',
				'subtitle'    => '',
				'heading'     => '',
				'type'        => 'description',
				'id'          => '',
				'description' => ''
			),
			array(
				'title'       => __( 'Show testionial section ?', 'responsive-blog' ),
				'subtitle'    => '',
				'heading'     => '',
				'type'        => 'checkbox',
				'id'          => 'responsive_blog_testimonial_section',
				'description' => __( 'Check to disable', 'responsive-blog' ),
				'placeholder' => ''
			),
			array(
				'title'       => __( 'Title', 'responsive-blog' ),
				'subtitle'    => '',
				'heading'     => '',
				'type'        => 'text',
				'id'          => 'responsive_blog_testimonial_title',
				'description' => '',
				'placeholder' => 'Testimonial Section title is displayed here'
			),
			array(
				'title'       => __( 'Choose category for testimonials <div class="options-description"><i>Recommended image size: 150 x 150 px</i> </div>', 'responsive-blog' ),
				'subtitle'    => '',
				'heading'     => '',
				'id'          => 'responsive_blog_testimonial_post_categories',
				'type'        => 'select',
				'options'     => Responsive_Blog_Options::responsive_testimonial_posts()
			),

			/* =============== Recent Post section ======================== */
			array(
				'title'       => '<strong>' . __( 'Recent Post section:', 'responsive-blog' ) . '</strong>',
				'subtitle'    => '',
				'heading'     => '',
				'type'        => 'description',
				'id'          => '',
				'description' => ''
			),
			array(
				'title'       => __( 'Show recent post section ?', 'responsive-blog' ),
				'subtitle'    => '',
				'heading'     => '',
				'type'        => 'checkbox',
				'id'          => 'responsive_blog_recent_post_section',
				'description' => __( 'Check to disable', 'responsive-blog' ),
				'placeholder' => ''
			),
			array(
				'title'       => __( 'Title', 'responsive-blog' ),
				'subtitle'    => '',
				'heading'     => '',
				'type'        => 'text',
				'id'          => 'responsive_blog_recent_post_title',
				'description' => '',
				'placeholder' => 'Recent Post Section title is displayed here'
			),
			array(
				'title'       => __( 'Choose category to display recent posts <div class="options-description"><i>Recommended image size: 174 x 159 px</i> </div>', 'responsive-blog' ),
				'subtitle'    => '',
				'heading'     => '',
				'id'          => 'responsive_blog_recent_post_categories',
				'type'        => 'select',
				'options'     => Responsive_Blog_Options::responsive_blog_posts()
			),
			
			/* =============== Upcoming Events Section Switch - RM 2-2018 ======== */
			array(
				'title'       => '<strong>' . __( 'Upcoming Events section on/off:', 'responsive-blog' ) . '</strong>',
				'subtitle'    => '',
				'heading'     => '',
				'type'        => 'description',
				'id'          => '',
				'description' => ''
			),
			array(
				'title'       => __( 'Show Upcoming Events section?', 'responsive-blog' ),
				'subtitle'    => '',
				'heading'     => '',
				'type'        => 'checkbox',
				'id'          => 'responsive_blog_upcoming_events_section',
				'description' => __( 'Check to disable', 'responsive-blog' ),
				'placeholder' => ''
			),
			
			
			
			
			
		)
	);
	$options = array_merge($options, $new_options);
	
	return $options;
}
add_filter( 'responsive_options_filter', 'responsive_blog_options' );

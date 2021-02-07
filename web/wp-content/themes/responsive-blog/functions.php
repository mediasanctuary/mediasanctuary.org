<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
  exit;
}

/**
 * Check if responsivepro plugin is active and message
*/
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );  
function responsive_blog_error_notice()
{
	if( is_plugin_active('responsivepro-plugin/index.php'))
	{
		?>
		<div class="admin-maintenance" style="padding:1em; background-color:#fff; border-left:4px solid #dd2828; margin-top:1em; font-weight: bold; font-size: 16px; max-width: 90%;">Please do not activate the Responsive Pro plugin and the Responsive Blog child theme at the same time.</div>
<?php
	}
}
add_action( 'admin_notices', 'responsive_blog_error_notice' );

// Enqueue scripts and js
function responsive_blog_scripts()
{
	// Define paths
	$directory_uri  = get_stylesheet_directory_uri();
	$bootstrap_path = $directory_uri . '/lib/bootstrap/';

	// Load Bootstrap Library Items
	wp_enqueue_style( 'bootstrap-style', $bootstrap_path . 'css/bootstrap.min.css', false, '3.3.7' );
	wp_enqueue_script( 'bootstrap-js', $bootstrap_path . 'js/bootstrap.min.js', array( 'jquery' ), '3.3.7', true );

	wp_enqueue_style('animate-style', $directory_uri . '/lib/css/animate.css', false, '3.5.1' );
	wp_enqueue_style( 'fontawesome-style', $directory_uri . '/lib/css/font-awesome.min.css', false, '4.7.0');
	wp_enqueue_script( 'masonry' );
	wp_enqueue_script( 'responsive-blog-magazine', $directory_uri . '/lib/js/magazine.js', 'masonry', '', true );

	wp_enqueue_script('waypoints', $directory_uri . '/lib/js/jquery.waypoints.js', array( 'jquery' ), '4.0.1', true );
	wp_enqueue_script('responsive-blog-animation', $directory_uri . '/lib/js/responsive-blog-animation.js', 'waypoints', '', true );

	wp_enqueue_script( 'responsive-blog-navigation', $directory_uri . '/lib/js/navigation.js', array( 'jquery' ), '', true );
	wp_localize_script( 'responsive-blog-navigation', 'screenReaderText', array(
		'expand'   => __( 'expand child menu', 'responsive-blog' ),
		'collapse' => __( 'collapse child menu', 'responsive-blog' ),
	) );

	wp_enqueue_script('responsive-back-to-top', $directory_uri . '/lib/js/back-to-top.js', array( 'jquery' ), '', true );
	
	wp_enqueue_script('responsive-blog-topnav-fixed', $directory_uri . '/js/topnav-fixed.js', array( 'jquery' ), '', true ); //RM
	
}

add_action( 'wp_enqueue_scripts', 'responsive_blog_scripts' );

// Enqueue css on theme options page
function responsive_blog_admin_enqueue_scripts()
{
	$directory_uri  = get_stylesheet_directory_uri();
	wp_enqueue_style( 'responsive-blog-theme-options', $directory_uri . '/lib/css/admin-css.css', false, '' );
}

add_action( 'admin_print_styles-appearance_page_theme_options', 'responsive_blog_admin_enqueue_scripts' );


$template_directory = get_stylesheet_directory();

require( $template_directory . '/includes/options.php' );
require( $template_directory . '/includes/options-customizer.php' );
require( $template_directory . '/includes/home-template-functions.php' );
require( $template_directory . '/includes/classes/testimonial.php' );
require( $template_directory . '/includes/widget.php' );
require( $template_directory . '/pro/functions.php' );
require( $template_directory . '/includes/mini-homepage-functions.php' ); //RM

/**
 * Set a fallback menu that will show a home link.
 */
function responsive_blog_fallback_menu() {
	$args    = array(
		'depth'       => 1,
		'sort_column' => 'menu_order, post_title',
		'menu_class'  => 'nav',
		'include'     => '',
		'exclude'     => '',
		'echo'        => false,
		'show_home'   => true,
		'link_before' => '',
		'link_after'  => ''
	);
	$pages   = wp_page_menu( $args );
	$prepend = '<div class="responsive-blog-nav default-menu">';
	$append  = '</div>';
	$output  = $prepend . $pages . $append;
	echo $output;
}

// Set defaults of responsive blog theme options.
function responsive_blog_option_defaults( $defaults ) {
	$defaults['responsive_blog_post_categories']      = '';
	$defaults['responsive_blog_feature_post_categories']      = '';
	$defaults['responsive_blog_gallery_post_categories']      = '';
	$defaults['responsive_blog_testimonial_post_categories']      = '';
	$defaults['responsive_blog_recent_post_categories']      = '';
	//$defaults['responsive_blog_front_page']      = '1';
	$defaults['responsive_blog_slider_effect']      = '';

	// default on for all sections
	$defaults['responsive_blog_slider_section'] = '';
	$defaults['responsive_blog_callout_section'] = '';
	$defaults['responsive_blog_features_section'] = '';
	$defaults['responsive_blog_gallery_section'] = '';
	$defaults['responsive_blog_testimonial_section'] = '';
	$defaults['responsive_blog_recent_post_section'] = '';

	//default for text fields
	$defaults['responsive_blog_callout_text'] = __('Callout description text is displayed here','responsive-blog');
	$defaults['responsive_blog_features_title'] = __('Featured Category Section title is displayed here','responsive-blog');
	$defaults['responsive_blog_features_desc'] = __('Featured Category Section description is displayed here','responsive-blog');
	$defaults['responsive_blog_gallery_title'] = __('Gallery Section title is displayed here','responsive-blog');
	$defaults['responsive_blog_testimonial_title'] = __('Testimonial Section title is displayed here','responsive-blog');
	$defaults['responsive_blog_recent_post_title'] = __('Recent Post Section title is displayed here','responsive-blog');

	return $defaults;
}

add_filter( 'responsive_option_defaults', 'responsive_blog_option_defaults' );

/*================== Footer sidebar =======================================*/

// deregister footer widget - RM and other widgets
function responsive_blog_remove_footer() {

	unregister_sidebar( 'footer-widget' );
	unregister_sidebar( 'home-widget-1' );
	unregister_sidebar( 'home-widget-2' );
	unregister_sidebar( 'home-widget-3' );
}
add_action( 'widgets_init', 'responsive_blog_remove_footer', 11 );

// register new footer widget - RM and other sidebar/widgets
function responsive_blog_widgets_init() {

	register_sidebar( array(
						'name'          => __( 'Footer Widget', 'responsive' ),
						'description'   => __( 'Area 12 - sidebar-footer.php - Maximum of 4 widgets per row', 'responsive-blog' ),
						'id'            => 'responsive-blog-footer-widget',
						'before_title'  => '<div class="widget-title"><span>',
						'after_title'   => '</span></div>',
						'before_widget' => '<div id="%1$s" class="col-xs-12 col-sm-6 col-md-6 col-lg-3 %2$s"><div class="widget-wrapper">',
						'after_widget'  => '</div></div>'
	) );
	
	register_sidebar( array(
						  'name'          => __( 'Frontpage Middle Widget(s)', 'responsive' ),
						'description'   => __( 'Area 13 sidebar-frontpage-middle.php- Full width widget area for front page', 'responsive-blog' ),
						'id'            => 'responsive-blog-frontpage-middle',
						  'before_title'  => '<div class="widget-title"><h3>',
						  'after_title'   => '</h3></div>',
						  'before_widget' => '<div id="%1$s" class="frontpage-middle widget-wrapper %2$s">',
						  'after_widget'  => '</div>'
					  ) );
					  
	register_sidebar( array(
						  'name'          => __( 'Mini-homepage sidebar', 'responsive' ),
						'description'   => __( 'Area 14 sidebar-mini-homepage.php - Side column widget area for Mini-homepages', 'responsive-blog' ),
						'id'            => 'responsive-blog-mini-homepage',
						  'before_title'  => '<div class="widget-title"><h3>',
						  'after_title'   => '</h3></div>',
						  'before_widget' => '<div id="%1$s" class="mini-homepage widget-wrapper %2$s">',
						  'after_widget'  => '</div>'
					  ) );  
	
}
add_action( 'widgets_init', 'responsive_blog_widgets_init', 50 );

/* Add fit class to third footer widget */
function responsive_blog_footer_widgets( $params ) {

	global $footer_widget_num; //Our widget counter variable

	//Check if we are displaying "Footer Sidebar"
	if ( $params[0]['id'] == 'responsive-blog-footer-widget' ) {
		$footer_widget_num++;
		$divider = 4;
		$divider = apply_filters( 'responsive_number_footer_widgets', $divider ); //This is number of widgets that should fit in one row

		//If it's third widget, add last class to it
		if ( $footer_widget_num % $divider == 0 ) {
			$class                      = 'class="fit ';
			$params[0]['before_widget'] = str_replace( 'class="', $class, $params[0]['before_widget'] );
		}

	}

	return $params;
}

function ms_setup_theme() {
    add_theme_support( 'post-thumbnails' );
    set_post_thumbnail_size( 630, 440, true );
    //add_theme_support( 'html5', array( 'search-form' ) );

}
add_action( 'after_setup_theme', 'ms_setup_theme' );
add_filter( 'dynamic_sidebar_params', 'responsive_blog_footer_widgets' );


add_filter('wp_nav_menu_items','add_new_menu_item', 10, 2);
function add_new_menu_item( $nav, $args ) {
    if( $args->theme_location == 'top-menu' )
    $newmenuitem = '<li class="top_search">' . get_search_form(false) . '</li>';
    $nav = $newmenuitem.$nav;
    return $nav;
}


/*========= Post meta function ================*/

if ( !function_exists( 'responsive_blog_post_meta_data' ) ) {

	function responsive_blog_post_meta_data() {
	
	global $post;
		
		printf( sprintf( '<span class="author vcard"><em>by</em> <a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
						 get_author_posts_url( get_the_author_meta( 'ID' ) ),
						 sprintf( esc_attr__( 'View all posts by %s', 'responsive' ), get_the_author() ),
						 esc_attr( get_the_author() ),
						 get_avatar( get_the_author_meta( 'ID' ), 32)
				)
		);
		
		
	// RM get 'Posted in' cats from all taxonomies
	$the_post_type = get_post_type( $post->ID );
	switch ($the_post_type) {
    /*case "image-galleries":
        $the_tax = 'image_gallery_categories';
        break;
    case "image-galleries":
        $the_tax = 'image_gallery_categories';
        break;
    case "event":
        $the_tax = 'event-categories';
        break;*/
    case "podcasts":
        $the_tax = 'podcast_categories';
        break;
	case "post":
		$the_tax = 'category';
		break;
	default:
        $the_tax = 'category';
	}
	$the_term = get_the_term_list( $post->ID, $the_tax,' <em>in</em> ', ', ' );  
	echo $the_term;
	
		printf( sprintf( '<span class="single_post_time" title="%2$s" rel="bookmark"><i aria-hidden="true"></i>
<time class="timestamp updated" datetime="%3$s"><em>on</em> <span class="pmtime">%4$s</span></time></span>',
						 esc_url( get_permalink() ),
						 esc_attr( get_the_title() ),
						 esc_html( get_the_date('c')),
						 esc_html( get_the_date('n.j.Y') )
				)

		);
	}

}


/* ORIG post meta :::::

if ( !function_exists( 'responsive_blog_post_meta_data' ) ) {

	function responsive_blog_post_meta_data() {
		printf( sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s"><span class="author-gravtar">%4$s</span>%3$s</a></span>',
						 get_author_posts_url( get_the_author_meta( 'ID' ) ),
						 sprintf( esc_attr__( 'View all posts by %s', 'responsive' ), get_the_author() ),
						 esc_attr( get_the_author() ),
						 get_avatar( get_the_author_meta( 'ID' ), 32)
				)
		);
		printf( sprintf( '<span class="single_post_time" title="%2$s" rel="bookmark"><i class="fa fa-clock-o" aria-hidden="true"></i>
<time class="timestamp updated" datetime="%3$s">%4$s</time></span>',
						 esc_url( get_permalink() ),
						 esc_attr( get_the_title() ),
						 esc_html( get_the_date('c')),
						 esc_html( get_the_date() )
				)

		);
	}

}
*/


/*=================== Comment function =================*/
if ( ! function_exists( 'responsive_blog_comment' ) ) :
// Template for comments and pingbacks.
// Used as a callback by wp_list_comments() for displaying the comments.
function responsive_blog_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'responsive-blog' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'responsive-blog' ), ' ' ); ?></p>
	<?php
			break;
		default :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment hreview">
			<footer>
				<div class="comment-author reviewer vcard">
					<?php echo get_avatar( $comment, 40 ); ?>
					<?php printf( '%s' , sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
				</div><!-- .comment-author .vcard -->
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em><?php _e( 'Your comment is awaiting moderation.', 'responsive-blog' ); ?></em>
					<br />
				<?php endif; ?>

				<div class="comment-content"><?php comment_text(); ?></div>
				<div class="commentmeta-reply">
					<span class="comment-meta commentmetadata">
						<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>" class="dtreviewed"><time pubdate datetime="<?php comment_time( 'c' ); ?>">
						<?php
							/* translators: 1: date, 2: time */
							printf( __( '%1$s at %2$s', 'responsive-blog' ), get_comment_date(), get_comment_time() ); ?>
						</time></a>
						<?php edit_comment_link( __( '(Edit)', 'responsive-blog' ), ' ' );
						?>
					</span><!-- .comment-meta .commentmetadata -->
					<span class="reply">
						<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
					</span><!-- .reply -->
				</div>
				
			</footer>

			

			
		</article><!-- #comment-## -->

	<?php
			break;
	endswitch;
}
endif; // ends check for comment

/*===============Comment Validation script =========================*/
function responsive_blog_comment_validation_init() {
	if(is_singular() && comments_open() ) {
	wp_enqueue_script( 'responsive_blog-jquery-validation', get_stylesheet_directory_uri() . '/lib/js/jquery.validate.min.js', array(), true );
	wp_enqueue_script( 'responsive_blog-comment-validation', get_stylesheet_directory_uri() . '/lib/js/comment-validation.js', array(), true );

	}
}
add_action('wp_footer', 'responsive_blog_comment_validation_init');
/*======================== Comment Validation script ====================================== */

// Typography styles for theme
add_action( 'wp_head', 'responsive_blog_customize_styles', 100 );

function responsive_blog_customize_styles()
{
	$responsive_blog_font_heading            = get_theme_mod( 'responsive_blog_font_heading' );
	$responsive_blog_google_font_heading     = ( get_theme_mod( 'responsive_blog_google_font_heading' ) != '' ) ? responsive_blog_google_font( get_theme_mod( 'responsive_blog_google_font_heading' ) ) : '';
	$responsive_blog_font_text             = get_theme_mod( 'responsive_blog_font_text' );
	$responsive_blog_google_font_text      = ( get_theme_mod( 'responsive_blog_google_font_text' ) != '' ) ? responsive_blog_google_font( get_theme_mod( 'responsive_blog_google_font_text' ) ) : '';

	// create a string to add to the google font stylesheet call
	$google_param = ( $responsive_blog_google_font_heading != '' ) ? $responsive_blog_google_font_heading['param'] : '';
	$google_param .= ( $responsive_blog_google_font_heading != '' && $responsive_blog_google_font_text != '' ) ? '|' : '';
	$google_param .= ( $responsive_blog_google_font_text != '' ) ? $responsive_blog_google_font_text['param'] : '';

	if( $responsive_blog_google_font_heading != '' && $responsive_blog_font_heading == 'google' || $responsive_blog_google_font_text != '' && $responsive_blog_font_text == 'google' ) {
		?>
		<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=<?php echo $google_param; ?>">
	<?php
	} ?>

	<style type="text/css" id="customizer_styles">
		body.front-page.home, .responsive-blog-nav .nav > li > a, .responsive-blog-nav .sub-menu a, #responsive_blog_single_post .post-title, #aspire_content .post_article .responsive_blog_magazine_title .entry-title
		{
		<?php
		if( $responsive_blog_font_heading != 'google' ) { ?> font-family: <?php echo esc_html( $responsive_blog_font_heading ); ?>;
		<?php
		}
		elseif( $responsive_blog_google_font_heading != '' ) {?> font-family: '<?php echo esc_html( $responsive_blog_google_font_heading['font'] ); ?>';
		<?php } ?>
		}

		#responsive_blog_footer, #responsive_blog_single_post, #features .section-top #features-desc, #features .section-bottom .feature-single-title, #features .section-bottom .feature-single-desc, #testimonial .section-bottom, #recent_post .section-bottom, body
		{
		<?php
		if( $responsive_blog_font_text != 'google' ) { ?> font-family: <?php echo esc_html( $responsive_blog_font_text ); ?>;
		<?php
		}
		elseif( $responsive_blog_google_font_text != '' ) {?> font-family: '<?php echo esc_html( $responsive_blog_google_font_text['font'] ); ?>';
		<?php } ?>
		}
	</style>

<?php
}

function responsive_blog_google_font( $font = '' ) {
	if( $font != '' ) {
		// Capitalize the first letter of each word to follow Google Font's naming convention
		$google['font']  = ucwords( $font );
		$google['param'] = trim( str_replace( ' ', '+', $google['font'] ) );

		return $google;
	}
	else {
		return null;
	}
}

//Check if slider section is off and modify css
function responsive_blog_slider_section_check()
{
	$responsive_options = responsive_get_options();
	$slider_section_status = $responsive_options['responsive_blog_slider_section'];

	if ($slider_section_status == 1)
	{ ?>
		<style type="text/css">
			.home.front-page #header
			{
				position:relative;
			}
		</style>
		
<?php }
}

add_action('wp_head', 'responsive_blog_slider_section_check');

//Function to unregister -sub header menu
function responsive_blog_unregister_subheadermenu()
{
    unregister_nav_menu( 'sub-header-menu' );
    unregister_nav_menu( 'footer-menu' );
    
}
add_action( 'init', 'responsive_blog_unregister_subheadermenu', 20 );

// Social icons images modification

function responsive_blog_get_social_icons() {

	$responsive_options = responsive_get_options();

	$sites = array (
		'twitter'     => __( 'Twitter', 'responsive' ),
		'facebook'    => __( 'Facebook', 'responsive' ),
		'linkedin'    => __( 'LinkedIn', 'responsive' ),
		'youtube'     => __( 'YouTube', 'responsive' ),
		'stumbleupon' => __( 'StumbleUpon', 'responsive' ),
		'rss'         => __( 'RSS Feed', 'responsive' ),
		'googleplus'  => __( 'Google+', 'responsive' ),
		'instagram'   => __( 'Instagram', 'responsive' ),
		'pinterest'   => __( 'Pinterest', 'responsive' ),
		'yelp'        => __( 'Yelp!', 'responsive' ),
		'vimeo'       => __( 'Vimeo', 'responsive' ),
		'foursquare'  => __( 'foursquare', 'responsive' ),
	);

	$html = '<ul class="social-icons">';
	foreach( $sites as $key => $value ) {
		if ( !empty( $responsive_options[$key . '_uid'] ) ) {
			$html .= '<li class="' . esc_attr( $key ) . '-icon"><a href="' . $responsive_options[$key . '_uid'] . '">' . '<img src="' . responsive_child_uri( '/lib/icons/' . esc_attr( $key ) . '-icon.png' ) . '" width="24" height="24" alt="' . esc_html( $value ) . '">' . '</a></li>';
		}
	}
	$html .= '</ul><!-- .social-icons -->';

	$html = apply_filters( 'responsive_social_skin' , $html );

	return $html;

}

/* ///////// Media Sanctuary addtions - RM 9-2017 \\\\\\\\\\\\ */

/* ///////// RM Make widget titles optional ///////////// 
Partially from Plugin URI: http://scratch99.com/wordpress/plugins/remove-widget-titles/ */

add_filter( 'widget_title', 'remove_widget_title' );
function remove_widget_title( $widget_title ) {
	if ( substr ( $widget_title, 0, 1 ) == '[' )
		return;
	else 
		return ( $widget_title );
}


add_action('init', 'remove_plugin_image_sizes');

function remove_plugin_image_sizes() {
	remove_image_size( 'responsive-100');
	remove_image_size( 'responsive-150');
	remove_image_size( 'responsive-200');
	remove_image_size( 'responsive-300');
	remove_image_size( 'responsive-450' );
	remove_image_size( 'responsive-600');
	remove_image_size( 'responsive-900');
}



/* /////////// RM unset various page templates ////////// */

add_filter( 'theme_page_templates', 'my_remove_page_template' );
    function my_remove_page_template( $pages_templates ) {
    	$page_templates_dis = array ('landing-page.php', 'blog.php','blog-3-col.php','blog-excerpt.php','blog-magazine.php','sidebar-content-half-page.php','content-sidebar-half-page.php','sitemap.php');
    	foreach ($page_templates_dis as $page_template_file) {
    		unset( $pages_templates[$page_template_file] );
    	}
    return $pages_templates;
}

/* See: responsive/core/includes/classes/Responsive_Options.php 307 RM */
add_filter( 'responsive_valid_layouts', 'my_remove_post_template' );
    function my_remove_post_template( $posts_templates ) {
    	$post_templates_dis = array ('content-sidebar-half-page','sidebar-content-half-page','blog-3-col');
    	foreach ($post_templates_dis as $post_template_file) {
    		unset( $posts_templates[$post_template_file] );
    	}
    return $posts_templates;
}



/* Trim archive title prefix (processed through loop-header.php */
add_filter( 'get_the_archive_title', function ($title) {

    if ( is_category() ) {

            $title = single_cat_title( '', false );

        } elseif ( is_tag() ) {

            $title = single_tag_title( '', false );

        } elseif ( is_author() ) {

            $title = '<span class="vcard">' . get_the_author() . '</span>' ;

        }

    return $title;

});



/* RM show posts of ALL types in author archive   2-27-2020 */
function author_all_post_types( $query ) {
    if ( $query->is_main_query() && $query->is_author() )
        $query->set( 'post_type', 'any' );
}
add_action( 'pre_get_posts', 'author_all_post_types' );
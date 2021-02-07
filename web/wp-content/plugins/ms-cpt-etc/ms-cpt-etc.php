<?php
   /*
   Plugin Name: MS Custom Post Types, Taxonomies and misc
   Plugin URI: 
   Description: A plugin to establish WP custom post types, taxonomies and a few other features accross themes
   Version: 1.0
   Author: RM
   Author URI:
   Text Domain: ms-cpt-etc
   License: GPL2
   */
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

add_action( 'init', 'register_cpt_image_galleries' );

function register_cpt_image_galleries() {

	$labels = array(
		'name' => __( 'Image Gallery posts', 'image-galleries' ),
		'singular_name' => __( 'Image galleries', 'image-galleries' ),
		'add_new' => __( 'Add New', 'image-gallery posts' ),
		'add_new_item' => __( 'Add New Image gallery post', 'image-galleries' ),
		'edit_item' => __( 'Edit Image Gallery post', 'image-galleries' ),
		'new_item' => __( 'New Image Gallery post', 'image-galleries' ),
		'view_item' => __( 'View Image Gallery', 'image-galleries' ),
		'search_items' => __( 'Search Image Gallery posts', 'image-galleries' ),
		'not_found' => __( 'No Image gallery posts found', 'image-galleries' ),
		'not_found_in_trash' => __( 'No Image gallery posts found in Trash', 'image-galleries' ),
		'parent_item_colon' => __( 'Parent Image gallery posts:', 'image-galleries' ),
		'menu_name' => __( 'Image Gallery Posts', 'image-galleries' ),
	);

	$args = array(
		'labels' => $labels,
		'hierarchical' => false,
		'description' => 'Posts that contain mediasanctuary.org picture galleries',
		'supports' => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'custom-fields',  ),
		'taxonomies' => array( 'image_gallery_categories','post_tag' ),
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'menu_position' => 5,
		'show_in_nav_menus' => true,
		'publicly_queryable' => true,
		'exclude_from_search' => false,
		'has_archive' => true,
		'query_var' => true,
		'can_export' => true,
		'rewrite' => true,
		'capability_type' => 'post'
	);

	register_post_type( 'image-galleries', $args );
	

	
	// Image gallery categories
	
	$catlabels = array(
    'name' => _x( 'Image gallery categories', 'Image gallery categories' ),
    'singular_name' => _x( 'Image galleries', 'Image gallery category' ),
    'search_items' =>  __( 'Search Image gallery categories' ),
    'all_items' => __( 'All Image gallery categories' ),
    'parent_item' => __( 'Parent category' ),
    'parent_item_colon' => __( 'Parent category:' ),
    'edit_item' => __( 'Edit Image gallery category' ), 
    'update_item' => __( 'Update Image gallery category' ),
    'add_new_item' => __( 'Add New Image gallery category' ),
    'new_item_name' => __( 'New Image gallery category' ),
    'menu_name' => __( 'Image gallery categories' ),
  ); 	
  register_taxonomy('image_gallery_categories',array('image-galleries'), array(
    'hierarchical' => true,
    'labels' => $catlabels,
    'show_ui' => true,
    'show_admin_column' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'gallery-category' ),
  ));
  
  
	/*/ Image galleries Tags NOT IN USE for now RM 8-2017
   $taglabels = array(
    'name' => _x( 'Image gallery Tags', 'Image gallery Tags' ),
    'singular_name' => _x( 'tag', 'Image gallery tag' ),
    'search_items' =>  __( 'Search Image gallery Tags' ),
    'popular_items' => __( 'Popular Image gallery Tags' ),
    'all_items' => __( 'All Image gallery Tags' ),
    'parent_item' => null,
    'parent_item_colon' => null,
    'edit_item' => __( 'Edit Image gallery Tag' ), 
    'update_item' => __( 'Update Image gallery Tag' ),
    'add_new_item' => __( 'Add New Image gallery Tag' ),
    'new_item_name' => __( 'New Image gallery Tag' ),
    'separate_items_with_commas' => __( 'Separate tags with commas' ),
    'add_or_remove_items' => __( 'Add or remove tags' ),
    'choose_from_most_used' => __( 'Choose from the most used Image gallery Tags' ),
    'menu_name' => __( 'Image gallery Tags' ),
  ); 
 register_taxonomy('image_gallery_tags','image-galleries',array(
    'hierarchical' => false,
    'labels' => $taglabels,
    'show_ui' => true,
    'show_admin_column' => true,
    'update_count_callback' => '_update_post_term_count',
    'query_var' => true,
    'rewrite' => array( 'slug' => 'image_gallery_tag' ),
  ));*/

	// for connection insurance::
	
	register_taxonomy_for_object_type( 'image_gallery_categories', 'image-galleries' );
	//register_taxonomy_for_object_type( 'image_gallery_tags', 'image-galleries' );
	


	// below this is for connecting standard WP cats and tags to post type 
	//register_taxonomy_for_object_type( 'category', 'image-galleries' );
	register_taxonomy_for_object_type( 'post_tag', 'image-galleries' );
	
}


///// image-galleries archive page post count
/*function set_posts_per_page_for_image_galleries_cpt( $query ) {
  if ( !is_admin() && $query->is_main_query() && is_post_type_archive( 'image-galleries' ) ) {
    $query->set( 'posts_per_page', '10' );
  }
}
add_action( 'pre_get_posts', 'set_posts_per_page_for_image_galleries_cpt' );*/


add_action( 'init', 'register_cpt_people_power' );

function register_cpt_people_power() {

	$labels = array(
		'name' => __( 'People Power', 'peoplepower' ),
		'singular_name' => __( 'People Power', 'peoplepower' ),
		'add_new' => __( 'Add New', 'peoplepower' ),
		'add_new_item' => __( 'Add People Power post', 'peoplepower' ),
		'edit_item' => __( 'Edit People Power post', 'peoplepower' ),
		'new_item' => __( 'New People Power post', 'peoplepower' ),
		'view_item' => __( 'View People Power posts', 'peoplepower' ),
		'search_items' => __( 'Search People Power posts', 'peoplepower' ),
		'not_found' => __( 'No People Power posts found', 'peoplepower' ),
		'not_found_in_trash' => __( 'No People Power posts found in Trash', 'peoplepower' ),
		'parent_item_colon' => __( 'Parent People Power:', 'peoplepower' ),
		'menu_name' => __( 'People Power', 'peoplepower' ),
	);

	$args = array(
		'labels' => $labels,
		'hierarchical' => false,
		'description' => 'People Power posts (profiles etc)',
		'supports' => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'custom-fields',  ),
		'taxonomies' => array( 'people_power_categories', 'post_tag' ),
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'menu_position' => 5,
		'show_in_nav_menus' => true,
		'publicly_queryable' => true,
		'exclude_from_search' => false,
		'has_archive' => true,
		'query_var' => true,
		'can_export' => true,
		'rewrite' => true,
		'capability_type' => 'post'
	);

	register_post_type( 'peoplepower', $args );
	

	
	// People Power categories
	
	$catlabels = array(
    'name' => _x( 'People Power categories', 'People Power categories' ),
    'singular_name' => _x( 'People', 'People Power category' ),
    'search_items' =>  __( 'Search People Power categories' ),
    'all_items' => __( 'All People Power categories' ),
    'parent_item' => __( 'Parent category' ),
    'parent_item_colon' => __( 'Parent category:' ),
    'edit_item' => __( 'Edit People Power category' ), 
    'update_item' => __( 'Update People Power category' ),
    'add_new_item' => __( 'Add New People Power category' ),
    'new_item_name' => __( 'New People Power category' ),
    'menu_name' => __( 'People Power categories' ),
  ); 	
  register_taxonomy('people_power_categories',array('peoplepower'), array(
    'hierarchical' => true,
    'labels' => $catlabels,
    'show_ui' => true,
    'show_admin_column' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'peoplepower-category' ),
  ));
  
  
	// for connection insurance::
	
	register_taxonomy_for_object_type( 'people_power_categories', 'peoplepower' );

	// below this is for connecting standard WP cats and tags to post type 
	//register_taxonomy_for_object_type( 'category', 'peoplepower' );
	register_taxonomy_for_object_type( 'post_tag', 'peoplepower' );
	
	/* connect post_tag to events [events manager plugin] too */
	register_taxonomy_for_object_type( 'post_tag', 'event' );
	
}

add_action( 'init', 'register_cpt_podcast' );

function register_cpt_podcast() {

	$labels = array(
		'name' => __( 'Podcast', 'podcasts' ),
		'singular_name' => __( 'Podcast', 'podcasts' ),
		'add_new' => __( 'Add New', 'podcast' ),
		'add_new_item' => __( 'Add Podcast post', 'podcast' ),
		'edit_item' => __( 'Edit Podcast post', 'podcast' ),
		'new_item' => __( 'New Podcast post', 'podcast' ),
		'view_item' => __( 'View Podcast posts', 'podcast' ),
		'search_items' => __( 'Search Podcast posts', 'podcast' ),
		'not_found' => __( 'No Podcast posts found', 'podcast' ),
		'not_found_in_trash' => __( 'No Podcast posts found in Trash', 'podcast' ),
		'parent_item_colon' => __( 'Parent Podcast:', 'podcast' ),
		'menu_name' => __( 'Podcast posts', 'podcast' ),
	);

	$args = array(
		'labels' => $labels,
		'hierarchical' => false,
		'description' => 'Podcast posts (podcasts etc)',
		'supports' => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'custom-fields',  ),
		'taxonomies' => array( 'podcast_categories', 'post_tag' ),
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'menu_position' => 5,
		'show_in_nav_menus' => true,
		'publicly_queryable' => true,
		'exclude_from_search' => false,
		'has_archive' => true,
		'query_var' => true,
		'can_export' => true,
		'rewrite' => true,
		'capability_type' => 'post'
	);

	register_post_type( 'podcasts', $args );
	

	
	// Podcast categories
	
	$catlabels = array(
    'name' => _x( 'Podcast categories', 'Podcast categories' ),
    'singular_name' => _x( 'Podcasts', 'Podcast category' ),
    'search_items' =>  __( 'Search Podcast categories' ),
    'all_items' => __( 'All Podcast categories' ),
    'parent_item' => __( 'Parent category' ),
    'parent_item_colon' => __( 'Parent category:' ),
    'edit_item' => __( 'Edit Podcast category' ), 
    'update_item' => __( 'Update Podcast category' ),
    'add_new_item' => __( 'Add New Podcast category' ),
    'new_item_name' => __( 'New Podcast category' ),
    'menu_name' => __( 'Podcast categories' ),
  ); 	
  register_taxonomy('podcast_categories',array('podcasts'), array(
    'hierarchical' => true,
    'labels' => $catlabels,
    'show_ui' => true,
    'show_admin_column' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'podcast-categories' ),
  ));
  
  	// for connection insurance::
	
	register_taxonomy_for_object_type( 'podcast_categories', 'podcasts' );

	// below this is for connecting standard WP cats and tags to post type 
	//register_taxonomy_for_object_type( 'category', 'peoplepower' );
	register_taxonomy_for_object_type( 'post_tag', 'podcasts' );
	
}

/* assign default custom taxonomy category to cpt post */

function set_default_object_terms_203962( $post_id, $post ) {
if ( 'publish' === $post->post_status ) {
    $defaults = array(
        //'your_taxonomy_id' => array( 'your_term_slug', 'your_term_slug' )
        'people_power_categories' => array( 'people' ),
        'image_gallery_categories' => array( 'galleries' ),
        'podcast_categories' => array( 'podcasts' ),
        );
    $taxonomies = get_object_taxonomies( $post->post_type );
    foreach ( (array) $taxonomies as $taxonomy ) {
        $terms = wp_get_post_terms( $post_id, $taxonomy );
        if ( empty( $terms ) && array_key_exists( $taxonomy, $defaults ) ) {
            wp_set_object_terms( $post_id, $defaults[$taxonomy], $taxonomy );
        }
    }}
}
add_action( 'save_post', 'set_default_object_terms_203962', 100, 2 );


/* //// Excerpt whilespace/HTML preservation */


function wpse_allowedtags() {
    // Add custom tags to this string
        return '<style>,<br>,<em>,<i>,<ul>,<ol>,<li>,<a>,<p>,<video>,<audio>,<span>';
        /*orig: '<script>,<style>,<br>,<em>,<i>,<ul>,<ol>,<li>,<a>,<p>,<img>,<video>,<audio>';*/ 
    }

if ( ! function_exists( 'wpse_custom_wp_trim_excerpt' ) ) : 

    function wpse_custom_wp_trim_excerpt($wpse_excerpt) {
    global $post;
    $raw_excerpt = $wpse_excerpt;
    
    $excerpt_post_type = get_post_type();
 	if ( $excerpt_post_type == 'image-galleries' || $excerpt_post_type == 'podcasts' || has_category('projects') ) {
 		$the_word_count = 14;
 	} elseif ( is_post_type_archive( 'peoplepower' ) || is_tax( 'people_power_categories')) {
 		$the_word_count = 40;
 	} elseif ( $excerpt_post_type == 'peoplepower') {
 		$the_word_count = 14;
 	} else {
 		$the_word_count = 55;
 	}
 	
        if ( '' == $wpse_excerpt ) {

            $wpse_excerpt = get_the_content('');
            //$wpse_excerpt = strip_shortcodes( $wpse_excerpt );
            $wpse_excerpt = preg_replace('/(\\[.*\\])/', '',$wpse_excerpt); // RM works better for short codes
            $wpse_excerpt = apply_filters('the_content', $wpse_excerpt);
            $wpse_excerpt = str_replace(']]>', ']]&gt;', $wpse_excerpt);
            
            //iframe (so not to leave content from inside iframe)
        $wpse_excerpt = preg_replace('/<iframe[^>]*>.*?<\/iframe>/i', '', $wpse_excerpt);
            
            
            $wpse_excerpt = strip_tags($wpse_excerpt, wpse_allowedtags()); /*IF you need to allow just certain tags. Delete if all tags are allowed */

            //Set the excerpt word count and only break after sentence is complete.
                $excerpt_word_count = $the_word_count;/*55 75*/
                $excerpt_length = apply_filters('excerpt_length', $excerpt_word_count); 
                $tokens = array();
                $excerptOutput = '';
                $count = 0;

                // Divide the string into tokens; HTML tags, or words, followed by any whitespace
                preg_match_all('/(<[^>]+>|[^<>\s]+)\s*/u', $wpse_excerpt, $tokens);

                foreach ($tokens[0] as $token) { 

                    if ($count >= $excerpt_word_count /*&& preg_match('/[\,\;\?\.\!]\s*$/uS', $token) RM - just trin on count */) { 
                    // Limit reached, continue until , ; ? . or ! occur at the end
                        $excerptOutput .= trim($token);
                        $excerptOutput .= ' ... '; /* RM */
                        break;
                    }

                    // Add words to complete sentence
                    $count++;

                    // Append what's left of the token
                    $excerptOutput .= $token;
                }

            $wpse_excerpt = trim(force_balance_tags($excerptOutput));
            
            	$excerpt_end = '<div class="moretag_wrap"><a href="'. esc_url( get_permalink() ) . '"><img class="read-more-arrow" src="'. get_stylesheet_directory_uri() .'/images/readmore.png" /></a></div>'; 

               /* $excerpt_end = ' <a href="'. esc_url( get_permalink() ) . '">' . '&nbsp;&raquo;&nbsp;' . sprintf(__( 'Read more about: %s &nbsp;&raquo;', 'wpse' ), get_the_title()) . '</a>'; */
                $excerpt_more = apply_filters('excerpt_more', ' ' . $excerpt_end); 
				
                //$pos = strrpos($wpse_excerpt, '</');
                //if ($pos !== false)
                // Inside last HTML tag
                //$wpse_excerpt = substr_replace($wpse_excerpt, $excerpt_end, $pos, 0); /* Add read more next to last word */
                //else
                // After the content
                $wpse_excerpt .= $excerpt_end; /*Add read more in new paragraph */

            return $wpse_excerpt;   

        }
        return apply_filters('wpse_custom_wp_trim_excerpt', $wpse_excerpt, $raw_excerpt);
    }

endif; 

remove_filter('get_the_excerpt', 'wp_trim_excerpt');
add_filter('get_the_excerpt', 'wpse_custom_wp_trim_excerpt'); 



/**
 * Returns a "Read more" link for manual excerpts
 */

function remove_readmore_txt() {
	remove_filter('get_the_excerpt', 'responsive_custom_excerpt_more');
	//remove_filter('excerpt_more', 'responsive_auto_excerpt_more');
}
add_action( 'after_setup_theme', 'remove_readmore_txt' );

function ms_read_more() {
	return '<div class="moretag_wrap"><a href="'. esc_url( get_permalink() ) . '"><img class="read-more-arrow" src="'. get_stylesheet_directory_uri() .'/images/readmore.png" /></a></div>';
}

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and responsive_read_more_link().
 */
function ms_auto_excerpt_more( $more ) {
	return '<span class="ellipsis">&hellip;</span>' . ms_read_more();
}

add_filter( 'excerpt_more', 'ms_auto_excerpt_more' );

/**
 * Adds a pretty "Read more" link to custom post excerpts.
 */
function ms_custom_excerpt_more( $output ) {
	if ( has_excerpt() && !is_attachment() ) {
		$output .= ms_read_more();
	}
	return $output;
}

add_filter( 'get_the_excerpt', 'ms_custom_excerpt_more' );


////* Event manager stuff */
add_filter('em_category_output_placeholder','cat_em_placeholder_mod',1,3);
function cat_em_placeholder_mod($replace, $EM_Category, $result){
	if ( $result == '#_CATEGORYPASTEVENTS' ) {
	$em_termID = $EM_Category->term_id;
	$args = array('category'=>$em_termID,'order'=>'DESC','scope'=>'past','pagination'=>1, 'limit'=>20);
	$args['format'] = get_option('dbem_category_event_list_item_format');
	$args['format_header'] = get_option('dbem_category_event_list_item_header_format');
	$args['format_footer'] = get_option('dbem_category_event_list_item_footer_format');
	$replace = EM_Events::output($args);
	}
	return $replace;
}


add_filter('em_tag_output_placeholder','tag_em_placeholder_mod',1,3);
function tag_em_placeholder_mod($replace, $EM_Tag, $result){
	if ( $result == '#_TAGPASTEVENTS' ) {
	$em_tagID = $EM_Tag->term_id;
	$args = array('tag'=>$em_tagID,'order'=>'DESC','scope'=>'past','pagination'=>1, 'limit'=>20);
		$args['format_header'] = get_option('dbem_tag_event_list_item_header_format');
		$args['format_footer'] = get_option('dbem_tag_event_list_item_footer_format');
		$args['format'] = get_option('dbem_tag_event_list_item_format');
		$replace = EM_Events::output($args);
	}
	return $replace;
}




/* /// TEMP for NextGen cache  - RM
http://www.zeyalabs.ch/posts/2014/displaying-random-nextgen-gallery-images */


add_action('the_post', 'z_disable_ngg_cache');
 
function z_disable_ngg_cache($post)
{
    if (class_exists('C_Photocrati_Transient_Manager'))
    {
        C_Photocrati_Transient_Manager::flush();
    }
}


/* hide custom fields */
add_action( 'do_meta_boxes', 'remove_default_custom_fields_meta_box', 1, 3 );
function remove_default_custom_fields_meta_box( $post_type, $context, $post ) {
    remove_meta_box( 'postcustom', $post_type, $context );
}



// Remove unwanted TinyMCE buttons from first row
function sm_remove_button_tinymce_first_row( $buttons ) {

    $remove = array('msp_shortcodes_button');

    return array_diff( $buttons, $remove );
}
add_filter('mce_buttons', 'sm_remove_button_tinymce_first_row', 2000);



/* /////////// MS custom meta boxes (some moved here from functions.php ////////// */


/* /////////// RM homeslide info meta box ////////// */

function homeslide_meta_box_markup($object)
{
    wp_nonce_field(basename(__FILE__), "meta-box-nonce-homeslide");

    ?>
        <div>
            <label for="homeslide-link-text">'Read more' url</label>
            <input name="homeslide-link-text" type="text" value="<?php echo get_post_meta($object->ID, "homeslide-link-text", true); ?>">
		</div>
		 <div>
            <label for="homeslide-pretitle-text">Pre-title text</label>
            <input name="homeslide-pretitle-text" type="text" value="<?php echo get_post_meta($object->ID, "homeslide-pretitle-text", true); ?>">
		</div>
    <?php     
}

function add_homeslide_custom_meta_box()
{ /*demo-meta-box*/
    add_meta_box("ms-homeslide-link-meta-box", "Homeslide info", "homeslide_meta_box_markup", "post", "side", "low", null);
}
add_action("add_meta_boxes", "add_homeslide_custom_meta_box");


function save_homeslide_custom_meta_box($post_id, $post, $update)
{
    if (!isset($_POST["meta-box-nonce-homeslide"]) || !wp_verify_nonce($_POST["meta-box-nonce-homeslide"], basename(__FILE__)))
        return $post_id;

    if(!current_user_can("edit_post", $post_id))
        return $post_id;

    if(defined("DOING_AUTOSAVE") && DOING_AUTOSAVE)
        return $post_id;

    $slug = "post";
    if($slug != $post->post_type)
        return $post_id;

    $meta_box_text_value = "";
    $meta_box_text_value2 = "";

    if(isset($_POST["homeslide-link-text"]))
    {
        $meta_box_text_value = $_POST["homeslide-link-text"];
    }   
    update_post_meta($post_id, "homeslide-link-text", $meta_box_text_value);
    
    if(isset($_POST["homeslide-pretitle-text"]))
    {
        $meta_box_text_value2 = $_POST["homeslide-pretitle-text"];
    }   
    update_post_meta($post_id, "homeslide-pretitle-text", $meta_box_text_value2);
}

add_action("save_post", "save_homeslide_custom_meta_box", 10, 3);



/* /////////// RM tags for mini-homepage tag meta box ////////// */

function mini_homepage_post_tags_meta_box($object) {
    wp_nonce_field(basename(__FILE__), "meta-box-nonce"); ?>
	<!-- h2><?php _e( 'Tags:' ); ?></h2 -->
	<?php
		$selected_value = get_post_meta($object->ID, "mini-homepage-tag", true);
		$args = array(
			'show_option_none' => __( 'Select tag' ),
			'taxonomy'		   => 'post_tag',
			'name'               => 'mini-homepage-tag',
			'orderby'            => 'name',
			'selected'           => $selected_value,
		);
		?>

		<?php wp_dropdown_categories( $args); ?>
	  
 	<?php     
}		


function add_mhp_custom_meta_box() { /*demo-meta-box*/
	global $post;
 	$template_file = get_post_meta( $post->ID, '_wp_page_template', TRUE );
 	if ( $template_file == 'mini-homepage-page.php' ) {
		add_meta_box("mini-homepage-post-tags-meta-box", "Tag associated with this mini-homepage", "mini_homepage_post_tags_meta_box", "page", "side", "high", null);
	}
}
add_action("add_meta_boxes", "add_mhp_custom_meta_box");




function save_mini_homepage_custom_meta_box($post_id, $post, $update) {
    if (!isset($_POST["meta-box-nonce"]) || !wp_verify_nonce($_POST["meta-box-nonce"], basename(__FILE__)))
        return $post_id;

    if(!current_user_can("edit_post", $post_id))
        return $post_id;

    if(defined("DOING_AUTOSAVE") && DOING_AUTOSAVE)
        return $post_id;

    $slug = "page";
    if($slug != $post->post_type)
        return $post_id;

    $mhp_meta_box_text_value = "";

    if(isset($_POST["mini-homepage-tag"]))
    {
        $mhp_meta_box_text_value = $_POST["mini-homepage-tag"];
    }       update_post_meta($post_id, "mini-homepage-tag", $mhp_meta_box_text_value);
    
}
add_action("save_post", "save_mini_homepage_custom_meta_box", 10, 3);



/* More mini hompage custom meta boxes //////// */

function mhp_custom_meta_box_02_markup($object)
{
    wp_nonce_field(basename(__FILE__), "meta-box02-nonce");

    ?>
<div>
        
 <div style="border: 1px #CCC solid; margin: 0 0 14px 0; padding: 8px; background: #EEE;">
   <h3>Mini-homepage header image </h3>      
  <?php $mhp_header_bg = get_post_meta( $post->ID ); ?>
	<img style="max-width:200px;height:auto;" id="mhp-header-bg-preview" src="<?php echo get_post_meta($object->ID, "mhp-header-bg", true); ?>" /><br />
        <input size="80" style="max-width: 100%;" type="text" name="mhp-header-bg" id="mhp-header-bg" class="meta_image" value="<?php echo get_post_meta($object->ID, "mhp-header-bg", true); ?>" /><br />
        <input type="button" id="mhp-header-bg-button" class="button" value="Choose or Upload an Image" />
    </p>
<script>
jQuery('#mhp-header-bg-button').click(function() {
 	var send_attachment_mhphbg = wp.media.editor.send.attachment;
 	wp.media.editor.send.attachment = function(props, attachment) {
	        jQuery('#mhp-header-bg').val(attachment.url);
	jQuery('#mhp-header-bg-preview').attr('src',attachment.url);
        wp.media.editor.send.attachment = send_attachment_mhphbg;
    }
 	wp.media.editor.open();
 	return false;
});
</script>
 </div>


  <div style="border: 1px #CCC solid; margin: 0 0 14px 0; padding: 8px; background: #EEE;">
    <h3>Mini-homepage logo image </h3>      
  <?php $mhp_logo_bg = get_post_meta( $post->ID ); ?>
	<img style="max-width:200px;height:auto;" id="mhp-logo-preview" src="<?php echo get_post_meta($object->ID, "mhp-logo", true); ?>" /><br />
        <input size="80" style="max-width: 100%;" type="text" name="mhp-logo" id="mhp-logo" class="meta_image" value="<?php echo get_post_meta($object->ID, "mhp-logo", true); ?>" /><br />
        <input type="button" id="mhp-logo-button" class="button" value="Choose or Upload an Image" />
    </p>
<script>
jQuery('#mhp-logo-button').click(function() {
 	var send_attachment_mhplogo = wp.media.editor.send.attachment;
 	wp.media.editor.send.attachment = function(props, attachment) {
	        jQuery('#mhp-logo').val(attachment.url);
	jQuery('#mhp-logo-preview').attr('src',attachment.url);
        wp.media.editor.send.attachment = send_attachment_mhplogo;
    }
 	wp.media.editor.open();
 	return false;
});
</script>
  </div>


   <div style="border: 1px #CCC solid; margin: 0 0 14px 0; padding: 8px; background: #EEE;">
  <h3>Mini Homepage Intro Text</h3>
            <textarea  style="max-width: 100%;" name="mhp-meta-box-intro-text" id="mhp-meta-box-intro-text" cols="80" rows="4"><?php echo get_post_meta($object->ID, "mhp-meta-box-intro-text", true); ?></textarea>
        </div>
        
  <div style="border: 1px #CCC solid; margin: 0 0 14px 0; padding: 8px; background: #EEE;">
   <h3>Mini Homepage Optional Slider</h3>
			<?php wp_editor( htmlspecialchars_decode( get_post_meta($object->ID, 'mhp-meta-box-slider' , true ) ), 'mhp-meta-box-slider', $settings = array('textarea_name'=>'mhp-meta-box-slider', 'textarea_rows'=> 10,'media_buttons'=>false,'tinymce'=>true ) ); ?>
  </div>
		
  <div style="border: 1px #CCC solid; margin: 0 0 14px 0; padding: 8px; background: #EEE;">
   <h3>Mini Homepage Projects</h3>
<?php wp_editor( htmlspecialchars_decode( get_post_meta($object->ID, 'mhp-meta-box-projects' , true ) ), 'mhp-meta-box-projects', $settings = array('textarea_name'=>'mhp-meta-box-projects', 'textarea_rows'=> 10,'media_buttons'=>true	,'tinymce'=>true ) ); ?>
 </div>
</div>
 <?php  
}


function add_mhp_custom_meta_box_02() {
	global $post;
 	$template_file = get_post_meta( $post->ID, '_wp_page_template', TRUE );
 	if ( $template_file == 'mini-homepage-page.php' ) {
		add_meta_box("mhp-custom-meta_box-02", "Mini-homepage content", "mhp_custom_meta_box_02_markup", "page","normal","high", null);
	}
}
add_action("add_meta_boxes", "add_mhp_custom_meta_box_02");


function save_mhp_custom_meta_box_02($post_id, $post, $update) {
    if (!isset($_POST["meta-box02-nonce"]) || !wp_verify_nonce($_POST["meta-box02-nonce"], basename(__FILE__)))
        return $post_id;

    if(!current_user_can("edit_post", $post_id))
        return $post_id;

    if(defined("DOING_AUTOSAVE") && DOING_AUTOSAVE)
        return $post_id;

    $slug = "page";
    if($slug != $post->post_type)
        return $post_id;
        
	$mhp_meta_box_bg_value = "";
	$mhp_meta_box_logo_value = "";
    $mhp_meta_box_intro_text_value = "";
    $mhp_meta_box_slider_value = "";
    $mhp_meta_box_projects_value = "";

	if(isset($_POST["mhp-header-bg"]))
    {
        $mhp_meta_box_bg_value = $_POST["mhp-header-bg"];
    }       update_post_meta($post_id, "mhp-header-bg", $mhp_meta_box_bg_value);
    
    
	if(isset($_POST["mhp-logo"]))
    {
        $mhp_meta_box_logo_value = $_POST["mhp-logo"];
    }       update_post_meta($post_id, "mhp-logo", $mhp_meta_box_logo_value);

    
    if(isset($_POST["mhp-meta-box-intro-text"]))
    {
        $mhp_meta_box_intro_text_value = $_POST["mhp-meta-box-intro-text"];
    }       update_post_meta($post_id, "mhp-meta-box-intro-text", $mhp_meta_box_intro_text_value);
    
    
        if(isset($_POST["mhp-meta-box-slider"]))
    {
        $mhp_meta_box_slider_value = $_POST["mhp-meta-box-slider"];
    }       update_post_meta($post_id, "mhp-meta-box-slider", $mhp_meta_box_slider_value);



    if(isset($_POST["mhp-meta-box-projects"]))
    {
        $mhp_meta_box_projects_value = $_POST["mhp-meta-box-projects"];
    }       update_post_meta($post_id, "mhp-meta-box-projects", $mhp_meta_box_projects_value);
    
}
add_action("save_post", "save_mhp_custom_meta_box_02", 10, 3);




/* add post_thumb to peoplepower profile posts */

 add_filter( 'the_content', 'featured_image_before_content' ); 
 
 function featured_image_before_content( $content ) { 
    if ( is_singular('peoplepower') && has_post_thumbnail()) {
        $thumbnail = get_the_post_thumbnail();

        $content = '<div class="ppthumb">'.$thumbnail.'</div>' . $content;
		
		}

    return $content;
}
 

// disable gutenberg for posts RM 1-11-19
add_filter('use_block_editor_for_post', '__return_false', 10);



// Google Analytics code 4-2-2020   - RM 

add_action('wp_head', 'ms_add_googleanalytics');
function ms_add_googleanalytics() { ?>
 
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-11707094-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-11707094-1');
</script>
 
<?php } ?>

<?php
/* Block xmlrps.php (external app acess RM 12-2-20 */
add_filter('xmlrpc_enabled', '__return_false');
 

/* Add administration email address(es) for recovery mode RM 1-30-21 */


add_filter('recovery_mode_email', function($email, $url) {
  $email_array = [];
  $email_array[] = $email['to'];

  // Adds another email
  $email_array[] = 'mm@melissamykal.com';

  $email['to'] = $email_array;

  return $email;
}, 10, 2);


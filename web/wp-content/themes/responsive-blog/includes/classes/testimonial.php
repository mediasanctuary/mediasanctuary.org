<?php

		//Define Custom post type
		function cyberchimps_init_testimonial_post_type() {

			register_post_type( 'testimonial_posts',
			                    array(
				                    'labels'      => array(
					                    'name'               => __( 'Testimonial', 'cyberchimps_elements' ),
					                    'singular_name'      => __( 'Testimonial item', 'cyberchimps_elements' ),
					                    'add_new_item'       => __( 'Add new Testimonial item', 'cyberchimps_elements' ),
					                    'edit_item'          => __( 'Edit Testimonial item', 'cyberchimps_elements' ),
					                    'new_item'           => __( 'New Testimonial item', 'cyberchimps_elements' ),
					                    'view_item'          => __( 'View Testimonial item', 'cyberchimps_elements' ),
					                    'search_items'       => __( 'Search Testimonial items', 'cyberchimps_elements' ),
					                    'not_found'          => __( 'No Testimonial items found', 'cyberchimps_elements' ),
					                    'not_found_in_trash' => __( 'No Testimonial items found in trash', 'cyberchimps_elements' )
				                    ),
				                    'public'      => true,
				                    'show_ui'     => true,
				                    'supports'    => array( 'custom-fields', 'title', 'thumbnail' ),
				                    'taxonomies'  => array( 'testimonial_categories' ),
				                    'has_archive' => false,
				                    //'menu_icon'   => get_template_directory_uri() . '/cyberchimps/lib/images/custom-types/carousel.png',
				                    'rewrite'     => false
			                    )
			);

			$labels = array(
				'name'              => _x( 'Testimonial Categories', 'taxonomy general name', 'cyberchimps_elements' ),
				'singular_name'     => _x( 'Testimonial Category', 'taxonomy singular name', 'cyberchimps_elements' ),
				'search_items'      => __( 'Search Testimonial', 'cyberchimps_elements' ),
				'all_items'         => __( 'All Testimonial', 'cyberchimps_elements' ),
				'parent_item'       => __( 'Testimonial Category', 'cyberchimps_elements' ),
				'parent_item_colon' => __( 'Testimonial Category:', 'cyberchimps_elements' ),
				'edit_item'         => __( 'Edit Testimonial Category', 'cyberchimps_elements' ),
				'update_item'       => __( 'Update Testimonial Category', 'cyberchimps_elements' ),
				'add_new_item'      => __( 'Add New Testimonial Category', 'cyberchimps_elements' ),
				'new_item_name'     => __( 'New Testimonial Category Name', 'cyberchimps_elements' ),
				'menu_name'         => __( 'Testimonial Category', 'cyberchimps_elements' )
			);

			register_taxonomy( 'testimonial_categories', array( 'testimonial_posts' ), array(
				'public'            => true,
				'show_in_nav_menus' => false,
				'hierarchical'      => true,
				'labels'            => $labels,
				'show_ui'           => true
			) );


			}
add_action( 'init', 'cyberchimps_init_testimonial_post_type' );



/*add meta box for testimonial start*/
function add_testimonial_section()
{
	global $post;
	
		add_meta_box(
			'resp_blog_testimonial',
			__( 'Testimonial Details', 'responsive-blog' ),
			'testimonial_meta_box',
			'testimonial_posts','normal', 'high'
		);

		function testimonial_meta_box( $post ) 
		{

			$testimonialData= get_post_meta( $post->ID, 'data', true );
			echo '<div>';
			wp_nonce_field( plugin_basename(__FILE__), 'responsive_blog_edit_testimonial_nonce' );

			$testimonial_title = $testimonialData['testimonial_title'] ? $testimonialData['testimonial_title'] : '';

			$testimonial_author = $testimonialData['testimonial_author'] ? $testimonialData['testimonial_author'] : '';	
			$testimonial_about_author = $testimonialData['testimonial_about_author'] ? $testimonialData['testimonial_about_author'] : '';	
			?>
			<style>
			.testimonial_input {
			    width: 100%;
		 	    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.07) inset;
			    border: 1px solid #ddd;
			}
			</style>
			<div>
				<label for="testimonial_title">Text for the Testimonial</label>
				<input class="testimonial_input" type="text" name="testimonial_title" id="testimonial_title" value="<?php echo $testimonial_title; ?>"/>
				<p>Note : Enter testimonial text here</p>
			</div>
			<div>
				<label for="testimonial_author">Testimonial Author</label>
				<input class="testimonial_input" type="text" name="testimonial_author" id="testimonial_author" value="<?php echo $testimonial_author; ?>"/>
				<p>Note : Enter testimonial author's name</p>
			</div>
			<div>
				<label for="testimonial_about_author">About the Author</label>
				<input class="testimonial_input" type="text" name="testimonial_about_author" id="testimonial_about_author" value="<?php echo $testimonial_about_author; ?>"/>
				<p>Note : Enter details about the author</p>
			</div>
			<?php
	
			echo '</div>';
		}
	
}
add_action( 'add_meta_boxes', 'add_testimonial_section' );
		
function save_testimonial_details($post_id) {
	
	if(!empty($_POST) && array_key_exists('testimonial_title', $_POST) && array_key_exists('testimonial_author', $_POST) && array_key_exists('testimonial_about_author', $_POST)){
	$data = Array(
	    'testimonial_title' => $_POST['testimonial_title'],
	    'testimonial_author' => $_POST['testimonial_author'],
		'testimonial_about_author' => $_POST['testimonial_about_author']
	    );
	update_post_meta($post_id, 'data', $data);
	}
}
add_action( 'save_post', 'save_testimonial_details' );
/*add meta box for testimonial end*/

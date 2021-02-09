<?php 

add_action( 'widgets_init', 'social_media_widget' );

function social_media_widget() {
	register_widget( 'responsive_blog_social_media_widget' );
	register_widget( 'responsive_blog_Recent_Post_Widget' );
	register_widget( 'responsive_blog_Single_Post_Widget' );
}


if (class_exists('WP_Widget'))
{

	//Social Media Widget
	class responsive_blog_social_media_widget extends WP_Widget {


		 // Register widget with WordPress.
		function __construct() {
			parent::__construct(
				'responsive_blog_social_media_widget', // Base ID
				__( 'Social Media', 'responsive-blog' ), // Name
				array( 'description' => __( 'Social Media Widget', 'responsive-blog' ), ) // Args
			);
		}

		
		// Front-end display of widget.
		public function widget( $args, $instance ) {
		        global $post;
			foreach($args as $i=>$val)
			{
				if($i == 'before_widget')
				$before_widget = $val;
				if($i == 'after_widget')
				$after_widget = $val;
				if($i == 'before_title')
				$before_title = $val;
				if($i == 'after_title')
				$after_title = $val;
			}

			$title = apply_filters('cb_widget_title', $instance['title']);
			$facebook_link = apply_filters('cb_facebook_link', $instance['facebook_link']);
			$twitter_link = apply_filters('cb_twitter_link', $instance['twitter_link']);
			$linkedin_link = apply_filters('cb_linkedin_link', $instance['linkedin_link']);
			$googleplus_link = apply_filters('cb_googleplus_link', $instance['googleplus_link']);

			echo $before_widget;
			if (!empty($title))
			{
				echo $before_title . $title . $after_title; 
			} ?>
				<ul class="social_media_widget">
					<?php if(!empty($instance['facebook_link'])): ?>
						<li id="facebook_link">
							<a class="symbol_widget facebook_widget" href="<?php echo $facebook_link; ?>"><i class="fa fa-facebook"></i>Facebook</a>
						</li>
					<?php endif;
					      if(!empty($instance['twitter_link'])): ?>
						<li id="twitter_link"> 
							<a class="symbol_widget twitter_widget" href="<?php echo $twitter_link; ?>"><i class="fa fa-twitter"></i>Twitter</a>
						</li>
					<?php endif;
					      if(!empty($instance['linkedin_link'])): ?>
						<li id="linkedin_link"> 
							<a class="symbol_widget linkedin_widget" href="<?php echo $linkedin_link; ?>"><i class="fa fa-linkedin"></i>LinkedIn</a>
						</li>
					<?php endif;
					      if(!empty($instance['googleplus_link'])): ?>
						<li id="googleplus_link"> 
							<a class="symbol_widget googleplus_widget" href="<?php echo $googleplus_link; ?>"><i class="fa fa-google-plus"></i>Google Plus</a>
						</li>
					<?php endif; ?>
				</ul>
		<?php echo $after_widget; ?>

		
	<?php	}

		// Back-end widget form.
		public function form( $instance ) {
			$title= ! empty( $instance['title'] ) ? $instance['title'] : '';
			$facebook_link= ! empty( $instance['facebook_link'] ) ? $instance['facebook_link'] : '';
			$twitter_link= ! empty( $instance['twitter_link'] ) ? $instance['twitter_link'] : '';
			$linkedin_link= ! empty( $instance['linkedin_link'] ) ? $instance['linkedin_link'] : '';
			$googleplus_link= ! empty( $instance['googleplus_link'] ) ? $instance['googleplus_link'] : '';		
 ?>
			<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'responsive-blog' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
			</p>
			<p>
			<label for="<?php echo $this->get_field_id( 'facebook_link' ); ?>"><?php _e( 'Facebook Link:', 'responsive-blog' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'facebook_link' ); ?>" name="<?php echo $this->get_field_name( 'facebook_link' ); ?>" type="text" value="<?php echo esc_attr( $facebook_link ); ?>">
			</p>
			<p>
			<label for="<?php echo $this->get_field_id( 'twitter_link' ); ?>"><?php _e( 'Twitter Link:', 'responsive-blog' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'twitter_link' ); ?>" name="<?php echo $this->get_field_name( 'twitter_link' ); ?>" type="text" value="<?php echo esc_attr( $twitter_link ); ?>">
			</p>
			<p>
			<label for="<?php echo $this->get_field_id( 'linkedin_link' ); ?>"><?php _e( 'Linkedin Link:', 'responsive-blog' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'linkedin_link' ); ?>" name="<?php echo $this->get_field_name( 'linkedin_link' ); ?>" type="text" value="<?php echo esc_attr( $linkedin_link ); ?>">
			</p>
			<p>
			<label for="<?php echo $this->get_field_id( 'googleplus_link' ); ?>"><?php _e( 'Googleplus Link:', 'responsive-blog' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'googleplus_link' ); ?>" name="<?php echo $this->get_field_name( 'googleplus_link' ); ?>" type="text" value="<?php echo esc_attr( $googleplus_link ); ?>">
			</p>
<?php }

		
		// Sanitize widget form values as they are saved.
		public function update( $new_instance, $old_instance ) {
			$instance = array();
			$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
			$instance['facebook_link'] = ( ! empty( $new_instance['facebook_link'] ) ) ? strip_tags( $new_instance['facebook_link'] ) : '';
			$instance['twitter_link'] = ( ! empty( $new_instance['twitter_link'] ) ) ? strip_tags( $new_instance['twitter_link'] ) : '';
			$instance['linkedin_link'] = ( ! empty( $new_instance['linkedin_link'] ) ) ? strip_tags( $new_instance['linkedin_link'] ) : '';
			$instance['googleplus_link'] = ( ! empty( $new_instance['googleplus_link'] ) ) ? strip_tags( $new_instance['googleplus_link'] ) : '';

			return $instance;
		}

	} // end of Social media widget

/*===============================================================================================================================================*/

// Recent Post widget

class responsive_blog_Recent_Post_Widget extends WP_Widget {
	

	 // Register widget with WordPress.
		function __construct() {
			parent::__construct(
				'responsive_blog_Recent_Post_Widget', // Base ID
				__( 'Recent Posts', 'responsive-blog' ), // Name
				array( 'description' => __( 'Recent Post widget customized for Responsive Blog theme', 'responsive-blog' ), ) // Args
			);
		}

	function widget($args, $instance) {
		$cache = wp_cache_get('widget_recent_posts', 'widget');

		if ( !is_array($cache) )
			$cache = array();

		if ( ! isset( $args['widget_id'] ) )
			$args['widget_id'] = $this->id;

		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo $cache[ $args['widget_id'] ];
			return;
		}

		ob_start();
		extract($args);

		$title = apply_filters('widget_title', empty($instance['title']) ? __('Recent Posts', 'responsive-blog') : $instance['title'], $instance, $this->id_base);
		if ( empty( $instance['number'] ) || ! $number = absint( $instance['number'] ) )
 			$number = 10;

		$r = new WP_Query( apply_filters( 'widget_posts_args', array( 'posts_per_page' => $number, 'no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true ) ) );
		if ($r->have_posts()) :
?>
		<?php echo $before_widget; ?>
		<?php if ( $title ) echo $before_title . $title . $after_title;
		
?>

		<div class="responsive_blog_recent_post_widget">
			<?php while ( $r->have_posts() ) : $r->the_post(); ?>
				<div class="row responsive_blog_recent_post_widget_row">
					<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
						<div class="single_product_image_widget"><?php the_post_thumbnail(array(50, 50)); ?></div>
					</div>
					<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9 recent_post_widget_right">
						<a class="recent_post_title" href="<?php the_permalink() ?>" title="<?php echo esc_attr( get_the_title() ? get_the_title() : get_the_ID() ); ?>"><?php if ( get_the_title() ) the_title(); else the_ID(); ?></a>
						<div class="recent_post_widget_date"> <?php echo human_time_diff( get_the_time('U'), current_time('timestamp') ) . ' ago'; ?> </div>
					</div>
				</div>
			<?php endwhile; ?>
		</div>
		<?php echo $after_widget; ?>
<?php
		// Reset the global $the_post as this query will have stomped on it
		wp_reset_postdata();

		endif;

		$cache[$args['widget_id']] = ob_get_flush();
		wp_cache_set('widget_recent_posts', $cache, 'widget');
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = (int) $new_instance['number'];
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['widget_recent_entries']) )
			delete_option('widget_recent_entries');

		return $instance;
	}

	function flush_widget_cache() {
		wp_cache_delete('widget_recent_posts', 'widget');
	}

	function form( $instance ) {
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'responsive-blog' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:', 'responsive-blog' ); ?></label>
		<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>
<?php
	}
}

/*===================================================================================================*/
//Single featured post Widget
	class responsive_blog_Single_Post_Widget extends WP_Widget {

		// Register widget with WordPress.
		function __construct() {
			parent::__construct(
				'responsive_blog_Single_Post_Widget', // Base ID
				__( 'Single Featured post', 'responsive-blog' ), // Name
				array( 'description' => __( 'Single Featured post', 'responsive-blog' ), ) // Args
			);
		}

		// Front-end display of widget.
		public function widget( $args, $instance ) {

	        global $post, $post_thumbnail_id, $postid, $image, $content;

			foreach($args as $i=>$val)
			{
				if($i == 'before_widget')
				$before_widget = $val;
				if($i == 'after_widget')
				$after_widget = $val;
				if($i == 'before_title')
				$before_title = $val;
				if($i == 'after_title')
				$after_title = $val;
			}
			$title = apply_filters('post_widget_title', $instance['title']);
			$post_ID = ! empty( $instance['post_ID'] ) ? absint($instance['post_ID']) : '';
			$post_details = get_post($post_ID);
			$post_title = $post_details->post_title;
			$post_excerpt = wp_trim_words($post_details->post_content, 40, '');
			$author_id=$post_details->post_author;
			$author_name = get_userdata($author_id)->display_name; 
		
			echo $before_widget; 
			if ( $title ) echo $before_title . $title . $after_title; ?>
			<div class="single_product_details row" >
				
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					
					<div class="row"><?php echo '<div class="product_content col-xs-12 col-sm-12 col-lg-12">'.$post_excerpt;
						echo "</div>"; ?>
					</div>
					<div class="row"><?php echo '<div class="read_more col-xs-12 col-sm-12 col-lg-12"><a href="'.get_permalink( $post_ID).'"> Read More </a>';
						echo "</div>";	?>
					</div>
				</div>
			</div><?php echo $after_widget;
			
		}

		// Back-end widget form.
		public function form( $instance ) {
			$title= ! empty( $instance['title'] ) ? $instance['title'] : '';
			$post_title= ! empty( $instance['post_ID'] ) ? $instance['post_ID'] : ''; ?>

			<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'responsive-blog' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>
			<p>
			<label for="<?php echo $this->get_field_id( 'post_title' ); ?>"><?php _e( 'Choose Featured Post', 'responsive-blog' ); ?> </label><?php $args = array(
			'post_status' => 'publish',
			'posts_per_page'   => 60,
			);
			$query = new WP_Query( $args ); 
				if ( $query->have_posts() ){  ?>
				  <select class="widefat" id="<?php echo $this->get_field_id('post_ID'); ?>" name="<?php echo $this->get_field_name('post_ID'); ?>" type="text"><?php while ( $query->have_posts() ){
						$query->the_post();
						$postid = get_the_ID();
						$post_title = get_the_title($postid);
						$query_post_instance = ! empty( $instance['post_ID'] ) ? absint($instance['post_ID']) : '';
						echo '<option '.selected( $query_post_instance, $postid ).'value="'.$postid.'" ';
            					echo '>'.$post_title .'</option>';
					
				  	}
				  echo '</select>';
				
				} ?>
			</p><?php }

		
		// Sanitize widget form values as they are saved.
		public function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
			$instance['post_ID'] = ( ! empty( $new_instance['post_ID'] ) ) ? strip_tags( absint($new_instance['post_ID'] )) : '';
			return $instance;
		}

	} // end of Single Featured Post

}

<?php
/*
*
* Template Functions File
*
*/

/*======================== Slider ======================================*/
add_action('responsive_blog_page_slider', 'responsive_blog_page_slider_func');

// Slider template function
function responsive_blog_page_slider_func()
{?>
<?php 
		$responsive_options = responsive_get_options();
		$slider_post_category = $responsive_options['responsive_blog_post_categories'];
		$slider_sliding_effect = $responsive_options['responsive_blog_slider_effect'];

		$slider_args = array(
				'numberposts'      => -1,
				'offset'           => 0,
				'category_name'         => $slider_post_category,
				'orderby'          => 'post_date',
				'order'            => 'ASC',
				'post_type'        => 'post',
				'post_status'      => 'publish',
				'suppress_filters' => false
			);
		$slider_posts = get_posts($slider_args); ?>

		<?php $flag = 0; //to check if posts have images ?>
		<div id="responsive_blog_slider" class="carousel slide carousel-fade" data-ride="carousel">

			<div class="carousel-inner" role="listbox">
				<?php
					//if( !empty( $slider_posts ) )
						//	Setting slide counter
						$slide_counter = 1;

						// Setting the loop to get all slides
						foreach( $slider_posts as $slide ) {

							// Getting ID of the current post
							$post_id = $slide->ID;

							// Getting individual options of each post
							
							$img_src = wp_get_attachment_url( get_post_thumbnail_id( $post_id ) );
							$title          = get_the_title( $post_id );
							$title_trim = wp_trim_words($title, 5, '...');
							$post_content = $slide->post_content;
							$post_excerpt = wp_trim_words($post_content, 10, '...');
							$post_link = get_permalink($post_id); 
							//$postcat = get_the_category( $post_id );
							$homeslidepretitle = get_post_meta($post_id, 'homeslide-pretitle-text', true);
							$homeslidelink = get_post_meta($post_id, 'homeslide-link-text', true);
							?>

							<?php	if( ! empty( $img_src ) ) 
									{ ?>
<?php $flag = 1; ?>
										<div class="item <?php echo ( $slide_counter == 1 ) ? "active" : ""; ?>" style="width:100%;">
											<!-- a href="<?php echo esc_url( $post_link ); ?>" ' -->
<div class="responsive_slider_img" style="background-image:url('<?php echo $img_src; ?>'); background-size:cover;"> </div>
											<!-- /a -->
											<div class="container animated fadeIn caption_div">
												<div class="row">
													<div class="caption">
													<?php if ($homeslidepretitle) { ?>
				<div class"homeslidepretitle"><?php echo $homeslidepretitle ?></div>		
			<?php }	?>
														<h3><a href="<?php echo $homeslidelink ?>"><?php echo $title_trim; ?></a></h3>
														<div class="slide_post_excerpt">
														<?php  echo $post_excerpt; 
											  
			if ($homeslidelink) { ?>
				<div class="slide_read_more"><a href="<?php echo $homeslidelink ?>">Read More</a></div>
			<?php }	?>  
														  
														 </div>
													</div>
												</div>
											</div>
										</div>
									<?php $slide_counter++; ?>
							<?php } ?>
				
					<?php	
 					} ?>
				</div> <!--end of carousel-inner-->
				<div class="container arrows">
					<div class="arrow_left_div">
						<a class="arrow_left" href="#responsive_blog_slider" data-slide="prev">
							<span class="glyphicon glyphicon-menu-left"></span>
						</a>
					</div>
					<div class="arrow_right_div">
						<a class="arrow_right" href="#responsive_blog_slider" data-slide="next">
							<span class="glyphicon glyphicon-menu-right"></span>
						</a>
					</div>
				</div>
			</div>
	<?php if($flag==0)
			{ ?>
				<style type="text/css">
					.home.front-page #header
					{
						position:relative;
					}
				</style>		
	<?php	}
	?>
		
			<?php if($slider_sliding_effect == 1)
					{ ?>
						<script type="text/javascript">
							jQuery(document).ready(function () {

							// Prevent auto slide for slider
							jQuery("#responsive_blog_slider").carousel({interval: false});

							});
						</script>
			<?php	}?>
<?php wp_reset_postdata(); ?>
		
<?php }

/* ====================== Featured Category =============================== */
add_action('responsive_blog_section_features', 'responsive_blog_section_features_func');

function responsive_blog_section_features_func()
{
		$responsive_options = responsive_get_options();
		$features_post_category = 'news' /*$responsive_options['responsive_blog_feature_post_categories']*/;

		$features_args = array(
				'numberposts'      => 6,
				'offset'           => 0,
				'category_name'         => $features_post_category,
				'orderby'          => 'post_date',
				'order'            => 'DESC',
				'post_type'        => 'post',
				'post_status'      => 'publish',
				'suppress_filters' => false
			);
		$features_posts = get_posts($features_args); ?>
			
		<?php foreach($features_posts as $feature)
				{ 
					//$post_id = $feature->ID;
					$feature_img = wp_get_attachment_url( get_post_thumbnail_id( $feature->ID ) );
					$feature_title = get_the_title( $feature->ID );
					//$feature_desc = wp_trim_words( $feature->post_content, 10, '');
					$feature_link = get_permalink( $feature->ID );
					$post_date = get_the_date( 'n.j.Y', $feature->ID );
					?>
					<div class="feature-single-section">
						<div class="row">
							<?php if(!empty($feature_img))
								{ ?>
							<div class="feature_img_div">
								<a href="<?php echo esc_url( $feature_link ); ?>"><img src="<?php echo $feature_img; ?>" /></a>
							</div>
							<?php } else { ?>
							<div class="feature_img_div">
								<a href="<?php echo esc_url( $feature_link ); ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/logo_ms_240x160.png" /></a></div>
							<?php } ?>
							
							<div class="feature_title_div">
								<div class="feature-single-date"><?php echo $post_date; ?></div>
								<div class="feature-single-title-wrapper"><a href="<?php echo esc_url( $feature_link ); ?>"><span class="feature-single-title"><?php echo $feature_title; ?></span></a></div>
									<div class="feature-single-read-more"><a href="<?php echo esc_url( $feature_link ); ?>"><img class="read-more-arrow" src="<?php echo get_stylesheet_directory_uri(); ?>/images/readmore.png" /></a></div>
							</div>
						</div>
				
					</div>
			<?php } ?>
<?php wp_reset_postdata(); ?>
<div class="featured-more-link"><a href="<?php echo $features_post_category ?>">See The Archives</a></div>
<?php
}



/*================================ Testimonial ===========================*/
add_action('responsive_blog_section_testimonial', 'responsive_blog_section_testimonial_func');

function responsive_blog_section_testimonial_func()
{
	$responsive_options = responsive_get_options();
	$testimonial_post_category = $responsive_options['responsive_blog_testimonial_post_categories'];

	$testimonial_args = array(
			'numberposts'      => 4,
			'offset'           => 0,
			'testimonial_categories'         => $testimonial_post_category,
			'orderby'          => 'post_date',
			'order'            => 'ASC',
			'post_type'        => 'testimonial_posts',
			'post_status'      => 'publish',
			'suppress_filters' => false
		);
	$testimonial_posts = get_posts($testimonial_args); ?>
	<?php $testimonial_counter = 0; ?>
	<div class="row">

	<?php foreach($testimonial_posts as $testimonial)
				{ 
					$testimonialData = get_post_meta( $testimonial->ID, 'data', true ); 

					if (has_post_thumbnail( $testimonial->ID ) )
					{
						$testimonial_img = wp_get_attachment_image_src( get_post_thumbnail_id( $testimonial->ID ));
					}
					if(isset($testimonialData['testimonial_title']))
					{
						$testimonial_title = $testimonialData['testimonial_title'];
					}
					if(isset($testimonialData['testimonial_author']))
					{
						$testimonial_author = $testimonialData['testimonial_author'];
					}
					if(isset($testimonialData['testimonial_about_author']))
					{
						$testimonial_about_author = $testimonialData['testimonial_about_author'];
					}
					$testimonial_main_post_title = get_the_title( $testimonial->ID );
					
					if($testimonial_counter == 2)
					{ ?>
						</div>
						<div class="row">
		<?php		} ?>
							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 testimonial_main <?php echo 'testimonial_no_'.$testimonial_counter; ?>">
								<div class="row">
									<?php if (has_post_thumbnail( $testimonial->ID ) )
										{ ?>
											<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 testimonial_img_div">
													<img alt="<?php echo $testimonial_main_post_title; ?>" src="<?php echo $testimonial_img[0]; ?>" class="responsive_testimonial_img"/>
											</div>
									<?php   } ?>
									<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 testimonial_right_section">
										<div class="row">
											<?php if(isset($testimonialData['testimonial_title']))
												{ ?>
													<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 testimonial_text_div">
														<p class="testimonial_text"><?php echo $testimonial_title; ?></p>
													</div>
											<?php   } ?>
										</div>
										<div class="row">
											<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
												<?php if(isset($testimonialData['testimonial_author']))
														{ ?>
														<p class="testimonial_author"> - <?php echo $testimonial_author; ?></p>
												<?php  	} ?>
											</div>
										</div>
										<div class="row">
											<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
												<?php if(isset($testimonialData['testimonial_about_author']))
														{ ?>
														<p class="testimonial_about_author"><?php echo $testimonial_about_author; ?></p>
												<?php  	} ?>
											</div>
										</div>
									</div> <!-- end of testimonial title col-md-6 -->
								</div>		
							</div>
						
					
			<?php	$testimonial_counter++;
			} ?>
		</div>
<?php wp_reset_postdata(); ?>
<?php
}

/*================================ Recent Post ===========================*/
add_action('responsive_blog_section_recent_post', 'responsive_blog_section_recent_post_func');

function responsive_blog_section_recent_post_func()
{
		$responsive_options = responsive_get_options();
		$recent_post_category = $responsive_options['responsive_blog_recent_post_categories'];

		$recent_post_args = array(
				'numberposts'      => 4,
				'offset'           => 0,
				'category_name'         => $recent_post_category,
				'orderby'          => 'post_date',
				'order'            => 'ASC',
				'post_type'        => 'post',
				'post_status'      => 'publish',
				'suppress_filters' => false
			);
		$recent_posts = get_posts($recent_post_args); 

		$recent_post_counter = 0;
		?>
		<div class="row">
<?php
		foreach($recent_posts as $recent_post)
		{ 
			
			$recent_post_img = wp_get_attachment_url( get_post_thumbnail_id( $recent_post->ID ) );
			$recent_post_title = get_the_title( $recent_post->ID );
			$recent_post_link = get_permalink( $recent_post->ID );
			$recent_post_excerpt = wp_trim_words( $recent_post->post_content, 20, '');
			$recent_post_date = get_the_date( 'F - j - Y', $recent_post->ID );

			if($recent_post_counter == 2)
			{ ?>
				</div>
				<div class="row">
<?php		}			
?>
				<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 recent_post_main">
					<div class="row">
						<?php if(!empty($recent_post_img))
						{ ?>
							<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 recent_post_left_section">
								<div class="responsive_recent_post_img" style="background:transparent url('<?php echo $recent_post_img; ?>') repeat scroll 0% 0%  / cover; "></div>
							</div>
						<?php } ?>
						<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 recent_post_right_section">
							<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
									<a href="<?php echo esc_url( $recent_post_link ); ?>">
										<p class="recent_title"><?php echo $recent_post_title; ?></p>
									</a>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
									<p class="recent_excerpt"><?php echo $recent_post_excerpt; ?></p>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
									<span class="glyphicon glyphicon-calendar"></span>
									<span class="recent_date"><?php echo $recent_post_date; ?></span>
								</div>
							</div>
						</div>
					</div>				
				</div>	

		<?php	$recent_post_counter++;
		} ?>
		</div>
<?php wp_reset_postdata(); ?>
<?php
}

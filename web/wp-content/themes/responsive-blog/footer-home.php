<?php

/**
 * Footer Template
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}



/*
 * Globalize Theme options
 */
global $responsive_options;
$responsive_options = responsive_get_options();
?>
<?php responsive_wrapper_bottom(); // after wrapper content hook ?>

<?php // Closing container class for all pages except custom front page 
		if ( is_front_page())
		{ 
			$rb_body_class= get_body_class();
			if(in_array('front-page', $rb_body_class))
			{ ?>
				</div><!-- end of responsive_wrapper -->
	<?php	} else { ?>
					</div><!-- end of container -->
				</div><!-- end of responsive_wrapper -->
	<?php	}		
		?>
<?php	}
		else
		{ ?>
				</div><!-- end of container -->
			</div><!-- end of responsive_wrapper -->
<?php	} ?>
<?php responsive_wrapper_end(); // after wrapper hook ?>
</div><!-- end of #container -->
<?php responsive_container_end(); // after container hook ?>


	<div class="responsive_blog_colophon">
		<div class="container">
			<div class="row">
				<?php get_sidebar( 'colophon' ); ?>
			</div>
		</div>
	</div></div>
<div id="responsive_blog_footer" class="clearfix" role="contentinfo">
	<?php responsive_footer_top(); ?>

	<div id="responsive_blog_footer-wrapper" class="container">
	
		<?php get_sidebar( 'footer' ); ?>

	</div><!-- end #footer-wrapper -->

	<div class="responsive_blog_footer_menu_icons">
		<div class="container">
			<div class="row">

				
				<!--<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 responsive_blog_footer_extra_menu">
					<?php if ( has_nav_menu( 'footer-menu', 'responsive' ) ) {
						wp_nav_menu( array(
							'container'      => '',
							'fallback_cb'    => false,
							'menu_class'     => 'footer-menu',
							'theme_location' => 'footer-menu'
						) );
					 } ?>
				</div> end of col-540 -->

				<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 responsive_blog_copyright">
					<div class="copyright">
							<?php esc_attr_e( '&copy;', 'responsive-blog' ); ?> <?php echo date( 'Y' ); ?><a id="copyright_link" href="<?php echo esc_url( home_url( '/' ) ) ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
								<?php bloginfo( 'name' ); ?>
							</a><br />
3361 6th Avenue in North Troy, New York <br />
P.O. Box 35 Troy, NY 12181<br />
(518) 272-2390 
					</div><!-- end of .copyright -->
				</div>

				<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 responsive_blog_footer_extra_icons">
					<?php echo responsive_blog_get_social_icons() ?>
				</div><!-- end of col-380 fit -->

			</div> <!-- end of row -->
		</div><!-- end of container-->
	</div>
	
	<?php /* colophon was here - RM*/ ?>	
	
 

	<?php responsive_footer_bottom(); ?>
</div><!-- end #footer -->
<?php responsive_footer_after(); ?>
<div id="scroll-to-top"><span class="glyphicon glyphicon-chevron-up"></span></div>

<?php wp_footer(); ?>
</body>
</html>
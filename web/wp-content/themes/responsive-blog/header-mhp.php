<?php
/**
 * Header Template
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

?>
	<!doctype html>
	<!--[if !IE]>
	<html class="no-js non-ie" <?php language_attributes(); ?>> <![endif]-->
	<!--[if IE 7 ]>
	<html class="no-js ie7" <?php language_attributes(); ?>> <![endif]-->
	<!--[if IE 8 ]>
	<html class="no-js ie8" <?php language_attributes(); ?>> <![endif]-->
	<!--[if IE 9 ]>
	<html class="no-js ie9" <?php language_attributes(); ?>> <![endif]-->
	<!--[if gt IE 9]><!-->
<html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
	<head>

		<meta charset="<?php bloginfo( 'charset' ); ?>"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<link rel="profile" href="https://gmpg.org/xfn/11"/>
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>"/>
		<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/favicon.ico" />

		<?php wp_head(); ?>
	</head>

<body <?php body_class(); ?>>


<div id="responsive-blog-container" class="container-full">
	<div class="skip-container cf">
		<a class="skip-link screen-reader-text focusable" href="#responsive_wrapper"><?php _e( '&darr; Skip to Main Content', 'responsive-blog' ); ?></a>
	</div><!-- .skip-container -->
	
	
<!-- <div id="header_outer_wrap"> -->
	<div class="logo-wrapper">
		<div class="container">	
	<?php if ( get_header_image() != '' ) : ?>
					<div id="logo">
						<a href="<?php echo esc_url(home_url( '/' )); ?>"><img src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="<?php esc_attr(bloginfo( 'name' )); ?>"/></a>
					</div><!-- end of #logo -->
				<?php endif; // header image was removed ?>

				<?php if ( !get_header_image() ) : ?>
					<div id="logo">
						<h1 class="site-name"><a href="<?php echo esc_url(home_url( '/' )); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
						<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
					</div><!-- end of #logo -->
				<?php endif; // header image was removed (again) ?>
		<?php 
	$mhp_logo_img_file = get_post_meta($post->ID, 'mhp-logo', true);
		if(!empty($mhp_logo_img_file)) {
			$mhp_logo_img_file = '<img src="'.$mhp_logo_img_file.'" />';
			} else {
			$mhp_header_img_file = '';  
			}
	?>
			<div id="mhp_logo"><?php echo $mhp_logo_img_file;?></div>
			</div>
		</div>
	
	<div class="responsive_blog_top_menu">
		<div class="container">
			<?php if ( has_nav_menu( 'top-menu', 'responsive' ) ) {
						wp_nav_menu( array(
							'container'      => '',
							'fallback_cb'    => false,
							'menu_class'     => 'top-menu',
							'theme_location' => 'top-menu'
						) );
					} ?>
			</div>
		</div>
	<?php 
	$mhp_header_img_file = get_post_meta($post->ID, 'mhp-header-bg', true);
		if(!empty($mhp_header_img_file)) {
			$mhp_header_img_file_css = 'style="background: url('.$mhp_header_img_file.'); background-size: 100% 300px; min-height: 300px;"';
			} else {
			$mhp_header_img_file_css = 'style="background: url('.get_stylesheet_directory_uri().'/images/header_bg_mosaic.jpg)left top repeat-x; background-size: 1200px 110px;"';  
			}
	?>	
	<div id="header" role="banner" <?php echo $mhp_header_img_file_css; ?>">
		
		<div id ="header_container" class="container">
		
		<div class="row">
			<div class="col-xs-12 col-sm-3 col-md-3">
				
			</div>
			<!-- div class="col-xs-12 col-sm-9 col-md-9" id="responsive-blog-header-menu" -->
			<div id="responsive-blog-header-menu">
				<nav class="navbar navbar-default">
					<div class="navbar-header">
						<button aria-controls="navbar" aria-expanded="false" data-target="#navbar" data-toggle="collapse" class="navbar-toggle collapsed" type="button">
							<span class="glyphicon glyphicon-align-justify"></span>
						</button>
					</div>
					<div class="navbar-collapse collapse" id="navbar">
						<?php wp_nav_menu( array(
							'container'       => 'div',
							'container_class' => 'responsive-blog-nav',
							'fallback_cb'     => 'responsive_blog_fallback_menu',
							'theme_location'  => 'header-menu',
							'menu_class' => 'nav navbar-nav'
						) ); ?>
					</div>
				</nav>
			</div>
		</div> <!-- end of row -->
		
		<div class="row">
			<?php get_sidebar( 'top' ); ?>
		</div>
		
		</div>
	</div><!-- end of #header -->
  <!-- </div>end of #header_outer_wrap -->
<?php responsive_wrapper(); // before wrapper container hook ?>
	
	<?php // Adding container class for all pages except custom front page ?>
	<?php
	$responsive_options = responsive_get_options();

	// check the template of page and decide if container class is to be added
		if ( is_front_page())
		{ 
			$rb_body_class= get_body_class();
			if(in_array('front-page', $rb_body_class))
			{ ?>
				<div id="responsive_wrapper" class="clearfix">
	<?php	} else { ?>
				<div id="responsive_wrapper" class="clearfix">
					<div class="container">
	<?php	}		
		?>
<?php	}
		else
		{ ?>
			<div id="responsive_wrapper" class="clearfix">
				<div class="container">
<?php	} ?>

<?php responsive_wrapper_top(); // before wrapper content hook ?>
<?php responsive_in_wrapper(); // wrapper hook ?>

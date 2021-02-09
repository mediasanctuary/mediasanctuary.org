<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Main Widget Template
 *
 *
 * @file           sidebar.php
 * @package        Responsive
 * @author         Emil Uzelac
 * @copyright      2003 - 2014 CyberChimps
 * @license        license.txt
 * @version        Release: 1.0
 * @filesource     wp-content/themes/responsive/sidebar.php
 * @link           http://codex.wordpress.org/Theme_Development#Widgets_.28sidebar.php.29
 * @since          available since Release 1.0
 */

/*
 * Load the correct sidebar according to the page layout
 */
 
 
?>

<?php responsive_widgets_before(); // above widgets container hook ?>
	<div id="widgets" class="grid-right col-300 rtl-fit  mini-homepage-sidebar" role="complementary">
		<?php responsive_widgets(); // above widgets hook ?>

		<?php if ( !dynamic_sidebar( 'mini-homepage-sidebar' ) ) : ?>
			<div class="widget-wrapper">

				<div class="widget-title"><h3><?php _e( 'In Archive', 'responsive' ); ?></h3></div>
				<ul>
					<?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
				</ul>

			</div><!-- end of .widget-wrapper -->
		<?php endif; //end of main-sidebar ?>

		<?php responsive_widgets_end(); // after widgets hook ?>
		 
	</div><!-- end of #widgets -->
<?php responsive_widgets_after(); // after widgets container hook ?>


<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Frontpage middle sidebar Template
 *
 *
 * @file           sidebar-frontpage-middle.php
 * @package        Responsive
 * @author         Emil Uzelac
 * @copyright      2003 - 2014 CyberChimps
 * @license        license.txt
 * @version        Release: 1.0
 * @filesource     wp-content/themes/responsive-blog/sidebar-frontpage-middle.php
 * @link           http://codex.wordpress.org/Theme_Development#Widgets_.28sidebar.php.29
 * @since          available since Release 1.1
 */
?>
<?php
if ( !is_active_sidebar( 'responsive-blog-frontpage-middle' )
) {
	return;
}
?>
<?php responsive_widgets_before(); // above widgets container hook ?>
	<div id="frontpage-middle" class="grid col-940">
		<?php responsive_widgets(); // above widgets hook ?>

		<?php if ( is_active_sidebar( 'responsive-blog-frontpage-middle' ) ) : ?>

			<?php dynamic_sidebar( 'responsive-blog-frontpage-middle' ); ?>

		<?php endif; //end of responsive-blog-frontpage-middle ?>

		<?php responsive_widgets_end(); // after widgets hook ?>
	</div><!-- end of #colophon-widget -->
<?php responsive_widgets_after(); // after widgets container hook ?>
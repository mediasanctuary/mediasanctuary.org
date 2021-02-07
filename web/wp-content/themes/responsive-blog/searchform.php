<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Search Form Template
 *
 */
?>
<form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
	<span class="responsive_blog_search_form">
		<label class="screen-reader-text" for="s"><?php esc_attr_e( 'Search for:', 'responsive-blog' ) ?></label>
		<input type="search" class="field" name="s" id="s" placeholder="<?php esc_attr_e( 'Search Here', 'responsive-blog' ); ?>" />
		<label class="screen-reader-text" for="submit"><?php esc_attr_e( 'Submit', 'responsive-blog' ) ?></label>
		<input type="submit" class="submit responsive-blog-search" name="submit" id="searchsubmit" value="&#xf002;" />
	</span>
</form>

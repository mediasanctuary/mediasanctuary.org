/* global screenReaderText */
/**
 * File to enable keyboard navigation.
 *
 * Contains handlers for navigation and widget area.
 */

( function( $ ) {
	var body, masthead, siteNavigation;

	masthead         = $( '#responsive-blog-header-menu' );
	siteNavigation   = masthead.find( '#navbar' );
	
	( function() {

		siteNavigation.find( 'a' ).on( 'focus blur', function() {
			$( this ).parents( '.menu-item' ).toggleClass( 'focus' );
		} );
	} )();

	
} )( jQuery );

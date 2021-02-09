/*
* Custom jQuery file for adding scrolling effect
*/

jQuery(window).ready(function(){
	jQuery('#scroll-to-top').hide();
	jQuery(window).scroll(function(){
		if( jQuery(this).scrollTop() > 50 ){
			jQuery('#scroll-to-top').fadeIn();
		}
		else{
			jQuery('#scroll-to-top').fadeOut();
		}
	});
	jQuery('#scroll-to-top').click(function(){
		jQuery('body, html').animate({
			scrollTop: 0
	}, 700);
	})
});

(function($) {
	$('.top-nav .nav-link--menu').click(function(e) {
		e.preventDefault();
		$(document.body).addClass('show-mobile-menu');
	});
	$('.top-nav .close-menu').click(function(e) {
		$(document.body).removeClass('show-mobile-menu');
	});
})(jQuery);

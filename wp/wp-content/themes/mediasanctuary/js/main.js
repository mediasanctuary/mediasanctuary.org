(function($) {
	$('.top-nav .nav-link--menu').click(function(e) {
		e.preventDefault();
		$(document.body).addClass('show-mobile-menu');
	});
	
	$('.top-nav .search').click(function(e) {
		e.preventDefault();
		$(document.body).addClass('show-mobile-search');
	});

	$('.top-nav .close-menu').click(function(e) {
		$(document.body).removeClass('show-mobile-menu show-mobile-search');
	});


})(jQuery);

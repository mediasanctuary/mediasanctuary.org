/**
 * Magazine
 *
 * Magazine Layout Javascript uses masonry
 */

jQuery(window).load(function () {

	var container = jQuery("#aspire_content");
	var masonry_options = function () {
		container.masonry({
			columnWidth: "#column_width",
			itemSelector: ".post_article",
			gutter: "#gutter_width",
			isAnimated: true,
			animationOptions: {
				duration: 750,
				easing: 'linear',
				queue: false
			}
		});
	};

	/* Wait for images to load */
	jQuery('img').load(function(){
		masonry_options();
	});

	masonry_options();
});

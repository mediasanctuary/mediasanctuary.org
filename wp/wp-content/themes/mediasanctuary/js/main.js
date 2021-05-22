(function($) {

	$('.top-nav .nav-link--menu').click(function(e) {
		e.preventDefault();
		$(document.body).addClass('show-mobile-menu');
	});
	
	$('.top-nav .close-menu').click(function(e) {
		$(document.body).removeClass('show-mobile-menu');
	});

})(jQuery);



/* ======================================================= 
	SLIDER
======================================================= */		

jQuery('.thumbs li').removeClass('active');
jQuery('.thumbs li.s0').addClass('active');

jQuery('.slider').each(function() {

  var sliderIdName = jQuery(this).attr('id');
  var sliderId = '#' + sliderIdName;
  var sliderIdThumbs = '#thumbs-' + sliderIdName;
  
  jQuery(sliderId).on('init', function(event, slick){
    console.log("initialized");
    if(jQuery('#caption').length > 0){
      var caption = jQuery(sliderIdThumbs +' li.active span img').data('caption');
      jQuery('#caption').html(caption);
    }
  });    
    
  jQuery(sliderId).slick({
    dots: false,
    infinite: true,
    speed: 300,
    slidesToShow: 1,
    adaptiveHeight: false
  });
  

  
  jQuery(sliderId).on('beforeChange', function (event, slick, currentSlide, nextSlide) {
   	var mySlideNumber = nextSlide.toString();
   	console.log(mySlideNumber);
   	jQuery(sliderIdThumbs +' li').removeClass('active');
    jQuery(sliderIdThumbs +' li.s'+mySlideNumber).addClass('active');
    
    if(jQuery('#caption').length > 0){
      var caption = jQuery(sliderIdThumbs +' li.s'+mySlideNumber + ' span img').data('caption');
      console.log(caption);
      jQuery('#caption').html(caption);
    }
  });

  jQuery(sliderIdThumbs + ' li span').click(function(e) {
     e.preventDefault();
     var slideno = jQuery(this).data('slide');
     console.log(slideno);
     jQuery(sliderId).slick('slickGoTo', slideno);
  });
  
  jQuery(sliderId).on('setPosition', function () {
    jQuery(this).find('.slick-slide').height('auto');
    var slickTrack = jQuery(this).find('.slick-track');
    var slickTrackHeight = jQuery(slickTrack).height();
    jQuery(this).find('.slick-slide').css('height', slickTrackHeight + 'px');
  });  
  

});

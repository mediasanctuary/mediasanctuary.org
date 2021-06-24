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
	Gallery Slider
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


/* ======================================================= 
	Testimonials Slider
======================================================= */		

jQuery('.testimonials-slider').each(function() {

  var sliderIdName = jQuery(this).attr('id');
  var sliderId = '#' + sliderIdName;   
    
  jQuery(sliderId).slick({
    dots: true,
    arrows: true,    
    infinite: true,
    speed: 300,
    slidesToShow: 2,
    adaptiveHeight: false,
    slidesToScroll: 1,
    autoplay: true,
    autoplaySpeed: 5000,
    
    responsive: [
      {
        breakpoint: 768,
        settings: {
          arrows: false,
          slidesToShow: 1
        }
      }
    ]    
  });
  
});


/* ======================================================= 
	Progress
======================================================= */		
jQuery('.progressBar').each(function() {
  var progress = jQuery(this).data('progress');
  var goal = jQuery(this).data('goal');
  var percentage = progress / goal * 100; 
  var width = percentage > 100 ? '100%' : percentage + '%';
  jQuery(this).width(width);

});


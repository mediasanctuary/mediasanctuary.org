(function($){
 
    jQuery(document).ready(function($) {
		// apply category colors
		custom_cat_colors();

		$(".ect-accordion-view").each(function () {
			var thisElement = $(this);
			thisElement.find(".ect-accordion-footer:first").addClass('show-event');
			thisElement.find('.ect-accordion-header:first').addClass('active-event');
			thisElement.find('.ect-accordion-event:first').addClass('active-event');
			ectAccordion(thisElement);
		});
	
	// 	$(".ectt-list-wrapper").each(function(){
	// 		const wrapper=$(this);
	// 		wrapper.find(".ect-load-more-btn").on("click",function(){
	// 			console.log("hello");
	// 			const type="list";
	// 			const thisEle=$(this);
	// 			const thisParent=thisEle.parents("#ect-events-list-content").find("div.ect-list-wrapper");
	// 			ectLoadMoreContent($(thisParent),thisEle,type);
	// 			return false;
	// 		});
	// 	});
	// 	$(".ectt-simple-list-wrapper").each(function(){
	// 		const wrapper=$(this);
	// 		wrapper.find(".ect-load-more-btn").on("click",function(){
	// 			const type="minimal-list";
	// 			const thisEle=$(this);
	// 			const wrpId="#"+wrapper.attr("id");
	// 			const thisParent=$(wrpId).find("#ect-minimal-list-wrp");
	// 			ectLoadMoreContent($(thisParent),thisEle,type);
	// 			return false;
	// 		});
	// 	});
	

	// 	$(".ect-accordion-view").each(function(){
	// 		const wrapper=$(this);
	// 		wrapper.find(".ect-load-more-btn").on("click",function(){
	// 			const type="accordion";
	// 			const thisEle=$(this);
	// 			const thisParent=wrapper.find(".ect-accordion-container");
	// 			ectLoadMoreContent($(thisParent),thisEle,type);
	// 			return false;
	// 		});
	// 	});

	// 	$(".tect-grid-wrapper").each(function(){
	// 	const wrapper=$(this);
	// 		wrapper.find(".ect-load-more-btn").on("click",function(){
	// 		const type="grid";
	// 		const thisEle=$(this);
	// 		const thisParent=wrapper.find("div.row");
	// 		ectLoadMoreContent($(thisParent),thisEle,type);
	// 		return false;
	// 		});
	// 	});

		
	// });

		// Event delegation for "Load More" buttons
		$(document).on("click", ".ect-load-more-btn", function() {
			const thisEle = $(this);
			let type, thisParent;

			if (thisEle.closest(".ectt-list-wrapper").length) {
				type = "list";
				thisParent = thisEle.parents("#ect-events-list-content").find("div.ect-list-wrapper");
			} else if (thisEle.closest(".ectt-simple-list-wrapper").length) {
				type = "minimal-list";
				const wrapper = thisEle.closest(".ectt-simple-list-wrapper");
				const wrpId = "#" + wrapper.attr("id");
				thisParent = $(wrpId).find("#ect-minimal-list-wrp");
			} else if (thisEle.closest(".ect-accordion-view").length) {
				type = "accordion";
				const wrapper = thisEle.closest(".ect-accordion-view");
				thisParent = wrapper.find(".ect-accordion-container");
			} else if (thisEle.closest(".tect-grid-wrapper").length) {
				type = "grid";
				const wrapper = thisEle.closest(".tect-grid-wrapper");
				thisParent = wrapper.find("div.row");
			}else if (thisEle.closest(".ect-masonry-template-cont").length) {
				type = "masonry";
				const wrapper = thisEle.closest(".ect-masonry-template-cont");
				thisParent = wrapper.find(".ect-masonary-cont");
			}

			if (type && thisParent) {
				
				ectLoadMoreContent($(thisParent), thisEle, type);
			}
			return false;
		});
	});
	
    function ectLoadMoreContent(contentWrapper,thisEle,type){ 
		var values = contentWrapper.find('.ect-month-header').last().text();
		var settingContainer= thisEle.parents('.ect-load-more').find('#ect-lm-settings');
  		// var settingContainer=thisEle.parents('.ect-masonry-template-cont').find('#ect-lm-settings');
		var ajaxUrl= settingContainer.data('ajax-url');
		var nonce_val =settingContainer.data('load-nonce');
		var settings=settingContainer.data('settings');
		var excludeEventsJson=settingContainer.attr('data-exclude-events');
		var loadMore=settingContainer.data('load-more');
		var loading=settingContainer.data('loading');
		var noEvent=settingContainer.data('loaded');
		var json_query=settingContainer.siblings('#ect-query-arg').html();
		var query=JSON.parse(json_query);
		var paged=thisEle.attr('data-paged');
		thisEle.find('.ect-preloader').show();
		thisEle.find('span').text(loading);
		var data = {};
		if(settings['filterbar'] === "yes" ){
			const wrapper = thisEle.closest(".ect-event-wrapper");
			const selectedCat =  wrapper.find("#ect-fb-category").val();
            const selectedTag =  wrapper.find("#ect-fb-tags").val();
            const selectedVenue =  wrapper.find("#ect-fb-venue").val();
            const selectedOrg =  wrapper.find("#ect-fb-org").val();
            // Capture the search input value
            const searchInput = wrapper.find("#ect-fb-search").val();
			// settings['ewpe_ev_tag']       = [selectedTag];
            // settings['ewpe_ev_organiser'] = [selectedOrg];
            // settings['ewpe_ev_venue']     = [selectedVenue];
            // settings['ewpe_ev_category']  = [selectedCat];
			data = {
				'action': 'ect_common_load_more',
				'query':query,
				'last_year_val':values,
				'load_ajax_nonce':nonce_val,
				'exclude_events':excludeEventsJson,
				'settings':settings,
				'selectedTag': selectedTag,
                'selectedVenue': selectedVenue,
                'selectedOrg': selectedOrg,
                'searchInput': searchInput,
				'selectedCat': selectedCat,
			}
		}else{
			data = {
				'action': 'ect_common_load_more',
				'query':query,
				'last_year_val':values,
			//  'paged':paged,
				'load_ajax_nonce':nonce_val,
				'exclude_events':excludeEventsJson,
				'settings':settings,
			};
		}	
		jQuery.post(ajaxUrl, data, function(response) {
			
				var rs=JSON.parse(response);
				if(rs.events=="yes"){
					setTimeout(function() {
						var content=rs.content;
						if(settings.template === 'masonry-view'){
							var elements = [];
							// Loop through each content item
							$.each(content, function(key, val) {
								var html = $(val);
								contentWrapper.append(html); // Append to the container
								elements.push(html[0]); // Collect the new elements
							});
	
							// Append all new elements to Masonry at once
							contentWrapper.masonry('appended', elements);
						}
						else{
							$.each(content, function(key, val) {
								var html = $(val);
								contentWrapper.append(html); // Append to the container
							});
	
						}
						
										
						paged=parseInt(paged)+1;
						if(rs.exclude_events){
						var oldlist=JSON.parse(excludeEventsJson);
						newExcludeList = oldlist.concat(JSON.parse(rs.exclude_events));
						settingContainer.attr('data-exclude-events','['+newExcludeList+']');
						}
						custom_cat_colors();
						thisEle.find('span').text(loadMore);
						thisEle.find('.ect-preloader').hide();
					},200);
				}
				else{
					thisEle.find('.ect-preloader').hide();
					thisEle.find('span').text(noEvent);  
					setTimeout(function() {
					thisEle.hide().find('span').text(loadMore);
					settingContainer.find('#ect-cat-load-more').hide();
					},1500);
				}
			
		}); 
	}


	/*---Accordion open function - START---*/
	function ectAccordion(thisElement) { 
	var parentEle=thisElement;
	parentEle.on("click",'.ect-accordion-header',function (){
		var accordionHeader=$(this);
		if(accordionHeader.hasClass("active-event")){
		accordionHeader.parent(".ect-accordion-event").find(".ect-accordion-footer").removeClass('show-event');
		accordionHeader.removeClass('active-event');
		accordionHeader.parent(".ect-accordion-event").removeClass('active-event');
		return;
		}
		parentEle.find(".ect-accordion-footer").removeClass('show-event');
		parentEle.find(".ect-accordion-header").removeClass('active-event');
		parentEle.find(".ect-accordion-event").removeClass('active-event');
		accordionHeader.parent(".ect-accordion-event").find(".ect-accordion-footer").addClass('show-event');
		accordionHeader.addClass('active-event');
		accordionHeader.parent(".ect-accordion-event").addClass('active-event');
		var offset = accordionHeader.offset();
		offset.top -= 90;
		$('html, body').stop().animate({
		scrollTop: offset.top,
		}, 1000);  
	});
	}
	/*---Accordion open function - END---*/




	function custom_cat_colors() {
		$("body").find(".ect-list-post,.ect-timeline-post,.ect-slider-event,.ect-carousel-event,.ect-grid-event,.ect-accordion-event").each(function() {
		var thisElement = jQuery(this);
		var bgcolor = thisElement.data("cat-bgcolor");
		var txtcolor = thisElement.data("cat-txtcolor");

		if (bgcolor != null) {
			thisElement.find(".ect-event-category ul.tribe_events_cat li a").css({
				"color": "#" + txtcolor,
				"background": convertHex("#" + bgcolor, 0.9),
				"border-color":"#" + bgcolor
			});
		}
		});
	}


	/*---Covert Hex Color into RGB with color opacity - START---*/
	function convertHex(hex, opacity) {
		hex = hex.replace('#', '');
		r = parseInt(hex.substring(0, 2), 16);
		g = parseInt(hex.substring(2, 4), 16);
		b = parseInt(hex.substring(4, 6), 16);
		result = 'rgba(' + r + ',' + g + ',' + b + ',' + opacity + ')';
		return result;
	}
	/*---Covert Hex Color into RGB with color opacity - END---*/
	
})(jQuery);
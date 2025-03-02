(function($) {
    $(".ect-event-wrapper").each(function(){
        const wrapper = $(this);
        const random = wrapper.data('random'); // Use data() method to get data attribute value
        const postAttributes = window['ect_event_wrapper_' + random];
        const masonry_filter = wrapper.find('.ect-fitlers-wrapper');
        masonry_filter.hide();
        
        // Function to handle AJAX call
        const handleAjax = function() {
            ect_filter_bar_ajax(wrapper);
        };

        // Function to check if any filter is applied
        const checkFilters = function() {
            const selectedCat = wrapper.find("#ect-fb-category").val();
            const selectedTag = wrapper.find("#ect-fb-tags").val();
            const selectedVenue = wrapper.find("#ect-fb-venue").val();
            const selectedOrg = wrapper.find("#ect-fb-org").val();
            const searchInput = wrapper.find("#ect-fb-search").val();
            const filtterbatStyle = postAttributes.attribute.filterbarstyle;

            // Check if any filter has a value other than the default or search input is not empty
            if( filtterbatStyle === 'both' || filtterbatStyle === 'filter'){
                if (
                    (selectedCat && selectedCat !== (getFirstValue(postAttributes.attribute.category) || 'all')) || 
                    (selectedTag !== (getFirstValue(postAttributes.attribute.tags) || '')) ||
                    (selectedVenue && selectedVenue !== (getFirstValue(postAttributes.attribute.venues) || '')) ||
                    (selectedOrg && selectedOrg !== (getFirstValue(postAttributes.attribute.organizers) || '')) ||
                    (searchInput && searchInput !== '')
                ) {
                    wrapper.find('.ect-clear-filter').css('display', 'block');
                } else {
                    wrapper.find('.ect-clear-filter').css('display', 'none');
                }
            }else if( filtterbatStyle === 'search'){
                if(searchInput && searchInput !== ''){
                    wrapper.find('.ect-clear-filter').css('display', 'block');
                } else {
                    wrapper.find('.ect-clear-filter').css('display', 'none');
                }
            }
            
        };

        // Bind change events for filter elements
        wrapper.find("#ect-fb-category, #ect-fb-tags, #ect-fb-venue, #ect-fb-org").on("change", function() {
            handleAjax();
            checkFilters();
        });

        // Bind keypress event for search input
        wrapper.find("#ect-fb-search").on("keypress", function(event) {
            if (event.key === "Enter") {
                handleAjax();
                checkFilters();
            }
        });
        
        // Get first value from comma-separated string
        const getFirstValue = (str) => str.split(',')[0];

        // Bind click event for the clear filter button
        wrapper.find(".ect-clear-filter").on("click", function() {
            // Get default values from attributes
            const defaultCat = (postAttributes.attribute.category) ? getFirstValue( postAttributes.attribute.category ) : 'all';
            const defaultTag = (postAttributes.attribute.tags) ? getFirstValue( postAttributes.attribute.tags ) : '';
            const defaultVenue = (postAttributes.attribute.venues) ? getFirstValue( postAttributes.attribute.venues ) : '';
            const defaultOrg = (postAttributes.attribute.organizers) ? getFirstValue( postAttributes.attribute.organizers ) : '';
            // Reset all filters to default values or "all"
            wrapper.find("#ect-fb-category").val(defaultCat);
            wrapper.find("#ect-fb-tags").val(defaultTag);
            wrapper.find("#ect-fb-venue").val(defaultVenue);
            wrapper.find("#ect-fb-org").val(defaultOrg);
            wrapper.find("#ect-fb-search").val('');

            // Call AJAX handler and update filter visibility
            handleAjax();
            checkFilters();
        });

        // Bind click event for show/hide filters button
        wrapper.find(".ect-showfilter-btn").on("click", function() {
            wrapper.find(".ect-filterbar-filters").toggleClass("active");
            const btnText = wrapper.find(".ect-filterbar-filters").hasClass("active") ? postAttributes.hideFiltersText : postAttributes.showFiltersText;
            $(this).html(btnText);
        });
    

        // AJAX call function
        function ect_filter_bar_ajax(wrapper) {
            const selectedCat = wrapper.find("#ect-fb-category").val();
            const selectedTag = wrapper.find("#ect-fb-tags").val();
            const selectedVenue = wrapper.find("#ect-fb-venue").val();
            const selectedOrg = wrapper.find("#ect-fb-org").val();
            const searchInput = wrapper.find("#ect-fb-search").val();
            const random = wrapper.data('random');

            const postAttributes = window['ect_event_wrapper_' + random];
            const ajaxUrl = postAttributes.url;
            const query = postAttributes.query;
            const nonce = postAttributes.nonce;
            const dateFormat = postAttributes.dateFormat;
            const hideVenue = postAttributes.hideVenue;
            const showDescription = postAttributes.showDescription;
            const socialShare = postAttributes.socialShare;
            const loadmore_nonce = postAttributes.loadmore_nonce;
            const style = postAttributes.style;
            const template = postAttributes.template;
            const attribute = postAttributes.attribute;

            let ect_masonry_cls = `ect-masonry-view-${attribute['style']}`;
            const data = {
                'action': 'ect_filterbar_change',
                'selectedCat': selectedCat,
                'query': query,
                'selectedTag': selectedTag,
                'selectedVenue': selectedVenue,
                'selectedOrg': selectedOrg,
                'searchInput': searchInput,
                '_ajax_nonce': nonce,
                'style': style,
                'template': template,
                'socialShare': socialShare,
                'showDescription': showDescription,
                'hideVenue': hideVenue,
                'dateFormat': dateFormat,
                'attribute': attribute,
                'loadmore_data': loadmore_nonce,
            };

            wrapper.find("#ect-filter-loader").show();
            wrapper.find('.ect-list-wrapper, .tect-grid-wrapper, .ect-minimal-list-wrapper, .ect-accordion-container, .cool-event-timeline, .slick-track, .ect-masonary-cont, .ect-advance-list').css('opacity', '0.5');
            
            $.ajax({
                type: 'POST',
                url: ajaxUrl,
                data: data,
                dataType: 'json',
                success: function(response) {
                    let contentdiv;
                    //const default_no_evt_found_div = $('.ect-no-events');
                    // const default_no_evt_found_div = wrapper.siblings('.ect-no-events');
                    // default_no_evt_found_div.remove();
                    const default_no_evt_found_div = wrapper.next('.ect-no-events'); 
                    if (default_no_evt_found_div.length) {
                        default_no_evt_found_div.remove();
                    }
                    var oldpaginationdiv;
                    const check = ['timeline', 'classic-timeline', 'timeline-view'];
                    if (response.template === 'default') {
                        contentdiv = wrapper.find('.ect-list-wrapper');
                    } else if (response.template === 'grid-view') {
                        contentdiv = wrapper.find('.tect-grid-wrapper').find('.row');
                    } else if (response.template === 'minimal-list') {
                        contentdiv = wrapper.find('.ect-minimal-list-wrapper');
                    } else if (response.template === 'accordion-view') {
                        contentdiv = wrapper.find('.ect-accordion-container');
                    } else if (check.includes(response.template)) {
                        contentdiv = wrapper.find('.cool-event-timeline');
                    } else if (response.template === 'slider-view' || response.template === 'carousel-view') {
                        contentdiv = wrapper.find('.slick-track');
                    } else if (response.template === 'masonry-view') {
                        contentdiv = wrapper.find('.ect-masonary-cont');
                        
                    } else if (response.template === 'advance-list') {
                        contentdiv = wrapper.find('.ect-advance-list tbody');
                    } else if (response.template === 'highlighted-layout') {
                        contentdiv = wrapper.find('.ect-show-events');
                    }

                    if (response.content !== '') {
                        if (response.template === 'slider-view' || response.template === 'carousel-view') {
                            const slickCarousel = wrapper.find('.ect-slider-view, .ect-carousel');
                            if (slickCarousel.length) {
                                slickCarousel.slick("slickRemove"); // Destroy existing slick instance
                                contentdiv.html(response.content);
                                slickCarousel.slick("slickAdd"); // Reinitialize slick
                                const autoplayOption1 = attribute['autoplay'] === 'true';
                                const autoplayOption  = attribute['autoplay'] === 'true';
                                slickCarousel.slick("slickSetOption", "autoplay", autoplayOption1, autoplayOption);
                            }
                        } else if (response.template === 'masonry-view') {
                            if (contentdiv.length === 0) {
                                contentdiv = $(`<div  id="ect-grid-wrapper" class="ect-masonary-cont ${ect_masonry_cls}"></div>`).appendTo(wrapper.find('.ect-masonry-template-cont'));
                            }
                            
                             // Check if Masonry is already initialized before destroying it
                             if (contentdiv.data('masonry')) {
                                contentdiv.masonry('destroy'); // Destroy existing Masonry instance
                            }
                            // Clear the content
                            contentdiv.empty();

                            // Append new content
                            contentdiv.html(response.content);

                            // Reinitialize Masonry
                            contentdiv.imagesLoaded(function() {
                                contentdiv.masonry({
                                    itemSelector: '.ect-grid-event',
                                    percentPosition: true,
                                    columnWidth: '.ect-grid-event'
                                });
                            });

                        } else {
                            contentdiv.html(response.content);
                        }
                        var paginationdiv = '';
                        
                        if (response['template'] === 'masonry-view') {
                            oldpaginationdiv = wrapper.find('.ect-masonay-load-more');
                        }
                        if (response['pagination'] != '') {
                            paginationdiv = wrapper.find('.ect-load-more');
                            if (response['template'] === 'default') {
                                contentparentDiv =  wrapper.find('.ectt-list-wrapper');
                            } else if (response['template'] === 'grid-view') {
                                contentparentDiv =  wrapper.find('.tect-grid-wrapper');
                            } else if (response['template'] === 'minimal-list') {
                                contentparentDiv =  wrapper.find('.ectt-simple-list-wrapper');
                            } else if (response['template'] === 'accordion-view') {
                                contentparentDiv =  wrapper.find('#ect-accordion-wrapper');
                            } else if (response['template'] === 'masonry-view') {
                                contentparentDiv =  wrapper.find('.ect-masonry-template-cont');
                            }  
                            if(response['template'] != 'highlighted-layout'){
                                    if (paginationdiv.length) {
                                        paginationdiv.hide();
                                        contentparentDiv.append(response['pagination']);
                                    } else {
                                        if ((response['template'] === 'masonry-view') && oldpaginationdiv) {
                                            oldpaginationdiv.remove();
                                        }
                                        contentparentDiv.append(response['pagination']);
                                    }
                            }
                        } else {
                            if ((response['template'] === 'masonry-view') && oldpaginationdiv) {
                                oldpaginationdiv.remove();
                            }
                            paginationdiv = wrapper.find('.ect-load-more');
                            paginationdiv.remove();
                        }
                        if (response.template === 'highlighted-layout') {
                         // Select and remove the div with class 'ect-right'
                         const ectRightDiv = wrapper[0].querySelector('.ect-right');
                         if (ectRightDiv && wrapper.data('style') !== 4) {
                            ectRightDiv.classList.remove("ect-img-hide");
                            ectRightDiv.classList.add("ect-img-show");
                         }
                        }
                    } else {
                        if(response.noEvents !== ''){
                            contentdiv.html(response.noEvents);
                            if (response.template === 'highlighted-layout') {
                            // Select and remove the div with class 'ect-right'
                            const ectRightDiv = wrapper[0].querySelector('.ect-right');
                            if (ectRightDiv && wrapper.data('style') !== 4) {
                                ectRightDiv.classList.remove("ect-img-show");
                                ectRightDiv.classList.add("ect-img-hide");
                            }
                            }
                        }
                        const slickCarousel = wrapper.find('.ect-slider-view, .ect-carousel');
                        if (slickCarousel.length) {
                            slickCarousel.slick("slickSetOption", "autoplay", false, true);
                        }
                        const paginationDiv = wrapper.find('.ect-load-more');
                        paginationDiv.remove();
                        oldpaginationdiv = wrapper.find('.ect-masonay-load-more');
                        if ((response['template'] === 'masonry-view') && oldpaginationdiv) {
                            oldpaginationdiv.remove();
                        }

                        // Destroy Masonry if no content is found
                        if (response.template === 'masonry-view' && contentdiv.data('masonry')) {
                            contentdiv.masonry('destroy');
                        }
                    }

                    wrapper.find("#ect-filter-loader").hide();
                    wrapper.find('.ect-list-wrapper, .tect-grid-wrapper, .ect-minimal-list-wrapper, .ect-accordion-container, .cool-event-timeline, .slick-track, .ect-masonary-cont, .ect-advance-list').css('opacity', '1');

                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error:", status, error);
                    wrapper.find("#ect-filter-loader").hide();
                    wrapper.find('.ect-list-wrapper, .tect-grid-wrapper, .ect-minimal-list-wrapper, .ect-accordion-container, .cool-event-timeline, .slick-track, .ect-masonary-cont, .ect-advance-list').css('opacity', '1');
                }
            });
        }
    });
})(jQuery);

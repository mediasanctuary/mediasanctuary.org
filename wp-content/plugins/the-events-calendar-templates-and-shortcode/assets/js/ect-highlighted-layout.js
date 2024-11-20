(function ($) {
    $(document).ready(function () {
        const ANIMATION_DURATION = 5000;
        // Initialize each .ect-highlighted-template-cont div separately
        $(".ect-highlighted-template-cont").each(function () {
            const wrapper = $(this);
            const footerWrappers = wrapper[0].querySelectorAll('.ect-highlighted-wrapper');
            let animationTimeoutId; // Separate timeout ID for each container
            const eventWrapper = wrapper.closest('.ect-event-wrapper'); // Get the parent .ect-event-wrapper
            if (eventWrapper.next('.ect-no-events').length > 0) {
                wrapper.find('.ect-right').addClass('ect-img-hide');
            } else {
                wrapper.find('.ect-right').removeClass('ect-img-hide');
            }
            // Initialize footers on page load
            footerWrappers.forEach(ectinitializeFooter);
            function ectinitializeFooter(wrapper) {
                const footers = wrapper.querySelectorAll('.ect-footer');
                footers.forEach(ecthideFooter);
                if (footers.length > 0) {
                    ectshowFooter(footers[0]);
                    ectupdateIconAndSelection(footers[0], true);
                    ectrunAnimation(footers);
                }
            }
            // Show a footer with animation
            function ectshowFooter(footer) {
                footer.style.transition = 'none';
                footer.classList.remove('ectclassHide');
                footer.style.opacity = '1';
                footer.classList.add('ectclassShow');
                footer.closest('.ect-highlighted-accordion').classList.add('active');
                setTimeout(() => {
                    footer.style.transition = '';
                    ectupdateEventImage(footer);
                }, 10);
            }
            // Hide a footer with animation
            function ecthideFooter(footer) {
                footer.style.height = '0';
                footer.style.opacity = '0';
                footer.classList.remove('ectclassShow');
                footer.classList.add('ectclassHide');
                footer.closest('.ect-highlighted-accordion').classList.remove('active');
            }
            function ectupdateEventImage(footer) {
                const accordion = footer.closest('.ect-highlighted-accordion');
                if (!accordion) return;
                const eventId = accordion.getAttribute('data-event-id');
                const eventImage = accordion.getAttribute('data-event-image');
                const eventTitle = accordion.getAttribute('data-event-title');
                const eventLink = accordion.getAttribute('data-event-link');
                // Update all featured event images within the same wrapper
                const container = accordion.closest('.ect-highlighted-template-cont');
                if (!container) return;
                const linkElement = container.querySelector('#ect-featured-event-link');
                const imageElement = container.querySelector('#ect-featured-event-image-right');
                // Update link href and image attributes
                if (linkElement) {
                    linkElement.href = eventLink;
                }
                if (imageElement) {
                    imageElement.src = eventImage;
                    imageElement.title = eventTitle;
                    imageElement.alt = eventTitle;
                }
            }
            // Update icon and selection state for a footer
            function ectupdateIconAndSelection(footer, isActive) {
                const icon = footer.parentElement.nextElementSibling;
                const date = footer.parentElement.previousElementSibling;
                icon.className = isActive ? 'ect-icon-up-double' : 'ect-icon-down-double';
                date.classList.toggle('ect-selected', isActive);
            }
            // Run the animation loop for this specific container
            function ectrunAnimation(footers, startIndex = 0) {
                let currentIndex = startIndex;
                function ectanimateNext() {
                    if (footers.length === 0) return;
                    const currentFooter = footers[currentIndex];
                    ectshowFooter(currentFooter);
                    ectupdateIconAndSelection(currentFooter, true);
                    footers.forEach((footer, i) => {
                        if (i !== currentIndex) {
                            ecthideFooter(footer);
                            ectupdateIconAndSelection(footer, false);
                        }
                    });
                    animationTimeoutId = setTimeout(() => {
                        currentIndex = (currentIndex + 1) % footers.length;
                        ectanimateNext();
                    }, ANIMATION_DURATION);
                }
                ectanimateNext();
            }
            // Stop the animation loop for this specific container
            function ectstopAnimation() {
                clearTimeout(animationTimeoutId);
            }
            // Set up MutationObserver to monitor changes in .ect-show-events
                const contentDiv = wrapper.find('.ect-show-events')[0];
                const observer = new MutationObserver(() => {
                    ectstopAnimation(); // Stop any ongoing animation
                    const footers = wrapper[0].querySelectorAll('.ect-footer');
                    // Hide all footers initially
                    footers.forEach(ecthideFooter);
                    if (footers.length > 0) {
                        // Show the first footer with a slight delay to avoid stutter
                        setTimeout(() => {
                            ectshowFooter(footers[0]);
                            ectupdateIconAndSelection(footers[0], true);
                            // Add a delay before starting the animation loop to ensure first footer is visible
                            setTimeout(() => {
                                ectrunAnimation(footers); // Restart animation for updated content
                            }, 500); // Adjust this delay if needed
                        }, 100); // Initial delay to show the first footer smoothly
                    }
                    ecticonClickEvent(); // Re-bind click events after content update
                });
                // Start observing the content div for changes
                observer.observe(contentDiv, { childList: true, subtree: true });
            // Function to bind click event listeners to icons
            function ecticonClickEvent() {
                const allIcons = wrapper.find('.ect-icon-up-double, .ect-icon-down-double');
                const footers = wrapper[0].querySelectorAll('.ect-footer');
                // Clear previous click bindings
                allIcons.off('click');
                allIcons.each((i, icon) => {
                    $(icon).on('click', () => {
                        ectstopAnimation(); // Stop animation on each click
                        if ($(icon).hasClass('ect-icon-down-double')) {
                            // Show the corresponding footer for down-double icon
                            footers.forEach(ecthideFooter);  // Hide all footers
                            ectshowFooter(footers[i]);
                            ectupdateIconAndSelection(footers[i], true);
                            ectrunAnimation(footers, i); // Restart animation from this index
                        } else if ($(icon).hasClass('ect-icon-up-double')) {
                            // Hide current footer and show next footer
                            ecthideFooter(footers[i]);
                            ectupdateIconAndSelection(footers[i], false);
                            // Show the next footer or loop to start
                            const nextIndex = (i + 1) % footers.length;
                            ectshowFooter(footers[nextIndex]);
                            ectupdateIconAndSelection(footers[nextIndex], true);
                            ectrunAnimation(footers, nextIndex); // Restart animation from the next index
                        }
                    });
                });
            }
            // Bind click events initially
            ecticonClickEvent();
            // Handle category filtering with AJAX
            wrapper.find(".ect-categories li").on("click", function (e) {
                e.preventDefault();
                $(this).addClass("ect-active").siblings().removeClass("ect-active");
                const selectedCat = $(this).data('filter-id');
                ectfetchFilteredEvents(selectedCat, wrapper);
            });
            // AJAX request to fetch filtered events
            function ectfetchFilteredEvents(selectedCat, wrapper) {
                const random = wrapper.data('random-num'); // Use data() method to get data attribute value
                const postAttributes = window['ect_highlight_wrapper' + random];
                const data = {
                    action: 'ect_catfilters_highlighted_layout',
                    selectedCat,
                    query: postAttributes.query,
                    attribute: postAttributes.attribute,
                    _ajax_nonce: postAttributes.nonce,
                };
                $.ajax({
                    type: 'POST',
                    url: postAttributes.url,
                    data,
                    dataType: 'json',
                    success(response) {
                        const contentDiv = wrapper.find('.ect-show-events');
                        if (response.content) {
                            contentDiv.fadeOut(100, function() {
                                // Update the content once fade out is complete
                                contentDiv.html(response.content);
                                // Fade in the new content
                                contentDiv.fadeIn(100);
                            });
                            // Select and remove the div with class 'ect-right'
                            const ectRightDiv = wrapper[0].querySelector('.ect-right');
                            ectRightDiv.classList.remove("ect-img-hide");
                            ectRightDiv.classList.add("ect-img-show");
                        } else {
                            contentDiv.html(response.noEvents);
                            // Select and remove the div with class 'ect-right'
                            const ectRightDiv = wrapper[0].querySelector('.ect-right');
                            ectRightDiv.classList.remove("ect-img-show");
                            ectRightDiv.classList.add("ect-img-hide");
                        }
                    },
                    error(xhr, status, error) {
                        console.error("AJAX Error:", status, error);
                    }
                });
            }
        });
    });
})(jQuery);

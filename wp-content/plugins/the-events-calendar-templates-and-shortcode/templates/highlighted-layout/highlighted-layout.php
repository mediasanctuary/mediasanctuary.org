<?php
// Check for direct access
if (!defined('ABSPATH')) {
    exit();
}

/**
 * Generate accordion layout HTML for event.
 */
$event_title = get_the_title($event_id);  // Fetch event title
$event_date = tribe_get_start_date($event_id, false);
$event_schedule = ect_event_schedule( $event_id, $date_format, $template );
$ev_post_img = esc_url(ect_pro_get_event_image($event_id, 'large'));  // Event image
$event_link = esc_url(tribe_get_event_link($event_id));  // Event link
$event_description = wp_trim_words(get_post_field('post_content', $event_id), 20);
$event_venue = tribe_get_venue_details( $event_id ); // Event description
  
// Check style and generate HTML
if ($highlighted_style == 'style-1' || $highlighted_style == 'style-3') {
    // Start HTML output for style-1
    $events_html .= '<div id="event-' . esc_attr($event_id) . '"' . $cat_colors_attr . ' class="ect-left ect-highlighted-event ' . esc_attr($highlighted_style) . ' ' . esc_attr($event_type) . '">
                <div class="ect-highlighted-accordion" data-event-id="' . esc_attr($event_id) . '" data-event-title="' . esc_attr($event_title) . '" data-event-image="' . esc_attr($ev_post_img) . '" data-event-link="'. esc_attr($event_link) .'">
                    <div class="ect-highlighted-date">
                        <span>' . esc_html(date('d', strtotime($event_date))) . '</span>
                        <span>' . esc_html(date('M', strtotime($event_date))) . '</span>
                    </div>
                    <div class="ect-event-details">
                    <div class="ect-highlighted-right">
                        <div class="ect-highlighted-title">' . esc_html($event_title) . '</div>
                    </div>
                        <div class="ect-footer">';
                    // Check if venue exists and display its details
                    if (tribe_has_venue($event_id) && isset($event_venue['linked_name'])) {
                        if($hide_venue == 'no'){
                                $events_html .= '<div class="ect-highlighted-venue">';
                                $events_html .= '<span class="ect-icon"><i class="ect-icon-location" aria-hidden="true"></i></span>';
                                $events_html .= '<span class="ect-venue-details ect-address">' . $event_venue['linked_name'] . '</span>';

                                // Display address if available
                                if (!empty($event_venue['address'])) {
                                    $events_html .= '<div class="ect-venue-address">' .$event_venue['address'] . '</div>';
                                }

                                // Add Google map link if available
                                if (tribe_get_map_link($event_id)) {
                                    $events_html .= '<span class="ect-google">' . tribe_get_map_link_html($event_id) . '</span>';
                                }

                                $events_html .= '</div>'; 
                            } // Close venue details div
                    }
                    // Display event description if available
                        if($show_description == 'yes'){
                            if (!empty($event_description)) {
                                $events_html .= '<div class="ect-description">' . esc_html($event_description) . '</div>';
                            }
                        }
                    $events_html .= '<a href="' . $event_link . '" class="ect-read-more">Read More</a>
                                    <div class="ect-highlighted-img">
										<img id="ect-featured-event-image" src="'. $ev_post_img .'" title="'. esc_attr($event_title) .'" alt="'. esc_attr($event_title) .'">
									</div>
                        </div>  <!-- Close footer -->
                    </div>  <!-- Close event details -->
                    <i class="ect-icon-down-double" aria-hidden="true"></i>
                </div>
    </div>';
}

// Now, let's add the dynamic content for style-2
elseif ($highlighted_style == 'style-2') {
    // Start HTML output for style-2
    $events_html .= '<div id="event-' . esc_attr($event_id) . '"' .$cat_colors_attr. ' class="ect-left ect-highlighted-event ' . esc_attr($highlighted_style) . ' ' . esc_attr($event_type) . '" >
                        <div class="ect-highlighted-accordion" data-event-id="'. esc_attr($event_id) . '" data-event-title="' . esc_attr($event_title) . '"  data-event-image="' . esc_attr($ev_post_img) . '" data-event-link="'. esc_attr($event_link) .'">
                            <div class="ect-calendar">
                                <span><i aria-hidden="true" class="ect-icon-calendar"></i></span>
                            </div>
                            <div class="ect-event-details">
                            <div class="ect-highlighted-right">
                                <div class="ect-highlighted-date">' . wp_kses_post($event_schedule) . '</div>
                                <div class="ect-highlighted-title">' . esc_html($event_title) . '</div>
                            </div>
                                <div class="ect-footer">';
                            // Check if venue exists and display its details
                            if (tribe_has_venue($event_id) && isset($event_venue['linked_name'])) {
                                if($hide_venue == 'no'){
                                        $events_html .= '<div class="ect-highlighted-venue">';
                                        $events_html .= '<span class="ect-icon"><i class="ect-icon-location" aria-hidden="true"></i></span>';
                                        $events_html .= '<span class="ect-venue-details ect-address">' . $event_venue['linked_name'] . '</span>';

                                        // Display address if available
                                        if (!empty($event_venue['address'])) {
                                            $events_html .= '<div class="ect-venue-address">' .$event_venue['address'] . '</div>';
                                        }

                                        // Add Google map link if available
                                        if (tribe_get_map_link($event_id)) {
                                            $events_html .= '<span class="ect-google">' . tribe_get_map_link_html($event_id) . '</span>';
                                        }

                                        $events_html .= '</div>';  // Close venue details div
                                    }
                            }
                            if($show_description == 'yes'){
                                if(!empty($event_description)){
                                    $events_html .= '<div class="ect-description">' . esc_html($event_description) . '</div>';
                                }
                            }
                $events_html .= '<a href="' . $event_link . '" class="ect-read-more">Read More</a>
                                    <div class="ect-highlighted-img">
										<img id="ect-featured-event-image" src="'. $ev_post_img .'" title="'. esc_attr($event_title) .'" alt="'. esc_attr($event_title) .'">
									</div>
                                </div>
                            </div>
                            <i class="ect-icon-down-double" aria-hidden="true" ></i>
                        </div>
                        <!-- You can add more event listings here by looping --> 
            </div>';
} else {
    // Now, let's add the dynamic content for style-4
   if ($highlighted_style == 'style-4') {
    // Start HTML output for style-4
    $events_html .= '<div id="event-' . esc_attr($event_id) . '"' .$cat_colors_attr. ' class="ect-left ect-highlighted-event ' . esc_attr($highlighted_style) . ' ' . esc_attr($event_type) . '" >
                        <div class="ect-highlighted-accordion" data-event-id="'. esc_attr($event_id) . '" data-event-title="' . esc_attr($event_title) . '"  data-event-image="' . esc_attr($ev_post_img) . '" data-event-link="'. esc_attr($event_link) .'">
                            <div class="ect-calendar">
                            </div>
                            <div class="ect-event-details">
                                <div class="ect-highlighted-right">
                                    <div class="ect-highlighted-date"><i aria-hidden="true" class="ect-icon-calendar"></i>' . wp_kses_post($event_schedule) . '</div>
                                    <div class="ect-highlighted-title">' . esc_html($event_title) . '</div>
                                </div>
                                <div class="ect-footer">';
                            // Check if venue exists and display its details
                            if($hide_venue == 'no'){
                                if (tribe_has_venue($event_id)) {
                                    // Fetching venue details
                                    $venue_name = tribe_get_venue($event_id); // Venue name
                                    $venue_address = tribe_get_address($event_id); // Address
                                    $venue_city = tribe_get_city($event_id); // City
                                    $venue_state = tribe_get_stateprovince( $event_id ); // State
                                    $venue_country = tribe_get_country($event_id); // Country
                                    $venue_zip = tribe_get_zip($event_id); // ZIP/Postal Code
                                    $google_map_link = tribe_get_map_link($event_id); // Google Map Link
                                    
                        
                                    // Generate venue link
                                    $venue_link = tribe_get_venue_link($event_id);
                                
                                    // Make venue name a clickable link
                                    if (!empty($venue_name) && !empty($venue_link)) {
                                        $venue_name =$venue_link;
                                    }
                                
                                    // Constructing a single-line venue details string
                                    $venue_details = trim(implode(', ', array_filter([$venue_name, $venue_address, $venue_city, $venue_state, $venue_zip, $venue_country])));
                                
                                    // Adding the venue details to the HTML
                                    if (!empty($venue_details)) {
                                        // Adding Google Map link if available
                                        if (!empty($google_map_link)) {
                                            $venue_details .= '<a href="' . esc_url($google_map_link) . '" target="_blank" rel="nofollow noopener">'. __(' + Google Map', 'ect') .'</a>';
                                        }
                                        $events_html .= '<div class="ect-highlighted-venue">';
                                        $events_html .= '<i class="ect-icon-location"></i> ' . wp_kses_post($venue_details);
                                        $events_html .= '</div>';
                                    }
                                }
                            }
                            if($show_description == 'yes'){
                                if(!empty($event_description)){
                                    $events_html .= '<div class="ect-description">' . esc_html($event_description) . '</div>';
                                }
                            }
                $events_html .= '<a href="' . $event_link . '" class="ect-read-more">Read More</a>
                                </div>
                            </div>
                            <i class="ect-icon-down-double" aria-hidden="true" ></i>
                        </div>
                        <!-- You can add more event listings here by looping --> 
            </div>';
}
}
$nonce_ect_hl_filter = wp_create_nonce( 'ect-hl-catfilters' );
wp_localize_script(
    'ect-highlighted-js',
    'ect_highlight_wrapper' . $number,
    array(
        'url'             => admin_url( 'admin-ajax.php' ),
        'nonce'           => $nonce_ect_hl_filter,
        'query'           => $ect_args,
        'hideVenue'       => $hide_venue,
        'showDescription' => $show_description,
        'template'        => $template,
        'dateFormat'      => $date_format,
        'style'           => $highlighted_style,
        'attribute'       => $attribute,
    )
);
<?php
if (!defined('ABSPATH')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}
/**
 * This file is used to generate timeline layout html.
 */
$timeline_style = isset($attribute['style']) ? esc_attr($attribute['style']) : '';
if ($template == 'timeline') {
    $timeline_style = 'style-1';
} elseif ($template == 'classic-timeline') {
    $timeline_style = 'style-2';
}

$ev_post_img = '';
$size = 'large';
$ev_post_img = esc_url(ect_pro_get_event_image($event_id, $size));
$ect_cate = ect_display_category($event_id);
if ($i % 2 == 0) {
    $even_odd = 'even';
} else {
    $even_odd = 'odd';
}

if ($timeline_style == 'style-1') {
    if (!empty($events_date_header) && $timeline_style == 'style-1') {
        $events_html .= '<div class="ect-timeline-year">
                        <div class="year-placeholder">' . $events_date_header . '</div>
                        </div>';
    }

    $events_html .= '<div id="event-' . esc_attr($event_id) . '"' .$cat_colors_attr. ' class="ect-timeline-post ' . esc_attr($even_odd) . ' ' . esc_attr($event_type) . ' ' . esc_attr($timeline_style) . '">';

    if ($timeline_style == 'style-1') {
        $events_html .= '<div class="timeline-dots"></div>';
    }
    $events_html .= '<div class="timeline-content ' . esc_attr($even_odd) . '">';
    $events_html .= '<div class="ect-timeline-header">';
    if ($ev_post_img) {
        $events_html .= '<a class="timeline-ev-img" href="' . esc_url(tribe_get_event_link($event_id)) . '"><img src="' . esc_url($ev_post_img) . '" alt="' . esc_attr(get_the_title($event_id)) . '"/></a>';
    }

    if ($socialshare == 'yes') {
        $events_html .= ect_pro_share_button($event_id);
    }

    $events_html .= '</div>';
    $events_html .= '<div class="ect-timeline-main-content">';
    $events_html .= '<div class="ect-timeline-date">';
    $events_html .= wp_kses_post($event_schedule);
    $events_html .= '</div>';
    $events_html .= '<h2 class="content-title">' . wp_kses_post($event_title) . '</h2>';
    if (!empty($ect_cate)) {
        $events_html .= '<div class="ect-event-category ect-timeline-categories">';
        $events_html .= wp_kses_post($ect_cate);
        $events_html .= '</div>';
    }
    if ($show_description == 'yes' || $show_description == '') {
        $events_html .= wp_kses_post($event_content);
    }
    $events_html .= wp_kses_post($venue_details_html);
    if (tribe_get_cost($event_id, true)) {
        $events_html .= wp_kses_post($ev_cost);
    }
    $events_html .= '</div>';
    $events_html .= '<div class="ect-lslist-event-detail">
        <a href="' . esc_url(tribe_get_event_link($event_id)) . '" title="' . esc_attr(get_the_title($event_id)) . '" rel="bookmark">' . esc_html($events_more_info_text) . '</a>
        </div>';
    $events_html .= '</div>';
    $events_html .= '</div>';
    $i++;
} elseif ($timeline_style == 'style-2') {
    if (!empty($events_date_header)) {
        $events_html .= '<div class="ect-timeline-year">
                        <div class="year-placeholder">' . $events_date_header . '</div>
                        </div>';
    }
    $events_html .= '<div id="event-' . esc_attr($event_id) . '"' .$cat_colors_attr. ' class="ect-timeline-post even ' . esc_attr($event_type) . ' ' . esc_attr($timeline_style) . '">';
    $events_html .= '<div class="timeline-dots"></div>';
    $events_html .= '<div class="timeline-content even">';
    $events_html .= '<div class="ect-timeline-header">';
    if ($ev_post_img) {
        $events_html .= '<a class="timeline-ev-img" href="' . esc_url(tribe_get_event_link($event_id)) . '"><img src="' . esc_url($ev_post_img) . '" alt="' . esc_attr(get_the_title($event_id)) . '"/></a>';
    }
    $events_html .= wp_kses_post($event_schedule);
    if ($socialshare == 'yes') {
        $events_html .= ect_pro_share_button($event_id);
    }
    $events_html .= '</div>';
    $events_html .= '<div class="ect-timeline-main-content">';
    if (!empty($ect_cate)) {
        $events_html .= '<div class="ect-event-category ect-timeline-categories">';
        $events_html .= wp_kses_post($ect_cate);
        $events_html .= '</div>';
    }
    $events_html .= '<h2 class="content-title">' . wp_kses_post($event_title) . '</h2>';
    if ($show_description == 'yes' || $show_description == '') {
        $events_html .= wp_kses_post($event_content);
    }
    $events_html .= wp_kses_post($venue_details_html);
    $events_html .= '</div>';
    $events_html .= '<div class="ect-timeline-footer">';
    if (tribe_get_cost($event_id, true)) {
        $events_html .= wp_kses_post($ev_cost);
    }
    $events_html .= '<div class="ect-lslist-event-detail">
        <a href="' . esc_url(tribe_get_event_link($event_id)) . '" title="' . esc_attr(get_the_title($event_id)) . '" rel="bookmark">' . esc_html($events_more_info_text) . '</a>
        </div></div>';
    $events_html .= '</div>';
    $events_html .= '</div>';
} else if($timeline_style == 'style-4'){
    if (!empty($events_date_header)) {
        $events_html .= '<div class="ect-timeline-year">
                        <div class="year-placeholder">' . $events_date_header . '</div>
                        </div>';
    }
    $events_html .= '<div id="event-' . esc_attr($event_id) . '"' .$cat_colors_attr. ' class="ect-timeline-post even ' . esc_attr($event_type) . ' ' . esc_attr($timeline_style) . '">';
    $events_html .= '<div class="timeline-dots"></div>';
    $events_html .= '<div class="timeline-content even">';
    $events_html .= '<div class="ect-timeline-header">';
    if ($ev_post_img) {
        $events_html .= '<a class="timeline-ev-img" href="' . esc_url(tribe_get_event_link($event_id)) . '"><img src="' . esc_url($ev_post_img) . '" alt="' . esc_attr(get_the_title($event_id)) . '"/></a>';
    }
    $events_html .= wp_kses_post($event_schedule);
    if ($socialshare == 'yes') {
        $events_html .= ect_pro_share_button($event_id);
    }
    $events_html .= '</div>';
    $events_html .= '<div class="ect-timeline-main-content">';
    if (!empty($ect_cate)) {
        $events_html .= '<div class="ect-event-category ect-timeline-categories">';
        $events_html .= wp_kses_post($ect_cate);
        $events_html .= '</div>';
    }
    $events_html .= '<div class="ect-timeline-title"><h2 class="content-title">' . wp_kses_post($event_title) . '</h2></div>';
    if ($show_description == 'yes' || $show_description == '') {
        $events_html .= wp_kses_post($event_content);
    }
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
                $events_html .= '<div class="ect-timeline-venue">';
                $events_html .= '<i class="ect-icon-location"></i> ' . wp_kses_post($venue_details);
                $events_html .= '</div>';
            }
        }
    }
    $events_html .= '<div class="ect-cost-readme">';
    if (tribe_get_cost($event_id, true)) {
        $events_html .= wp_kses_post($ev_cost);
    }
    $events_html .= '<div class="ect-lslist-event-detail">
        <a href="' . esc_url(tribe_get_event_link($event_id)) . '" title="' . esc_attr(get_the_title($event_id)) . '" rel="bookmark">' . esc_html($events_more_info_text) . '</a>
        </div></div></div>';
    $events_html .= '</div>';
    $events_html .= '</div>';
}  else {
    if (!empty($events_date_header)) {
        $events_html .= '<div class="ect-timeline-year">
                        <div class="year-placeholder">' . $events_date_header . '</div>
                        </div>';
    }

    $events_html .= '<div id="event-' . esc_attr($event_id) . '"' .$cat_colors_attr. ' class="ect-timeline-post even ' . esc_attr($event_type) . ' ' . esc_attr($timeline_style) . '">';
    $events_html .= '<div class="timeline-dots"></div>';
    $events_html .= '<div class="timeline-content even">';
    $events_html .= '<div class="ect-timeline-header">';
    if ($ev_post_img) {
        $events_html .= '<a class="timeline-ev-img" href="' . esc_url(tribe_get_event_link($event_id)) . '"><img src="' . esc_url($ev_post_img) . '" alt="' . esc_attr(get_the_title($event_id)) . '"/></a>';
    }
    $events_html .= wp_kses_post($event_schedule);
    if ($socialshare == 'yes') {
        $events_html .= ect_pro_share_button($event_id);
    }

    if (!empty($ect_cate)) {
        $events_html .= '<div class="ect-event-category ect-timeline-categories">';
        $events_html .= wp_kses_post($ect_cate);
        $events_html .= '</div>';
    }
    $events_html .= '</div>';
    $events_html .= '<div class="ect-timeline-main-content">';
    $events_html .= '<h2 class="content-title">' . wp_kses_post($event_title) . '</h2>';

    if ($show_description == 'yes' || $show_description == '') {
        $events_html .= wp_kses_post($event_content);
    }
    $events_html .= wp_kses_post($venue_details_html);
    if (tribe_get_cost($event_id, true)) {
        $events_html .= '<div class="ect-timeline-footer">';
        $events_html .= wp_kses_post($ev_cost);
        $events_html .= '<div class="ect-lslist-event-detail">
        <a href="' . esc_url(tribe_get_event_link($event_id)) . '" title="' . esc_attr(get_the_title($event_id)) . '" rel="bookmark">' . esc_html($events_more_info_text) . '</a>
        </div></div>';
    } else {
        $events_html .= '<div class="ect-timeline-footer">';
        $events_html .= '<div class="ect-lslist-event-detail full-view">
        <a href="' . esc_url(tribe_get_event_link($event_id)) . '" title="' . esc_attr(get_the_title($event_id)) . '" rel="bookmark">' . esc_html($events_more_info_text) . '</a>
        </div></div>';
    }
    $events_html .= '</div>';
    $events_html .= '</div>';
    $events_html .= '</div>';
}

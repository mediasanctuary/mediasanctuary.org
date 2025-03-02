<?php
if (!defined('ABSPATH')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}
/**
 * This file is used to generate accordion layout html.
 */
$size = 'medium';
$start_date = esc_html(tribe_get_start_date($event_id, false, 'F j (l) g:i a'));
$end_date = esc_html(tribe_get_end_date($event_id, false, 'F j (l) g:i a'));
$map = tribe_get_embedded_map($event_id);
$ev_post_img = '';
$ev_post_img = esc_url(ect_pro_get_event_image($event_id, $size = 'large'));
$ect_cate = ect_display_category($event_id);

/*---Accordion STYLE 1, STYLE 2, STYLE 3 START---*/
if ($style == 'style-1' || $style == 'style-2' || $style == 'style-3') {
    $events_html .= '
    <div id="ect-accordion-event-' . esc_attr($event_id) . '"' .$cat_colors_attr. ' class="ect-accordion-event ' . esc_attr($style) . ' ' . esc_attr($event_type) . '" >
        <div class="ect-accordion-header">
            <div class="ect-accordion-header-left">
                <div class="ect-accordion-date">' . wp_kses_post($event_schedule) . '</div>
            </div>
            <div class="ect-accordion-header-right">';

    $events_html .= $event_title;
    if ($style === 'style-1') {
        if (!empty($ect_cate)) {
            $events_html .= '<div class="ect-event-category ect-accordion-categories">';
            $events_html .= $ect_cate;
            $events_html .= '</div>';
        }
    }
    $events_html .= '<div class="ect-accordion-date-full">
                            ' . esc_html($start_date) . ' - ' . esc_html($end_date) . '
                        </div>';
    if (tribe_has_venue($event_id)) {
        $events_html .= '<div class="ect-accordion-venue">' . $venue_details_html . '</div>';
    }
    if ($style !== 'style-1') {
        if (!empty($ect_cate)) {
            $events_html .= '<div class="ect-event-category ect-accordion-categories">';
            $events_html .= $ect_cate;
            $events_html .= '</div>';
        }
    }
    if ($socialshare == 'yes') {
        $events_html .= ect_pro_share_button($event_id);
    }
    $events_html .= '</div>';

    $events_html .= '</div>
		<div class="ect-accordion-footer">';
    $events_html .= '<div class="ect-accordion-content">';
    if ($show_description == 'yes' || $show_description == '') {
        $events_html .= $event_content;
    }
    if (tribe_get_cost($event_id, true)) {
        $events_html .= '<div class="ect-accordion-cost">' . $ev_cost . '</div>';
    }
    $events_html .= '<a href="' . esc_url(tribe_get_event_link($event_id)) . '" class="ect-events-read-more" rel="bookmark" >' . esc_html($events_more_info_text) . '</a>
			</div>';
    $events_html .= '<div class="ect-accordion-image">
                    <img src="' . esc_url($ev_post_img) . '" title="' . esc_attr(get_the_title($event_id)) . '" alt="' . esc_attr(get_the_title($event_id)) . '"></div>';
    if ($style != 'style-1') {
        $events_html .= '<div class="ect-accordion-map">' . $map . '</div>';
    }

    $events_html .= '</div>
    </div>';
}
/*---Accordion STYLE 1, STYLE 2, STYLE 3 END---*/

/*---Accordion STYLE 4 START---*/
elseif ($style == 'style-4') {
    $events_html .= '
    <div id="ect-accordion-event-' . esc_attr($event_id) . '"' .$cat_colors_attr. ' class="ect-accordion-event ' . esc_attr($style) . ' ' . esc_attr($event_type) . '" >
        <div class="ect-accordion-header">
            <div class="ect-accordion-header-left">
                <div class="ect-accordion-date">' . wp_kses_post($event_schedule) . '</div>
            </div>
            <div class="ect-accordion-header-right">';

    $events_html .= $event_title;
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
                $events_html .= '<div class="ect-accordion-venue">';
                $events_html .= '<i class="ect-icon-location"></i> ' . wp_kses_post($venue_details);
                $events_html .= '</div>';
            }
        }
    }
    
    $events_html .= '</div>';

    $events_html .= '</div>
		<div class="ect-accordion-footer">';
            if ($socialshare == 'yes') {
                $events_html .= ect_pro_share_button($event_id);
            }
            if ($style !== 'style-1') {
                if (!empty($ect_cate)) {
                    $events_html .= '<div class="ect-event-category ect-accordion-categories">';
                    $events_html .= $ect_cate;
                    $events_html .= '</div>';
                }
            }
    $events_html .= '<div class="ect-accordion-date-full">
                            ' . esc_html($start_date) . ' - ' . esc_html($end_date) . '
                        </div>';
    $events_html .= '<div class="ect-accordion-content">';
    if ($show_description == 'yes' || $show_description == '') {
        $events_html .= $event_content;
    }
    if (tribe_get_cost($event_id, true)) {
        $events_html .= '<div class="ect-accordion-cost">' . $ev_cost . '</div>';
    }
    $events_html .= '<a href="' . esc_url(tribe_get_event_link($event_id)) . '" class="ect-events-read-more" rel="bookmark" >' . esc_html($events_more_info_text) . '</a>
			</div>';
    $events_html .= '<div class="ect-accordion-image">
                    <img src="' . esc_url($ev_post_img) . '" title="' . esc_attr(get_the_title($event_id)) . '" alt="' . esc_attr(get_the_title($event_id)) . '"></div>';
    if ($style != 'style-1') {
        $events_html .= '<div class="ect-accordion-map">' . $map . '</div>';
    }

    $events_html .= '</div>
    </div>';
}
/*---Accordion STYLE 4 END---*/

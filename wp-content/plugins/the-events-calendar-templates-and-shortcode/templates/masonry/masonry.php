<?php
if (!defined('ABSPATH')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}

$ev_post_img = '';
$size = 'medium';
$ev_post_img = esc_url(ect_pro_get_event_image($event_id, $size = 'large'));
$ect_cate = ect_display_category($event_id);
$event_venue = tribe_get_venue_details( $event_id ); 

if ($ect_grid_columns == 2) {
    $ect_grid_columns_cls = 'col-md-6';
} elseif ($ect_grid_columns == 3) {
    $ect_grid_columns_cls = 'col-md-4';
} elseif ($ect_grid_columns == 6) {
    $ect_grid_columns_cls = 'col-md-2';
} else {
    $ect_grid_columns_cls = 'col-md-3';
}

/**
 * Get Category Name
 */
$ect_event_in = array();
$ect_get_cat = get_the_terms($event_id, 'tribe_events_cat');
if ($ect_get_cat && !is_wp_error($ect_get_cat)) {
    foreach ($ect_get_cat as $ect_slug_name) {
        $ect_event_in[] = esc_attr($ect_slug_name->slug);
    }
} else {
    $ect_cat_name = '';
}

$eventallFilters = implode(',', $ect_event_in);

$events_html .= '<div
id="event-' . esc_attr($event_id) . '"' .$cat_colors_attr. '
class="ect-grid-event ' . esc_attr($grid_style) . ' ' . esc_attr($event_type) . ' ' . esc_attr($ect_grid_columns_cls) . '"
data-filter="' . esc_attr($eventallFilters) . '">

<div class="ect-grid-event-area">';

if ($grid_style == 'style-4') {
    // Event Image and Date Highlight
    $events_html .= '<div class="ect-grid-post-image">
        <div class="ect-grid-img">
            <a href="' . esc_url(tribe_get_event_link($event_id)) . '"><img src="' . esc_url($ev_post_img) . '" alt="' . esc_attr(get_the_title($event_id)) . '"></a>
        </div>
        <div class="ect-date-highlight">
            <div class="ect-date-area">
                <span class="ev-day">' . esc_html(tribe_get_start_date($event_id, false, 'd')) . '</span>
                <span class="ev-mo">' . esc_html(tribe_get_start_date($event_id, false, 'M')) . '</span>
            </div>
        </div>';
        if ($socialshare == "yes") {$events_html .= ect_pro_share_button($event_id);}
    $events_html .= '</div>';

    // Event Content
    $events_html .= '<div class="ect-grid-post-content">';
    // Event Category and Schedule
    $events_html .= '<div class="ect-category-time">';
    if (!empty($ect_cate)) {
        $events_html .= '<div class="ect-event-category">';
        $events_html .= wp_kses_post($ect_cate);
        $events_html .= '</div>';
    }
    $events_html .= '</div>';
    $events_html .= '<div class="ect-event-schedule"><i aria-hidden="true" class="ect-icon-calendar"></i>' . wp_kses_post($event_schedule) . '</div>';

    // Event Title
    $events_html .= '<div class="ect-grid-title"><h4>' . wp_kses_post($event_title) . '</h4></div>';

    // Event Description
    if ($show_description == 'yes') {
        $events_html .= '<div class="ect-grid-description">' . wp_kses_post($event_content) . '</div>';
    }

    // Event Venue
    // Check if venue exists and display its details
        if (tribe_has_venue($event_id) && isset($event_venue['linked_name'])) {
            if($hide_venue == 'no'){
                    $events_html .= '<div class="ect-grid-venue-style-4">';
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

    // Read More and Cost
    $events_html .= '<div class="ect-readmore-cost">
        <span class="ect-readmore">
             <a href="' . esc_url(tribe_get_event_link($event_id)) . '" class="ect-events-read-more" rel="bookmark">' . esc_html($events_more_info_text) . '</a>
        </span>';
    if (tribe_get_cost($event_id, true)) {
        $events_html .= '<div class="ect-grid-cost">' . $ev_cost . '</div>';
    }
    $events_html .= '</div>'; // Close .ect-readmore-cost

    $events_html .= '</div>'; // Close .ect-grid-post-content
} else {
    $events_html .= '<div class="ect-grid-image">
    <a href="' . esc_url(tribe_get_event_link($event_id)) . '">
    <img src="' . esc_url($ev_post_img) . '" title="' . esc_attr(get_the_title($event_id)) . '" alt="' . esc_attr(get_the_title($event_id)) . '">
    </a>';
    if ($grid_style == 'style-1') {
        if ($socialshare == 'yes') {
            $events_html .= ect_pro_share_button($event_id);
        }
    } else {
        if ($grid_style == 'style-3') {
            if (!empty($ect_cate)) {
                $events_html .= '<div class="ect-event-category ect-grid-categories">';
                $events_html .= wp_kses_post($ect_cate);
                $events_html .= '</div>';
            }
            $events_html .= '</div>';
        }
        $events_html .= '<div class="ect-grid-date">
        ' . wp_kses_post($event_schedule) . '
        </div>';
        if ($socialshare == 'yes') {
            $events_html .= ect_pro_share_button($event_id);
        }
    }
    if ($grid_style != 'style-3') {
        $events_html .= '</div>';
    }
    $events_html .= '<div class="ect-grid-content">';
    if ($grid_style == 'style-1') {
        $events_html .= '<div class="ect-grid-date">
        ' . wp_kses_post($event_schedule) . '
        </div>';
    }
    if ($grid_style == 'style-2') {
        if (!empty($ect_cate)) {
            $events_html .= '<div class="ect-event-category ect-grid-categories">';
            $events_html .= wp_kses_post($ect_cate);
            $events_html .= '</div>';
        }
    }
    $events_html .= '<div class="ect-grid-title"><h4>' . wp_kses_post($event_title) . '</h4></div>';
    if ($grid_style == 'style-1') {
        if (!empty($ect_cate)) {
            $events_html .= '<div class="ect-event-category ect-grid-categories">';
            $events_html .= wp_kses_post($ect_cate);
            $events_html .= '</div>';
        }
    }
    if ($show_description == 'yes') {
        $events_html .= '<div class="ect-grid-description">
        ' . wp_kses_post($event_content) . '</div>';
    }
    if (tribe_has_venue($event_id) && $hide_venue != 'yes') {
        $events_html .= '<div class="ect-grid-venue">' . wp_kses_post($venue_details_html) . '</div>';
    }
    if ($grid_style == 'style-2') {
        $events_html .= '</div>';
    }
    if (tribe_get_cost($event_id, true)) {
        $events_html .= '<div class="ect-grid-footer"><div class="ect-grid-cost">' . $ev_cost . '</div>
        <div class="ect-grid-readmore">
        <a href="' . esc_url(tribe_get_event_link($event_id)) . '" title="' . esc_attr(get_the_title($event_id)) . '" rel="bookmark">' . esc_html($events_more_info_text) . '</a>
        </div></div>';
    } else {
        $events_html .= '<div class="ect-grid-footer"><div class="ect-grid-readmore full-view">
        <a href="' . esc_url(tribe_get_event_link($event_id)) . '" title="' . esc_attr(get_the_title($event_id)) . '" rel="bookmark">' . esc_html($events_more_info_text) . '</a>
        </div></div>';
    }
    if ($grid_style != 'style-2') {
        $events_html .= '</div>';
    }
}
$events_html .= '</div></div>';

<?php
if (!defined('ABSPATH')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}
/**
 * This file is used to generate slider layout html.
 */
$slider_style = isset($attribute['style']) ? esc_attr($attribute['style']) : 'style-1';
$ev_post_img = '';
$size = 'large';
$ev_post_img = esc_url(ect_pro_get_event_image($event_id, $size));
$ect_cate = ect_display_category($event_id);
$start_date = esc_html(tribe_get_start_date($event_id, false, 'F j'));
$end_date = esc_html(tribe_get_end_date($event_id, false, 'F j'));

if ($style == 'style-4') {
    $events_html .= '
    <div id="event-' . esc_attr($event_id) . '"' .$cat_colors_attr. ' class="ect-slider-event ' . esc_attr($slider_style) . ' ' . esc_attr($event_type) . '" >
        <div class="ect-slider-event-area">
            <div class="ect-slider-image-' . esc_attr($slider_style) . '">
                <a href="' . esc_url(tribe_get_event_link($event_id)) . '">
                <img src="' . esc_url($ev_post_img) . '" title="' . esc_attr(get_the_title($event_id)) . '" alt="' . esc_attr(get_the_title($event_id)) . '">
                </a>';
    $events_html .= '<div class="ect-date-schedule"><div class="ect-date-schedule-wrap">
            ' . wp_kses_post($event_schedule) . '</div></div>';
    if ($socialshare == 'yes') {
        $events_html .= '<div class="ect-share-wrapper-' . esc_attr($slider_style) . '">' . ect_pro_share_button($event_id);
        $events_html .= '</div>';
    }
    $events_html .= '</div>';
    if (!empty($ect_cate)) {
        $events_html .= '<div class="ect-event-category ect-slider-categories">';
        $events_html .= wp_kses_post($ect_cate);
        $events_html .= '</div>';
    }
    $events_html .= '<div class="ect-slider-title"><h4>' . $event_title . '</h4></div>';
    if (tribe_has_venue($event_id) && $attribute['hide-venue'] != 'yes') {
        $events_html .= '<div class="ect-slider-venue">' . wp_kses_post($venue_details_html) . '</div>';
    }
    if ($show_description == 'yes') {
        $events_html .= '<div class="ect-slider-description">
                ' . wp_kses_post($event_content) . '</div>';
    }
    if (tribe_get_cost($event_id, true)) {
        $events_html .= '<div class="ect-slider-cost">' . $ev_cost . '</div>
                            <div class="ect-slider-readmore">
                            <a href="' . esc_url(tribe_get_event_link($event_id)) . '" title="' . esc_attr(get_the_title($event_id)) . '" rel="bookmark">' . esc_html($events_more_info_text) . '</a>
                            </div>';
    } else {
        $events_html .= '<div class="ect-slider-readmore full-view">
                            <a href="' . esc_url(tribe_get_event_link($event_id)) . '" title="' . esc_attr(get_the_title($event_id)) . '" rel="bookmark">' . esc_html($events_more_info_text) . '</a>
                            </div>';
    }
    $events_html .= '</div></div>';
} else {
    $events_html .= '<div id="event-' . esc_attr($event_id) . '"' .$cat_colors_attr. ' class="ect-slider-event ' . esc_attr($slider_style) . ' ' . esc_attr($event_type) . '" >
    <div class="ect-slider-event-area">
    ';
    $events_html .= '<div class="ect-slider-right ect-slider-image">
    <a href="' . esc_url(tribe_get_event_link($event_id)) . '">
    <img src="' . esc_url($ev_post_img) . '" title="' . esc_attr(get_the_title($event_id)) . '" alt="' . esc_attr(get_the_title($event_id)) . '">
    </a>';
    if ($style == 'style-1' || $style == 'style-2') {
        if ($socialshare == 'yes') {
            $events_html .= ect_pro_share_button($event_id);
        }
    }
    $events_html .= '</div>';
    $events_html .= '<div class="ect-slider-left">';
    if ($style == 'style-1') {
        if (!empty($ect_cate)) {
            $events_html .= '<div class="ect-event-category ect-slider-categories">';
            $events_html .= wp_kses_post($ect_cate);
            $events_html .= '</div>';
        }
    }
    if ($style == 'style-2' || $style == 'style-3') {
        $events_html .= '<div class="ect-slider-datearea">
        <div class="ect-slider-date">
    ' . wp_kses_post($event_schedule) . '
    </div>';
        $events_html .= '<div class="ect-slider-date-full">
                            ' . esc_html($start_date) . ' - ' . esc_html($end_date) . '
                        </div></div>';
    }
    if ($style == 'style-3') {
        if ($socialshare == 'yes') {
            $events_html .= ect_pro_share_button($event_id);
        }
    }
    $events_html .= '<div class="ect-slider-title"><h4>' . $event_title . '</h4></div>';
    if ($style == 'style-2') {
        if (!empty($ect_cate)) {
            $events_html .= '<div class="ect-event-category ect-slider-categories">';
            $events_html .= wp_kses_post($ect_cate);
            $events_html .= '</div>';
        }
    }
    if ($style == 'style-1') {
        $events_html .= '<div class="ect-slider-date">
    ' . wp_kses_post($event_schedule) . '
    </div>';
    }
    if ($show_description == 'yes') {
        $events_html .= '<div class="ect-slider-description">
                ' . wp_kses_post($event_content) . '</div>';
    }
    if (tribe_has_venue($event_id) && $attribute['hide-venue'] != 'yes') {
        $events_html .= '<div class="ect-slider-venue">' . wp_kses_post($venue_details_html) . '</div>';
    }
    if ($style == 'style-3') {
        if (!empty($ect_cate)) {
            $events_html .= '<div class="ect-event-category ect-slider-categories">';
            $events_html .= wp_kses_post($ect_cate);
            $events_html .= '</div>';
        }
    }
    if (tribe_get_cost($event_id, true)) {
        $events_html .= '<div class="ect-slider-cost">' . $ev_cost . '</div>';
    }
    $events_html .= '<div class="ect-slider-readmore">
    <a href="' . esc_url(tribe_get_event_link($event_id)) . '" title="' . esc_attr(get_the_title($event_id)) . '" rel="bookmark">' . esc_html($events_more_info_text) . '</a>
    </div></div>';
    $events_html .= '</div></div>';
}

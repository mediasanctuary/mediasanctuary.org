<?php
if (!defined('ABSPATH')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}
/**
 * This file is used to  generate carousel layout  html.
 */

$carousel_style = isset($attribute['style']) ? esc_attr($attribute['style']) : 'style-1';
$style = isset($attribute['style']) ? esc_attr($attribute['style']) : 'style-1';
if ($style == '') {$style = 'style-1';}
if ($carousel_style == '') {$carousel_style = 'style-1';}
$ev_post_img = '';
if (isset($attribute['columns']) && $attribute['columns'] > 2) {
    $size = 'medium';
} else {
    $size = 'large';
}
$ev_post_img = esc_url(ect_pro_get_event_image($event_id, $size = 'large'));
$ect_cate = ect_display_category($event_id);
$events_cats = '<div class="ect-event-category ect-carousel-categories">' . $ect_cate . '</div>';
/*
 * carousel view style-1
 */

if ($style == 'style-4') {
    $events_html .= '
    <div id="event-' . esc_attr($event_id) . '"' .$cat_colors_attr. ' class="ect-carousel-event ' . esc_attr($carousel_style) . ' ' . esc_attr($event_type) . ' ' . esc_attr($evt_type) . '" >
        <div class="ect-carousel-event-area">
            <div class="ect-carousel-image-' . esc_attr($carousel_style) . '">
                <a href="' . esc_url(tribe_get_event_link($event_id)) . '">
                <img src="' . esc_url($ev_post_img) . '" title="' . esc_attr(get_the_title($event_id)) . '" alt="' . esc_attr(get_the_title($event_id)) . '">
                </a>';
    $events_html .= '<div class="ect-date-schedule"><div class="ect-date-schedule-wrap">
            ' . esc_html($event_schedule) . '</div></div>';
    if ($socialshare == "yes") {
        $events_html .= '<div class="ect-share-wrapper-' . esc_attr($carousel_style) . '">' . ect_pro_share_button($event_id);
        $events_html .= '</div>';
    }
    $events_html .= '</div>';
    if (!empty($ect_cate)) {
        $events_html .= '<div class="ect-event-category ect-carousel-categories">';
        $events_html .= $ect_cate;
        $events_html .= '</div>';
    }
    $events_html .= '<div class="ect-carousel-title"><h4>' . wp_kses_post($event_title) . '</h4></div>';
    if (tribe_has_venue($event_id) && $attribute['hide-venue'] != "yes") {
        $events_html .= '<div class="ect-carousel-venue">' . wp_kses_post($venue_details_html) . '</div>';
    } else {
        $events_html .= '';
    }
    // check out
    if ($show_description == "yes") {
        $events_html .= '<div class="ect-carousel-description">
                ' . wp_kses_post($event_content) . '</div>';
    }
    if (tribe_get_cost($event_id, true)) {
        $events_html .= '<div class="ect-carousel-cost">' . $ev_cost . '</div>
                            <div class="ect-carousel-readmore">
                            <a href="' . esc_url(tribe_get_event_link($event_id)) . '" title="' . esc_attr(get_the_title($event_id)) . '" rel="bookmark">' . esc_html($events_more_info_text) . '</a>
                            </div>';
    } else {
        $events_html .= '<div class="ect-carousel-readmore full-view">
                            <a href="' . esc_url(tribe_get_event_link($event_id)) . '" title="' . esc_attr(get_the_title($event_id)) . '" rel="bookmark">' . esc_html($events_more_info_text) . '</a>
                            </div>';
    }
    $events_html .= '</div></div>';
} else {
    $events_html .= '
    <div id="event-' . esc_attr($event_id) . '"' .$cat_colors_attr. ' class="ect-carousel-event ' . esc_attr($carousel_style) . ' ' . esc_attr($event_type) . ' ' . esc_attr($evt_type) . '" >
        <div class="ect-carousel-event-area">

            <div class="ect-carousel-image">
                <a href="' . esc_url(tribe_get_event_link($event_id)) . '">';
    $events_html .= '<img src="' . esc_url($ev_post_img) . '" title="' . esc_attr(get_the_title($event_id)) . '" alt="' . esc_attr(get_the_title($event_id)) . '">
                </a>';
    if ($style == 'style-3') {
        $events_html .= '<div class="ect-carousel-date">' . wp_kses_post($event_schedule) . '</div>';

    }
    if ($socialshare == "yes") {$events_html .= ect_pro_share_button($event_id);}
    $events_html .= '</div>';
    if ($style == 'style-1' || $style == 'style-2') {
        $events_html .= '<div class="ect-carousel-date">' . wp_kses_post($event_schedule) . '</div>';
    }
    $events_html .= '<div class="ect-carousel-content-wrapper">';
    if ($style == 'style-3' || $style == 'style-1' && !empty($ect_cate)) {
        $events_html .= $events_cats;
    }
    $events_html .= '<div class="ect-carousel-title"><h4>' . wp_kses_post($event_title) . '</h4></div>';
    if (($style == 'style-2') && !empty($ect_cate)) {
        $events_html .= $events_cats;
    }
    if ($style == 'style-1') {
        if (tribe_has_venue($event_id) && $attribute['hide-venue'] != "yes") {
            $events_html .= '<div class="ect-carousel-venue">' . wp_kses_post($venue_details_html) . '</div>';
        }
    }
    if ($show_description == "yes") {
        $events_html .= '<div class="ect-carousel-description">
                ' . wp_kses_post($event_content) . '</div>';
    }
    if (($style !== 'style-1')) {
        if (tribe_has_venue($event_id) && $attribute['hide-venue'] != "yes") {
            $events_html .= '<div class="ect-carousel-venue">' . wp_kses_post($venue_details_html) . '</div>';
        }
    }
    if ($style == 'style-3') {
        $events_html .= '</div><div class="ect-carousel-footer">';
    }
    if (tribe_get_cost($event_id, true)) {
        $events_html .= '<div class="ect-carousel-cost">' . $ev_cost . '</div>
                            <div class="ect-carousel-readmore">
                            <a href="' . esc_url(tribe_get_event_link($event_id)) . '" title="' . esc_attr(get_the_title($event_id)) . '" rel="bookmark">' . esc_html($events_more_info_text) . '</a>
                            </div>';
    } else {
        $events_html .= '<div class="ect-carousel-readmore full-view">
                            <a href="' . esc_url(tribe_get_event_link($event_id)) . '" title="' . esc_attr(get_the_title($event_id)) . '" rel="bookmark">' . esc_html($events_more_info_text) . '</a>
                            </div>';
    }
    $events_html .= '</div></div></div>';
}

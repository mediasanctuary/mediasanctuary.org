<?php
if (!defined('ABSPATH')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}
/**
 * This file is used to generate minimal list layout html.
 */
/**
 * Get event status from The Events Calendar Extension: Events Control
 */
if (class_exists('Tribe\Events\Event_Status\Event_Status_Provider')) {
    $online_url = '';
    $get_status = get_post_meta($event_id, '_tribe_events_status', true);
    $status = !empty($get_status) ? esc_html($get_status) : 'scheduled';
    if ($status == 'canceled' || $status == 'postponed') {
        $reason = esc_html(get_post_meta($event_id, '_tribe_events_status_reason', true));
    } else {
        $reason = '';
    }
    $online = tribe_is_truthy(get_post_meta($event_id, '_tribe_events_control_online', true));
    if ($online) {
        $online_url = esc_url(get_post_meta($event_id, '_tribe_events_control_online_url', true));
    }
} else {
    $status = '';
}
$event_cost_div = '';
if (tribe_get_cost($event_id, true)) {
    $event_cost_div = '<div class="ect-minimal-cost">' . wp_kses_post($ev_cost) . '</div>';
}
$ev_post_img = esc_url(ect_pro_get_event_image($event_id, $size = 'large'));
$ev_day = esc_html(tribe_get_start_date($event_id, false, 'd'));
$ev_month = esc_html(tribe_get_start_date($event_id, false, 'M'));
if($style == 'style-1' || $style == 'style-2' || $style == 'style-3'){
$events_html .= '<div id="event-' . esc_attr($event_id) . '" class="ect-list-posts ' . esc_attr($list_style) . ' ' . esc_attr($event_type) . '">';

$events_html .= '<div class="ect-event-date-tag">
<div class="ect-event-datetimes">';
if ($list_style !== "style-2") {
    $events_html .= '<span class="ev-day">' . esc_html($ev_day) . '</span>
	<span class="ev-mo">' . esc_html($ev_month) . '</span>';
} else {
    $events_html .= '<span class="ev-mo">' . esc_html($ev_month) . '</span>
	<span class="ev-day">' . esc_html($ev_day) . '</span>';
}
$events_html .= '</div>
</div>';
$events_html .= '<div class="ect-event-details">';

if ($list_style == "style-3") {
    $events_html .= '<div class="ect-event-datetime"><i class="ect-icon-clock"></i>
	<span class="ect-minimal-list-time">' . esc_html($ev_time) . '</span></div>';
}
if ($status != '') {
    $events_html .= '<div class="ect-events-title"><div>' . $event_title . '</div>';
    $events_html .= '<div class="ect-tool-tip-wrapper ect-labels-wrap"><span class="ect-labels-' . esc_attr($status) . '">' . esc_html($status) . '</span>';
    if ($reason != '' || $online_url != '') {
        $events_html .= '<div class="ect-tip-inr">';
        if (!empty($reason)) {
            $events_html .= '<span class="ect-reason">' . esc_html($reason) . '</span>';
        }
        if (!empty($online_url)) {
            $events_html .= '<span class="ect-online-url">' . __('Live stream:-', 'epta') . '<a href="' . esc_url($online_url) . '" target="_blank">' . __('Watch Now', 'ect') . '</a></span>';
        }
        $events_html .= '</div>';
    }
    $events_html .= '</div></div>';
} else {
    $events_html .= '<div class="ect-events-title">' . $event_title . '</div>';
}
if ($list_style == "style-1") {
    $events_html .= '<div class="ect-event-datetime"><i class="ect-icon-clock"></i>
	<span class="ect-minimal-list-time">' . esc_html($ev_time) . '</span></div>';
}
if ($list_style == "style-2") {
    if($hide_venue == 'no'){
        if (tribe_has_venue($event_id)) {
            $events_html .= wp_kses_post($venue_details_html1);
        }
    }
}
$events_html .= '</div></div>';
} else {
    if($style == 'style-4'){
        $events_html .= '<div id="event-' . esc_attr($event_id) . '" class="ect-minimal-list-post ' . esc_attr($list_style) . ' ' . esc_attr($event_type) . '">';
        $events_html .= '<div class="ect-minimal-left-wrapper">
                            <div class="ect-event-date-tag">
                                    <div class="ect-event-datetimes">
                                        <span class="ev-day">' . esc_html($ev_day) . '</span>
                                        <span class="ev-mo">' . esc_html($ev_month) . '</span>
                                    </div>
                            </div>
                                    <div class="ect-event-img">
                                        <a href="' . esc_url(tribe_get_event_link($event_id)) . '"><img src="' . esc_url($ev_post_img) . '" alt="' . esc_attr(get_the_title($event_id)) . '"></a>
                                    </div>
                        </div>
            <div class="ect-minimal-right-wrapper">
            <div class="ect-event-content">
            <div class="ect-event-schedule">
                <i class="ect-icon-clock"></i>
                <span class="ect-minimal-list-time">' . esc_html($ev_time) . '</span>
            </div>
            <div class="ect-events-title"><h4>' . wp_kses_post($event_title) . '</h4></div>
        </div>';
    
        $events_html .= '<div class="ect-event-readmore-cost">';
                    if(!empty($event_cost_div)){
        $events_html .= '<div class="ect-rate-area">
                            ' . $event_cost_div . '
                        </div>';
                         }
        $events_html .= '<div class="ect-readmore">
                <a href="' . esc_url(tribe_get_event_link($event_id)) . '" class="ect-events-read-more" rel="bookmark">' . esc_html($events_more_info_text) . '</a>
            </div>
        </div>';
    
        $events_html .= '</div></div>';
    }
}

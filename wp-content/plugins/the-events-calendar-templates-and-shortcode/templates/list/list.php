<?php
if (!defined('ABSPATH')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}
/**
 * This file is used to  generate list layout  html.
 */

$ev_time = esc_html(ect_tribe_event_time($event_id, false));
$list_style = esc_attr($style);
if ($template == 'modern-list') {
    $list_style = 'style-2';
} elseif ($template == 'classic-list') {
    $list_style = 'style-3';
}
$ev_post_img = '';
$event_cost_div = '';
$size = 'medium';
$ev_post_img = esc_url(ect_pro_get_event_image($event_id, $size = 'large'));
$ect_cate = ect_display_category($event_id);
$event_month = tribe_get_start_date( $event_id, false, 'M' );
$event_day = tribe_get_start_date( $event_id, true, 'd' );
$event_venue = tribe_get_venue_details( $event_id ); 
if (tribe_get_cost($event_id, true)) {
    $event_cost_div = '<div class="ect-list-cost">' . wp_kses_post($ev_cost) . '</div>';
}
$isStyleTemplateCombo1 = ($style == 'style-2' || $style == 'style-3') && $template == 'default';
$isTemplateCombo2 = $template == 'modern-list' || $template == 'classic-list';
if ($isStyleTemplateCombo1 || $isTemplateCombo2) {
    $bg_styles = "background-image:url('" . esc_url($ev_post_img) . "');background-size:cover;background-position:bottom center;";
} else {
    $bg_styles = "background-image:url('" . esc_url($ev_post_img) . "');background-size:cover;";
}
if($style == 'style-1' || $style == 'style-2' || $style == 'style-3'){
$events_html .= '
	<div id="event-' . esc_attr($event_id) . '" ' .$cat_colors_attr. ' class="ect-list-post ' . esc_attr($list_style) . ' ' . esc_attr($event_type) . '" >
		<div class="ect-list-post-left ">
			<div class="ect-list-img" style="' . esc_attr($bg_styles) . '">';
if ($style != 'style-2') {
    $events_html .= '<a href="' . esc_url(tribe_get_event_link($event_id)) . '" alt="' . esc_attr(get_the_title($event_id)) . '" rel="bookmark">
					<div class="ect-list-date">' . wp_kses_post($event_schedule) . '</div>
				</a>';
}
$events_html .= '</div>';
if ($style == 'style-1' || $style == 'style-2') {
    if ($socialshare == 'yes') {
        $events_html .= ect_pro_share_button($event_id);
    }
}
$events_html .= '</div><!-- left-post close -->
		<div class="ect-list-post-right">
			<div class="ect-list-post-right-table">';
if ($style == 'style-1') {
    if ($hide_venue != 'yes') {
        if (tribe_has_venue($event_id)) {
            $events_html .= '<div class="ect-list-description">';
        } else {
            $events_html .= '<div class="ect-list-description" style="width:100%;">';
        }
    } else {
        $events_html .= '<div class="ect-list-description" style="width:100%;">';
    }
} else {
    $events_html .= '<div class="ect-list-description">';
}
if (!empty($ect_cate)) {
    $events_html .= '<div class="ect-event-category ect-list-category">';
    $events_html .= wp_kses_post($ect_cate);
    $events_html .= '</div>';
}
$events_html .= '<h2 class="ect-list-title">' . wp_kses_post($event_title) . '</h2>';
if ($style == 'style-3') {
    $events_html .= '<div class="ect-clslist-time">
					<span class="ect-icon"><i class="ect-icon-clock"></i></span>
					<span class="cls-list-time">' . esc_html($ev_time) . '</span>
					</div>';
    if (tribe_has_venue($event_id)) {
        $events_html .= wp_kses_post($venue_details_html);
    }
}
if ($show_description == 'yes' || $show_description == '') {
    $events_html .= wp_kses_post($event_content);
}
$events_html .= $event_cost_div . '<a href="' . esc_url(tribe_get_event_link($event_id)) . '" class="ect-events-read-more" rel="bookmark">' . esc_html($events_more_info_text) . '</a>';

$events_html .= '</div>';
if ($style == 'style-3') {
    $events_html .= '</div></div>';
    if ($socialshare == 'yes') {
        $events_html .= '<div class="ect-clslist-event-details">';
        $events_html .= ect_pro_share_button($event_id);
        $events_html .= '</div>';
    }
}
if ($style == 'style-2') {
    $events_html .= '<div class="modern-list-right-side" >
			<div class="ect-list-date">' . wp_kses_post($event_schedule) . '</div>';
}
if ($style == 'style-1' || $style == 'style-2') {
    if (tribe_has_venue($event_id)) {
        $events_html .= wp_kses_post($venue_details_html);
    }
}
if ($style == 'style-2') {
    $events_html .= '	</div>';
}
$events_html .= '</div>';
if ($style != 'style-3') {
    $events_html .= '</div><!-- right-wrapper close -->
	</div><!-- event-loop-end -->';
}
} else {
        if ($style == 'style-4') {
            $ect_cate = ect_display_category($event_id);
            $events_html .= '<div id="event-' . esc_attr($event_id) . '" ' .$cat_colors_attr. ' class="ect-list-post ' . esc_attr($list_style) . ' ' . esc_attr($event_type) . '" >
                <div class="ect-list-post-left">
                    <div class="ect-list-img">
                    <a href="' . esc_url(tribe_get_event_link($event_id)) . '"><img src="' . esc_url($ev_post_img) . '" alt="' . esc_attr(get_the_title($event_id)) . '"></a>
                    </div>
                    <div class="ect-date-highlight">
                        <div class="ect-date-area">
                            <span class="ev-day">' . $event_day . '</span>
                            <span class="ev-mo">' .  $event_month  . '</span>
                        </div>
                    </div>
                </div>
                <div class="ect-list-post-right">';
                if ($socialshare == 'yes') {
                    $events_html .= ect_pro_share_button($event_id);
                }
            $events_html .= '<div class="ect-category-time">';
                        if (!empty($ect_cate)) {
                            $events_html .= '<div class="ect-event-category ect-list-category">';
                            $events_html .= wp_kses_post($ect_cate);
                            $events_html .= '</div>';
                        }
                    $events_html .= '</div>';
                    $events_html .= '<div class="ect-event-schedule"><i aria-hidden="true" class="ect-icon-calendar"></i>' . wp_kses_post($event_schedule) . '</div>
                    <h2 class="ect-list-title">' . wp_kses_post($event_title) . '</h2>'; 
                    if ($show_description == 'yes' || $show_description == '') {
                        $events_html .= wp_kses_post($event_content);
                    } 
                        // Check if venue exists and display its details
                        if (tribe_has_venue($event_id) && isset($event_venue['linked_name'])) {
                            if($hide_venue == 'no'){
                                    $events_html .= '<div class="ect-list-venue-style-4">';
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
            $events_html .='<div class="ect-readmore-cost">
                        <span class="ect-readmore"><a href="' . esc_url(tribe_get_event_link($event_id)) . '" class="ect-events-read-more" rel="bookmark">' . esc_html($events_more_info_text) . '</a></span>
                        <div class="ect-rate-area">
                            <span class="ect-rate">' . $event_cost_div . '</span>
                        </div>
                    </div>
                </div>
            </div>';
        }
}
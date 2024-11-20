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
                <div class="ect-accordion-date">' . ($event_schedule) . '</div>
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
    if ($ect_compare != $events_date_header && $count > 0) {

        $events_html .= '</div><!--close div!-->';
        $ect_compare = $events_date_header;
    }

    if ($events_date_header !== '') {

        $events_html .= '<div class="ect-accordion-event-year ect-accordion-view"><!--open year div!-->' . esc_html($events_date_header);
        $count++;
    }

    $events_html .= '
    <div id="ect-accordion-event-' . esc_attr($event_id) . '" class="ect-accordion-event ' . esc_attr($style) . ' ' . esc_attr($event_type) . '">
        <div class="ect-accordion-header">
            <div class="ect-accordion-header-left">
                <div class="ect-accordion-date">' . ($event_schedule) . '</div>
            </div>
            <div class="ect-accordion-header-right">
                ' . $event_title;
    if (!empty($ect_cate)) {
        $events_html .= '<div class="ect-event-category ect-accordion-categories">';
        $events_html .= $ect_cate;
        $events_html .= '</div>';
    }
    if (tribe_has_venue($event_id)) {
        $events_html .= '<div class="ect-accordion-venue">' . $venue_details_html . '</div>';
    }
    if ($socialshare == 'yes') {
        $events_html .= ect_pro_share_button($event_id);
    }
    $events_html .= '</div>
        </div>

        <div class="ect-accordion-footer">
            <div class="ect-accordion-image">
                <img src="' . esc_url($ev_post_img) . '" title="' . esc_attr(get_the_title($event_id)) . '" alt="' . esc_attr(get_the_title($event_id)) . '">';
    if (tribe_get_cost($event_id, true)) {
        $events_html .= '<div class="ect-accordion-image-top">
                    <div class="ect-accordion-cost">' . $ev_cost . '</div>
                    <div class="ect-accordion-date-full">
                        ' . esc_html($start_date) . ' - ' . esc_html($end_date) . '
                    </div>
                    </div>';
    } else {
        $events_html .= '<div class="ect-accordion-image-top">
                    <div class="ect-accordion-date-full">
                        ' . esc_html($start_date) . ' - ' . esc_html($end_date) . '
                    </div>
                    </div>';
    }
    $events_html .= '</div>
            <div class="ect-accordion-map">
                ' . $map . '
            </div>
            <div class="ect-accordion-content">
                ' . $event_content . '
            </div>
        </div>
    </div>';
}
/*---Accordion STYLE 4 END---*/

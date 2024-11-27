<?php
if (!defined('ABSPATH')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}
/**
 * This file is used only for dynamic styles in minimal layouts.
 */
// Silence is golden.
switch ($style) {
    case "style-1":
        // Minimal List Featured Skin Color
        $ect_output_css .= '#ect-minimal-list-wrp .ect-list-posts.style-1.ect-featured-event{
            border: 1px solid ' . esc_attr($featured_event_skin_color) . ';
        }
        #ect-minimal-list-wrp .ect-list-posts.style-1.ect-simple-event{
            border: 1px solid ' . esc_attr($main_skin_color) . ';
        }
        .ect-minimal-list-wrapper .ect-list-posts.style-1.ect-featured-event{
        }
        ';
        $ect_output_css .= '.ect-list-posts.style-1.ect-featured-event .ect-event-date-tag{
            color: ' . esc_attr($featured_event_skin_color) . ';
        }
        .ect-list-posts.style-1.ect-simple-event .ect-event-date-tag{
            color: ' . esc_attr($main_skin_color) . ';
        }';
        // Title styles in minimal layouts
        $ect_output_css .= '#ect-minimal-list-wrp .style-1 .ect-events-title a{
            ' . $title_styles . '
        }#ect-minimal-list-wrp .style-1 .ect-style-1-more a,#ect-minimal-list-wrp .style-1 .ect-read-more a{
            color: ' . esc_attr(Ecttinycolor($ect_title_color)->lighten(10)->toString()) . ';
        }';
        $ect_output_css .= ' #ect-minimal-list-wrp .ect-list-posts.style-1 .ect-event-datetimes span,
        #ect-minimal-list-wrp .style-1 span.ect-minimal-list-time{
            font-family: ' . $ect_date_font_family . ';
            font-style:' . esc_attr($ect_date_font_style) . ';
            line-height:' . esc_attr($ect_date_line_height) . ';
        }
        #ect-minimal-list-wrp .style-1 .ect-event-datetime{
            color: ' . esc_attr(Ecttinycolor($ect_title_color)->lighten(10)->toString()) . ';
        }
        ';
        break;
    case "style-2":
        $ect_output_css .= '#ect-minimal-list-wrp .style-2 span.ect-event-title a{
            ' . $title_styles . '
        }
        #ect-minimal-list-wrp .style-2 .ect-style-2-more a{
            color: ' . esc_attr(Ecttinycolor($ect_title_color)->lighten(10)->toString()) . ';
        }';
        $ect_output_css .= '.ect-list-posts.style-2.ect-featured-event .ect-event-date-tag{
            color: ' . esc_attr($featured_event_skin_color) . ';
        }
        .ect-list-posts.style-2.ect-simple-event .ect-event-date-tag{
            color: ' . esc_attr($main_skin_color) . ';
        }';
        $ect_output_css .= '.ect-list-posts.style-2 .ect-events-title a.ect-event-url,
        #ect-minimal-list-wrp .style-2 span.ect-event-title a{
            ' . $title_styles . '
        }#ect-minimal-list-wrp .style-2 .ect-style-2-more a{
            color: ' . esc_attr(Ecttinycolor($ect_title_color)->lighten(10)->toString()) . ';
        }
        #ect-minimal-list-wrp .style-2.ect-simple-event span.ect-date-viewport,
        #ect-minimal-list-wrp .style-2.ect-simple-event .ect-schedule-wrp
        {
            font-family:' . $ect_date_font_family . ';
        }
        ';
        $ect_output_css .= '#ect-minimal-list-wrp .style-2 .minimal-list-venue span,
        #ect-minimal-list-wrp .style-2 span.ect-google a {
            ' . $ect_venue_styles . '
        }';
        break;
    case "style-3":
        $ect_output_css .= '#ect-minimal-list-wrp .ect-list-posts.style-3.ect-simple-event{
            border-left-color: ' . esc_attr(Ecttinycolor($main_skin_color)->lighten(2)->toString()) . ';
        }';
        $ect_output_css .= '#ect-minimal-list-wrp .ect-list-posts.style-3.ect-featured-event{
            border-left: 4px solid ' . esc_attr($featured_event_skin_color) . ';
        }';
        $ect_output_css .= '#ect-minimal-list-wrp .ect-list-posts.style-3.ect-simple-event{
            border-left: 4px solid ' . esc_attr($main_skin_color) . ';
        }';
        $ect_output_css .= '#ect-minimal-list-wrp .ect-list-posts.style-3.ect-featured-event .ect-event-date-tag{
            background: ' . esc_attr(Ecttinycolor($featured_event_skin_color)->lighten(20)->toString()) . ';
        }';
        $ect_output_css .= '#ect-minimal-list-wrp .ect-list-posts.style-3.ect-simple-event .ect-event-date-tag{
            background: ' . esc_attr(Ecttinycolor($main_skin_color)->lighten(17)->toString()) . ';
        }';
        $ect_output_css .= '#ect-minimal-list-wrp .style-3 .ect-events-title a{
            ' . $title_styles . '
        }#ect-minimal-list-wrp .style-3 .ect-rate-area{
            color: ' . esc_attr(Ecttinycolor($ect_title_color)->lighten(10)->toString()) . ';
        }';
        $ect_output_css .= '#ect-minimal-list-wrp .style-3 .ect-style-3-more a{
            color:' . esc_attr($ect_date_color) . ';
        }
        #ect-minimal-list-wrp .style-3 .ect-event-datetime{
            font-family: ' . $ect_date_font_family . ';
            color: ' . esc_attr(Ecttinycolor($ect_title_color)->lighten(10)->toString()) . ';
            font-style:' . esc_attr($ect_date_font_style) . ';
            line-height:' . esc_attr($ect_date_line_height) . ';
        }
        ';
        break;
}

$ect_output_css .= '
#ect-minimal-list-wrp .style-3 .ect-event-datetimes span.ev-mo,
#ect-minimal-list-wrp .style-3 .ect-event-datetimes{
    color:' . esc_attr($ect_date_color) . ';
}
#ect-minimal-list-wrp .ect-share-wrapper .ect-social-share-list a{
    color: ' . esc_attr($main_skin_color) . ';
}
#ect-minimal-list-wrp .ect-share-wrapper i.ect-icon-share:before {
    background: ' . esc_attr($main_skin_color) . ';
}
';

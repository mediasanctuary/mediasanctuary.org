<?php
if (!defined('ABSPATH')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}
/**
 * This file is used only for dynamic styles in list layouts.
 */

if($style === "style-1" || $style === "style-3"){

     $ect_output_css .= '.ect-show-events .ect-simple-event .ect-highlighted-accordion.active .ect-highlighted-date.ect-selected {
          background-color: '. $main_skin_color. ';
          color: '.$main_skin_alternate_color.';
          }
          .ect-show-events .ect-featured-event .ect-highlighted-accordion.active .ect-highlighted-date.ect-selected {
                    background-color: '. $featured_event_skin_color .';
                    color: '.$featured_event_font_color.';
          }';
     $ect_output_css .= '.ect-show-events .ect-simple-event.style-1 .ect-highlighted-date,
               .ect-show-events .ect-simple-event.style-3 .ect-highlighted-date {
               background-color: '. $ect_title_color .';
          }
          .ect-show-events .ect-featured-event.style-1 .ect-highlighted-date,
          .ect-show-events .ect-featured-event.style-3 .ect-highlighted-date {
               background-color: '. $ect_title_color .';
          }';
   

     
}elseif($style === "style-2") {
     $ect_output_css .= '.ect-show-events .ect-simple-event .ect-highlighted-accordion.active .ect-calendar.ect-selected {
          background-color: '. $main_skin_color. ';
          }
          .ect-show-events .ect-featured-event .ect-highlighted-accordion.active .ect-calendar.ect-selected {
                    background-color: '. $featured_event_skin_color .';
          }';
     $ect_output_css .= '.ect-show-events .ect-simple-event .ect-calendar {
               background-color: '. $ect_title_color .';
          }
          .ect-show-events .ect-featured-event .ect-calendar {
               background-color: '. $ect_title_color .';
          }';
     $ect_output_css .= '.ect-show-events .ect-simple-event .ect-highlighted-accordion .ect-highlighted-date .ect-date-area {
               background-color: '. $main_skin_color. ';
               color:  '.$main_skin_alternate_color.';
          }
          .ect-show-events .ect-featured-event .ect-highlighted-accordion .ect-highlighted-date .ect-date-area {
               background-color: '. $featured_event_skin_color .';
                color:  '.$featured_event_font_color.';
          }';
     $ect_output_css .= '
          .ect-highlighted-wrapper.style-2 .ect-calendar{
               color : '. $ect_date_color .';
          }
          .ect-highlighted-wrapper.style-2 .ect-featured-event .ect-calendar.ect-selected{
               color : ' . $featured_event_font_color . ';
          }
          .ect-highlighted-wrapper.style-2 .ect-simple-event .ect-calendar.ect-selected{
               color : ' . $main_skin_alternate_color . ';
          }
          
     ';

} else {
     if($style === "style-4"){
          $ect_output_css .= '.ect-show-events .ect-simple-event .ect-highlighted-accordion.active .ect-calendar.ect-selected {
               background-color: '. $main_skin_color. ';
               }
               .ect-show-events .ect-featured-event .ect-highlighted-accordion.active .ect-calendar.ect-selected {
                         background-color: '. $featured_event_skin_color .';
               }';
          $ect_output_css .= '.ect-show-events .ect-simple-event .ect-calendar {
                    background-color: '. $ect_title_color .';
               }
               .ect-show-events .ect-featured-event .ect-calendar {
                    background-color: '. $ect_title_color .';
               }';
          $ect_output_css .= '.ect-highlighted-wrapper.style-4 .ect-show-events .ect-simple-event .ect-highlighted-accordion .ect-highlighted-date{
                    background-color: '. $main_skin_color. ';
                    color:  '.$main_skin_alternate_color.';
               }
               .ect-highlighted-wrapper.style-4 .ect-show-events .ect-featured-event .ect-highlighted-accordion .ect-highlighted-date{
                    background-color: '. $featured_event_skin_color .';
                     color:  '.$featured_event_font_color.';
               }';
          $ect_output_css .= '
               .ect-highlighted-wrapper.style-4 .ect-calendar{
                    color : '. $ect_date_color .';
               }
               .ect-highlighted-wrapper.style-4 .ect-featured-event .ect-calendar.ect-selected{
                    color : ' . $featured_event_font_color . ';
               }
               .ect-highlighted-wrapper.style-4 .ect-simple-event .ect-calendar.ect-selected{
                    color : ' . $main_skin_alternate_color . ';
               }
               
          ';
     }
}
/*---- Background color -----*/
$ect_output_css .= '.ect-highlighted-wrapper .ect-right{
     background-color : ' . $event_desc_bg_color . ';
}';

/*---- After before color for animation ---- */
$ect_output_css .= '
.ect-highlighted-wrapper .ect-show-events .ect-featured-event .ect-highlighted-accordion.active::before {
    background-color:'. $ect_title_color .';
}
.ect-highlighted-wrapper .ect-show-events .ect-simple-event .ect-highlighted-accordion.active::before {
    background-color: '. $ect_title_color .';
}
.ect-highlighted-wrapper .ect-show-events .ect-featured-event .ect-highlighted-accordion::before {
    background-color: '. $ect_title_color .';
}
.ect-highlighted-wrapper .ect-show-events .ect-simple-event .ect-highlighted-accordion::before {
    background-color: '. $ect_title_color .';
}
.ect-highlighted-wrapper .ect-show-events .ect-simple-event .ect-highlighted-accordion.active::after {
     background-color: '. $main_skin_color. ';
}
.ect-highlighted-wrapper .ect-show-events .ect-featured-event .ect-highlighted-accordion.active::after {
    background-color: '. $featured_event_skin_color .';
}';
/*--- Event Title - CSS ---*/
$ect_output_css .= '.ect-highlighted-wrapper .ect-show-events .ect-event-details .ect-highlighted-title{
     ' . $title_styles . ';
     }';
/*--- Event description - CSS ---*/
$ect_output_css .= '.ect-highlighted-wrapper .ect-show-events .ect-event-details .ect-description,
                    .ect-highlighted-wrapper .ect-show-events .ect-event-details .ect-read-more {
     '. $ect_desc_styles.';
     }';
/*--- Event Venue - CSS ---*/
$ect_output_css .= '.ect-highlighted-wrapper .ect-show-events .ect-event-details .ect-highlighted-venue a,
                    .ect-highlighted-wrapper .ect-show-events .ect-event-details .ect-highlighted-venue .ect-venue-details a,
                    .ect-highlighted-wrapper .ect-show-events .ect-event-details .ect-highlighted-venue,
                    .ect-highlighted-wrapper .ect-show-events .ect-event-details .ect-highlighted-venue .ect-google a{
     '.$ect_venue_styles.';
     }';
/*--- Event Date - CSS ---*/
$ect_output_css .= '.ect-highlighted-wrapper.style-1 .ect-highlighted-date,
                    .ect-highlighted-wrapper.style-3 .ect-highlighted-date {
     color: '.$ect_date_color.';
     }';

// Highlighted layout Category
$ect_output_css .= '
    ul.ect-categories li.ect-active,
    ul.ect-categories li:hover{
         color: ' . esc_attr($main_skin_alternate_color) . ';
    }
    ul.ect-categories li {
         border-color: ' . esc_attr(Ecttinycolor($main_skin_color)->darken(9)->toString()) . ';
         color: ' . esc_attr(Ecttinycolor($main_skin_color)->darken(9)->toString()) . ';
    }
    ul.ect-categories li.ect-active, 
    ul.ect-categories li:hover{
         background-color:' . esc_attr($main_skin_color) . ';
         border-color: ' . esc_attr(Ecttinycolor($main_skin_color)->darken(9)->toString()) . ';
    }';
<?php
if (!defined('ABSPATH')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}
/**
 * This file is used only for dynamic styles in carousel layouts.
 */
switch ($style) {

    /** STYLE-1 */
    case 'style-1':
        /*--- Main Skin Color - CSS ---*/
        $ect_output_css .= '
          #ect-carousel-wrapper .style-1 .ect-carousel-date:after {
               border-color: transparent transparent ' . esc_attr(Ecttinycolor($main_skin_color)->darken(3)->toString()) . ';
          }
          ';

        /*--- Featured Event Color - CSS ---*/
        $ect_output_css .= '
          #ect-carousel-wrapper .ect-featured-event.style-1 .ect-carousel-date:after {
               border-color: transparent transparent ' . esc_attr(Ecttinycolor($featured_event_skin_color)->darken(7)->toString()) . ';
          }
          ';
        $ect_output_css .= '#ect-carousel-wrapper .ect-carousel-event.ect-simple-event.style-1 .ect-carousel-readmore a{
               color: ' . esc_attr($main_skin_color) . ';
               border-color:' . esc_attr($main_skin_color) . ';
          }
          #ect-carousel-wrapper .ect-carousel-event.ect-featured-event.style-1 .ect-carousel-readmore a{
               color: ' . esc_attr($featured_event_skin_color) . ';
               border-color:' . esc_attr($featured_event_skin_color) . ';
          }
          ';
        $ect_output_css .= ' #ect-carousel-wrapper .ect-carousel-event.style-1.ect-featured-event .ect-carousel-readmore a:hover{
               background: ' . esc_attr($featured_event_skin_color) . ';
               color: ' . esc_attr($featured_event_font_color) . ';
          }';

        if ($main_skin_alternate_color === '') {
            $ect_output_css .= ' #ect-carousel-wrapper .ect-carousel-event.style-1.ect-simple-event .ect-carousel-readmore a:hover{
               background: ' . esc_attr($main_skin_color) . ';
               color: ' . esc_attr($ect_date_color) . ';
          }';
        } else {
            $ect_output_css .= ' #ect-carousel-wrapper .ect-carousel-event.style-1.ect-simple-event .ect-carousel-readmore a:hover{
               background: ' . esc_attr($main_skin_color) . ';
               color: ' . esc_attr($main_skin_alternate_color) . ';
          }';
        }

        break;
    /** STYLE-2 */
    case 'style-2':
        $ect_output_css .= '
          #ect-carousel-wrapper .ect-carousel-event.style-2.ect-featured-event .ect-carousel-readmore a{
               background: ' . esc_attr($featured_event_skin_color) . ';
               color: ' . esc_attr($featured_event_font_color) . ';
          }';

        if ($main_skin_alternate_color === '') {
            $ect_output_css .= '
          #ect-carousel-wrapper .ect-carousel-event.style-2.ect-simple-event .ect-carousel-readmore a{
               background: ' . esc_attr($main_skin_color) . ';
               color: ' . esc_attr($ect_date_color) . ';
          }';
        } else {
            $ect_output_css .= '
          #ect-carousel-wrapper .ect-carousel-event.style-2.ect-simple-event .ect-carousel-readmore a{
               background: ' . esc_attr($main_skin_color) . ';
               color: ' . esc_attr($main_skin_alternate_color) . ';
          }';
        }
        break;
    /** STYLE-3 */
    case 'style-3':
        /*--- Main Skin Color - CSS ---*/

        if ($event_desc_bg_color === '#ffffff') {
            $ect_output_css .= '
          #ect-carousel-wrapper .style-3.ect-featured-event .ect-carousel-footer{
               background-color:' . esc_attr(Ecttinycolor($featured_event_skin_color)->lighten(37)->toString()) . ';
               border-top: none;
          }';
            $ect_output_css .= '
          #ect-carousel-wrapper .style-3.ect-simple-event .ect-carousel-footer{
               background-color:' . esc_attr(Ecttinycolor($main_skin_color)->lighten(40)->toString()) . ';
               border-top: none;
          }';
        }
        $ect_output_css .= '  #ect-carousel-wrapper .ect-carousel-event.style-3 .ect-carousel-readmore a{
               color: ' . esc_attr($ect_title_color) . ';
               }   ';

        break;
    default:
                     /*--- Non Featured Event CSS ---*/
     $ect_output_css .= '#ect-carousel-wrapper .ect-carousel-event.style-4 .ect-carousel-image .ect-date-highlight .ect-date-area,
                         #ect-carousel-wrapper .ect-carousel-event.style-4 .ect-readmore-cost .ect-readmore{
                              background: ' . esc_attr($main_skin_color) . ';
                         }';
     $ect_output_css .= '#ect-carousel-wrapper .ect-carousel-event.style-4 .ect-carousel-event-area:hover{
                              background: ' . esc_attr($thisPlugin::ect_hex2rgba($main_skin_color, .20)) . ';
                         }';
     $ect_output_css .= '#ect-carousel-wrapper .ect-carousel-event.style-4 .ect-carousel-image .ect-date-highlight .ect-date-area,
                         #ect-carousel-wrapper .ect-carousel-event.style-4 .ect-readmore-cost .ect-readmore a{
                              color: '. esc_attr($main_skin_alternate_color) .';
                         }';
                      
                       /*--- Featured Event CSS ---*/
     $ect_output_css .= '#ect-carousel-wrapper .ect-carousel-event.style-4.ect-featured-event .ect-carousel-image .ect-date-highlight .ect-date-area,
                         #ect-carousel-wrapper .ect-carousel-event.style-4.ect-featured-event .ect-readmore-cost .ect-readmore{
                              background: ' . esc_attr($featured_event_skin_color) . ';
                         }';
     $ect_output_css .= '#ect-carousel-wrapper .ect-featured-event.style-4.ect-featured-event .ect-carousel-event-area:hover{
                              background: ' . esc_attr($thisPlugin::ect_hex2rgba($featured_event_skin_color, .20)) . ';
                         }';
     $ect_output_css .= '#ect-carousel-wrapper .ect-carousel-event.style-4.ect-featured-event .ect-carousel-image .ect-date-highlight .ect-date-area,
                         #ect-carousel-wrapper .ect-carousel-event.style-4.ect-featured-event .ect-readmore-cost .ect-readmore a{
                              color: ' . esc_attr($featured_event_font_color) . ';
                         }';
                         /*--- Event date - CSS ---*/
                       if ($ect_date_color === '#ffffff') {
                         $ect_output_css .= '
                            #ect-carousel-wrapper .ect-carousel-event.style-4 .ect-carousel-post-content .ect-event-schedule{
                                 color: ' . esc_attr($ect_title_color) . ';
                            }
                            ';
                     } else {
                         $ect_output_css .= '
                            #ect-carousel-wrapper .ect-carousel-event.style-4 .ect-carousel-post-content .ect-event-schedule{
                                 color: ' . esc_attr($ect_date_color) . ';
                            }
                            ';
                     }
        break;
}
/*--- Main Skin Color - CSS ---*/

$ect_output_css .= '
#ect-carousel-wrapper .ect-carousel-date,
#ect-carousel-wrapper .ect-carousel-area span{
     ' . $ect_date_style . ';
}
';
$ect_output_css .= '#ect-carousel-wrapper .ect-carousel-date{
     background: ' . esc_attr($thisPlugin::ect_hex2rgba($main_skin_color, .95)) . ';
}';
if ($main_skin_alternate_color !== '') {
    $ect_output_css .= '
     #ect-carousel-wrapper .ect-carousel-date{
          color: ' . esc_attr($main_skin_alternate_color) . ';
     }
     ';
}
/*--- Featured Event Font Color - CSS ---*/
$ect_output_css .= '

#ect-carousel-wrapper .ect-featured-event .ect-carousel-date{
     color: ' . esc_attr($featured_event_font_color) . ';
     background: ' . esc_attr($thisPlugin::ect_hex2rgba($featured_event_skin_color, .95)) . ';
}
';
/*--- Event Background Color - CSS ---*/
$ect_output_css .= '
#ect-carousel-wrapper .ect-carousel-event-area{
     background: ' . esc_attr($event_desc_bg_color) . ';
}
#ect-carousel-wrapper .ect-events-carousel .slick-arrow i {
     background: ' . esc_attr($event_desc_bg_color) . ';
     box-shadow: 2px 2px 0px 1px ' . esc_attr(Ecttinycolor($event_desc_bg_color)->darken(10)->toString()) . ';
}
';
/*--- Event Title - CSS ---*/
$ect_output_css .= '
#ect-carousel-wrapper .ect-carousel-title h4,
#ect-carousel-wrapper .ect-carousel-title h4 a{
     ' . $title_styles . ';
     font-size:' . esc_attr($ect_title_font_size) . 'px;
}
';
/*--- Event Description - CSS ---*/
$ect_output_css .= '
#ect-carousel-wrapper .ect-carousel-description .ect-event-content p{
     ' . $ect_desc_styles . '
}
#ect-carousel-wrapper .ect-events-carousel .slick-arrow {
     color: ' . esc_attr($ect_desc_color) . ';
}

';
$venue_font_size = $ect_venue_font_size + 6;
/*--- Event Venue Color - CSS ---*/
$ect_output_css .= '
#ect-carousel-wrapper .ect-carousel-venue-style-4 a,
#ect-carousel-wrapper .ect-carousel-venue-style-4,
#ect-carousel-wrapper .ect-carousel-venue{
     ' . $ect_venue_styles . '
}
#ect-carousel-wrapper .ect-carousel-cost,
#ect-carousel-wrapper .ect-carousel-cost .ect-ticket-info span {
     color:' . esc_attr($ect_title_color) . ';
     font-size:' . esc_attr($ect_title_font_size) . 'px;
     font-family:' . $ect_title_font_famiily . ';
}
#ect-carousel-wrapper .ect-carousel-venue a{
	color: ' . esc_attr(Ecttinycolor($ect_venue_color)->darken(6)->toString()) . ';
	font-family: ' . $ect_venue_font_famiily . ';
}
// #ect-carousel-wrapper .ect-carousel-border:before {
// 	background:' . esc_attr(Ecttinycolor($ect_venue_color)->darken(6)->toString()) . ';
// }
';

$ect_output_css .= ' #ect-minimal-list-wrp .ect-share-wrapper .ect-social-share-list a{
     color: ' . esc_attr($main_skin_color) . ';
}
#ect-minimal-list-wrp .ect-share-wrapper i.ect-icon-share:before {
     background: ' . esc_attr($main_skin_color) . ';
}';

/**------------------------------------Share css------------------------------ */
$ect_output_css .= ' .ect-carousel-event.ect-featured-event .ect-share-wrapper .ect-social-share-list a:hover{
        color: ' . esc_attr($featured_event_skin_color) . ';
    }
    .ect-carousel-event.ect-simple-event .ect-share-wrapper .ect-social-share-list a:hover{
        color: ' . esc_attr($main_skin_color) . ';
    }';
$ect_output_css .= '
    #ect-carousel-wrapper .ect-featured-event .ect-share-wrapper i.ect-icon-share:before,
    #ect-carousel-wrapper .ect-featured-event .ect-share-wrapper i.ect-icon-share:before{
         background: ' . esc_attr($featured_event_font_color) . ';
         color: ' . esc_attr($featured_event_skin_color) . ';
    }';

if ($main_skin_alternate_color === '') {
    $ect_output_css .= '  #ect-carousel-wrapper .ect-simple-event .ect-share-wrapper i.ect-icon-share:before,
         #ect-carousel-wrapper .ect-simple-event .ect-share-wrapper i.ect-icon-share:before{
              background: ' . esc_attr($ect_date_color) . ';
              color: ' . esc_attr($main_skin_color) . ';
         }';
} else {
    $ect_output_css .= '  #ect-carousel-wrapper .ect-simple-event .ect-share-wrapper i.ect-icon-share:before,
         #ect-carousel-wrapper .ect-simple-event .ect-share-wrapper i.ect-icon-share:before{
              background: ' . esc_attr($main_skin_alternate_color) . ';
              color: ' . esc_attr($main_skin_color) . ';
         }';
}

/*--- Event readmore Styles - CSS ---*/

if ($ect_date_styles['font-size'] > '17') {
    $ect_output_css .= '#ect-carousel-wrapper .ect-carousel-event.style-4 .ect-carousel-post-content .ect-event-schedule,
          #ect-carousel-wrapper .ect-carousel-date,
          #ect-carousel-wrapper .ect-carousel-area span{
               font-size:17px;
          }
          ';
}
$whitecolor = !empty($options['main_skin_alternate_color']) ? esc_attr($options['main_skin_alternate_color']) : esc_attr($ect_date_color);

$ect_output_css .= '
 #ect-carousel-wrapper .ect-simple-event .ect-event-category ul.tribe_events_cat li a{
     color: ' . esc_attr($main_skin_color) . ';
     border-color: ' . esc_attr($main_skin_color) . ';
 }
 #ect-carousel-wrapper .ect-featured-event .ect-event-category ul.tribe_events_cat li a{
     color: ' . esc_attr($featured_event_skin_color) . ';
     border-color: ' . esc_attr($featured_event_skin_color) . ';
 }
 #ect-carousel-wrapper .ect-featured-event .ect-event-category ul.tribe_events_cat li a:hover{
     color: ' . esc_attr($featured_event_font_color) . ';
     background: ' . esc_attr($featured_event_skin_color) . ';
 }
 #ect-carousel-wrapper .ect-simple-event .ect-event-category ul.tribe_events_cat li a:hover{
     color: ' . esc_attr($whitecolor) . ';
     background: ' . esc_attr($main_skin_color) . ';
 }
 #ect-carousel-wrapper .ect-featured-event:not(.style-1) .ect-event-category ul.tribe_events_cat li a{
     color: ' . esc_attr($featured_event_font_color) . ';
     background: ' . esc_attr($featured_event_skin_color) . ';
 }
 #ect-carousel-wrapper .ect-simple-event:not(.style-1) .ect-event-category ul.tribe_events_cat li a{
     color: ' . esc_attr($whitecolor) . ';
     background: ' . esc_attr($main_skin_color) . ';
 }
 #ect-carousel-wrapper .ect-featured-event:not(.style-1) .ect-event-category ul.tribe_events_cat li a:hover{
     color: ' . esc_attr($featured_event_skin_color) . ';
     background: ' . esc_attr($featured_event_font_color) . ';
     border-color: ' . esc_attr($featured_event_skin_color) . ';
 }
 #ect-carousel-wrapper .ect-simple-event:not(.style-1) .ect-event-category ul.tribe_events_cat li a:hover{
     color: ' . esc_attr($main_skin_color) . ';
     background: ' . esc_attr($whitecolor) . ';
     border-color: ' . esc_attr($main_skin_color) . ';
 }';

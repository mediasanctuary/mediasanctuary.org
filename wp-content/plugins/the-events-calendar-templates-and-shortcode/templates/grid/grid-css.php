<?php
switch ($style) {

    /** STYLE-1 */
    case 'style-1':
        /*--- Main Skin Color - CSS ---*/

        $ect_output_css .= ' #ect-grid-wrapper .ect-grid-event.style-1.ect-featured-event .ect-grid-readmore a:hover{
               background: ' . esc_attr($featured_event_skin_color) . ';
               color: ' . esc_attr($featured_event_font_color) . ';
          }';

        if ($main_skin_alternate_color === '') {
            $ect_output_css .= ' #ect-grid-wrapper .ect-grid-event.style-1.ect-simple-event .ect-grid-readmore a:hover{
                    background: ' . esc_attr($main_skin_color) . ';
                    color: ' . esc_attr($ect_date_color) . ';
               }';
        } else {
            $ect_output_css .= ' #ect-grid-wrapper .ect-grid-event.style-1.ect-simple-event .ect-grid-readmore a:hover{
                    background: ' . esc_attr($main_skin_color) . ';
                    color: ' . esc_attr($main_skin_alternate_color) . ';
               }';
        }
        break;
    /** STYLE-2 */
    case 'style-2':
        /*--- Main Skin Color - CSS ---*/
        $ect_output_css .= ' #ect-grid-wrapper .ect-grid-event.style-2 .ect-grid-footer .ect-grid-readmore a{
               border-color: ' . esc_attr($ect_title_color) . ';
               color: ' . esc_attr($ect_title_color) . ';
          }';
        $ect_output_css .= '
     #ect-grid-wrapper .ect-featured-event.style-2 .ect-share-wrapper i.ect-icon-share:before{
          background: ' . esc_attr($featured_event_font_color) . ';
          color: ' . esc_attr($featured_event_skin_color) . ';
     }';

        if ($main_skin_alternate_color === '') {
            $ect_output_css .= '  #ect-grid-wrapper .ect-simple-event.style-2 .ect-share-wrapper i.ect-icon-share:before{
               background: ' . esc_attr($ect_date_color) . ';
               color: ' . esc_attr($main_skin_color) . ';
          }';
        } else {
            $ect_output_css .= '  #ect-grid-wrapper .ect-simple-event.style-2 .ect-share-wrapper i.ect-icon-share:before{
               background: ' . esc_attr($main_skin_alternate_color) . ';
               color: ' . esc_attr($main_skin_color) . ';
          }';
        }

        if ($event_desc_bg_color === "#ffffff") {
            $ect_output_css .= '
               #ect-grid-wrapper .style-2.ect-featured-event .ect-grid-footer{
               background-color:' . esc_attr(Ecttinycolor($featured_event_skin_color)->lighten(37)->toString()) . ';
               border-top: none;
               }';
            $ect_output_css .= '
               #ect-grid-wrapper .style-2.ect-simple-event .ect-grid-footer{
                    background-color:' . esc_attr(Ecttinycolor($main_skin_color)->lighten(40)->toString()) . ';
                    border-top: none;
               }';
        }

        break;
    /** STYLE-3 */
    case 'style-3':
        /*          --- Main Skin Color - CSS ---*/

        $ect_output_css .= '
         #ect-grid-wrapper .ect-featured-event.style-3 .ect-share-wrapper i.ect-icon-share:before{
              background: ' . esc_attr($featured_event_font_color) . ';
              color: ' . esc_attr($featured_event_skin_color) . ';
         }';

        if ($main_skin_alternate_color === '') {
            $ect_output_css .= '   #ect-grid-wrapper .ect-simple-event.style-3 .ect-share-wrapper i.ect-icon-share:before{
               background: ' . esc_attr($ect_date_color) . ';
               color: ' . esc_attr($main_skin_color) . ';
          }';
        } else {
            $ect_output_css .= '   #ect-grid-wrapper .ect-simple-event.style-3 .ect-share-wrapper i.ect-icon-share:before{
                    background: ' . esc_attr($main_skin_alternate_color) . ';
                    color: ' . esc_attr($main_skin_color) . ';
               }';
        }
        $ect_output_css .= ' #ect-grid-wrapper .ect-grid-event.style-3.ect-featured-event .ect-grid-readmore a{
          background: ' . esc_attr($featured_event_skin_color) . ';
           color: ' . esc_attr($featured_event_font_color) . ';
          }';

        if ($main_skin_alternate_color === '') {
            $ect_output_css .= ' #ect-grid-wrapper .ect-grid-event.style-3.ect-simple-event .ect-grid-readmore a{
               background: ' . esc_attr($main_skin_color) . ';
               color: ' . esc_attr($ect_date_color) . ';
          }';
        } else {
            $ect_output_css .= ' #ect-grid-wrapper .ect-grid-event.style-3.ect-simple-event .ect-grid-readmore a{
               background: ' . esc_attr($main_skin_color) . ';
               color: ' . esc_attr($main_skin_alternate_color) . ';
          }';
        }

        /*--- Featured Event Font Color - CSS ---*/

        break;
    default:
        $ect_output_css .= '#ect-grid-wrapper .style-4 .ect-date-area-wrap,
#ect-grid-wrapper .style-4 .ect-date-area{
     border-color: ' . esc_attr($ect_date_color) . ';
}

#ect-grid-wrapper .ect-featured-event.style-4 .ect-grid-event-area {
     border-color: ' . esc_attr(Ecttinycolor($featured_event_skin_color)->darken(7)->toString()) . ';
     background: ' . esc_attr($featured_event_skin_color) . ';
     box-shadow : inset 0px 0px 12px 2px ' . esc_attr(Ecttinycolor($featured_event_skin_color)->darken(3)->toString()) . ';
}
';
        /*--- Featured Event Font Color - CSS ---*/
        $ect_output_css .= '
#ect-grid-wrapper .ect-featured-event .ect-grid-date,
#ect-grid-wrapper .ect-featured-event.style-4 .ect-grid-title h4,
#ect-grid-wrapper .ect-featured-event.style-4 .ect-grid-title h4 a,
#ect-grid-wrapper .ect-featured-event.style-4 .ect-date-area-wrap span,
#ect-grid-wrapper .ect-featured-event.style-4 .ect-grid-venue,
#ect-grid-wrapper .ect-featured-event.style-4 .ect-grid-cost{
     color: ' . esc_attr($featured_event_font_color) . ';
}
#ect-grid-wrapper .ect-featured-event.style-4 .ect-grid-venue a,
#ect-grid-wrapper .ect-featured-event.style-4 .ect-grid-readmore a{
     color: ' . esc_attr(Ecttinycolor($featured_event_font_color)->darken(5)->toString()) . ';
}
#ect-grid-wrapper .ect-featured-event.style-4 .ect-grid-venue a,
#ect-grid-wrapper .ect-featured-event.style-4 .ect-grid-readmore a{
     color: ' . esc_attr(Ecttinycolor($featured_event_font_color)->darken(5)->toString()) . ';
}';

        break;
}
/**------------------------------------Share css------------------------------ */
$ect_output_css .= '

.ect-grid-event.ect-featured-event .ect-share-wrapper .ect-social-share-list a:hover{
     color: ' . esc_attr($featured_event_skin_color) . ';
}
.ect-grid-event.ect-simple-event .ect-share-wrapper .ect-social-share-list a:hover{
   color: ' . esc_attr($main_skin_color) . ';
}';
/*--- Main Skin Color - CSS ---*/

/*--- Featured Event Font Color - CSS ---*/
$ect_output_css .= '
#ect-grid-wrapper .ect-grid-date{
     ' . $ect_date_style . ';
}
';
$ect_output_css .= '
#ect-grid-wrapper .ect-featured-event .ect-grid-date{
     color: ' . esc_attr($featured_event_font_color) . ';
     background: ' . esc_attr($featured_event_skin_color) . ';
}
';

$ect_output_css .= '
#ect-grid-wrapper .ect-simple-event .ect-grid-date {
     background: ' . esc_attr($thisPlugin::ect_hex2rgba($main_skin_color, .95)) . ';

}';
if ($main_skin_alternate_color !== '') {
    $ect_output_css .= '
     #ect-grid-wrapper .ect-simple-event .ect-grid-date {
          color: ' . esc_attr($main_skin_alternate_color) . ';
     }';
}

/*--- Event Background Color - CSS ---*/
$ect_output_css .= '
#ect-grid-wrapper .ect-grid-event-area{
     background: ' . esc_attr($event_desc_bg_color) . ';
}

#ect-grid-wrapper .ect-grid-image {
      background: ' . esc_attr(Ecttinycolor($event_desc_bg_color)->darken(10)->toString()) . ';
}
';
/*--- Event Title - CSS ---*/
$ect_output_css .= '
#ect-grid-wrapper .ect-grid-title h4,
#ect-grid-wrapper .ect-grid-title h4 a{
     ' . $title_styles . ';
     font-size:' . esc_attr($ect_title_font_size) . 'px;
}
';
/*--- Event Description - CSS ---*/
$ect_output_css .= '
#ect-grid-wrapper .ect-grid-description .ect-event-content p{
     ' . $ect_desc_styles . ';
}
';
$venue_font_size = $ect_venue_font_size + 6;

/*--- Event Venue Color - CSS ---*/
$ect_output_css .= '
#ect-grid-wrapper .ect-grid-venue{
     ' . $ect_venue_styles . ';
}
#ect-grid-wrapper .ect-grid-cost,
#ect-grid-wrapper .ect-grid-cost .ect-ticket-info span {
     color:' . esc_attr($ect_title_color) . ';
     font-size:' . esc_attr($ect_title_font_size) . 'px;
     font-family:' . $ect_title_font_famiily . ';
}
#ect-grid-wrapper .ect-grid-venue a,
#ect-grid-wrapper .ect-grid-readmore a,
.ect-grid-categories ul.tribe_events_cat li a {
     color: ' . esc_attr(Ecttinycolor($ect_venue_color)->darken(6)->toString()) . ';
     font-family: ' . $ect_venue_font_famiily . ';
}
#ect-grid-wrapper .ect-grid-border:before {
     background: ' . esc_attr(Ecttinycolor($ect_venue_color)->darken(6)->toString()) . ';
}
#ect-grid-wrapper .ect-grid-event.ect-simple-event .ect-grid-readmore a{
     color: ' . esc_attr($main_skin_color) . ';
     border-color:' . esc_attr($main_skin_color) . ';
}
#ect-grid-wrapper .ect-grid-event.ect-featured-event .ect-grid-readmore a{
     color: ' . esc_attr($featured_event_skin_color) . ';
     border-color:' . esc_attr($featured_event_skin_color) . ';
}
';

/*
-------Event category styles ------- */

if ($ect_date_styles['font-size'] > '20') {
    $ect_output_css .= '
          #ect-grid-wrapper .ect-grid-date
          {
               font-size:20px;
          }
          ';
}

if ($template == 'masonry-view') {
    // Masonary layout Category
    $ect_output_css .= '
.ect-masonay-load-more a.ect-load-more-btn,
ul.ect-categories li.ect-active, ul.ect-categories li:hover{
     color: ' . esc_attr($main_skin_alternate_color) . ';
}
ul.ect-categories li {
     border-color: ' . esc_attr(Ecttinycolor($main_skin_color)->darken(9)->toString()) . ';
     color: ' . esc_attr(Ecttinycolor($main_skin_color)->darken(9)->toString()) . ';
}
ul.ect-categories li.ect-active, ul.ect-categories li:hover,
.ect-masonay-load-more a.ect-load-more-btn {
     background-color:' . esc_attr($main_skin_color) . ';
     border-color: ' . esc_attr(Ecttinycolor($main_skin_color)->darken(9)->toString()) . ';
}';

}
$ect_output_css .= ' #ect-minimal-list-wrp .ect-share-wrapper .ect-social-share-list a{
          color: ' . esc_attr($main_skin_color) . ';
     }
     #ect-minimal-list-wrp .ect-share-wrapper i.ect-icon-share:before {
          background: ' . esc_attr($main_skin_color) . ';
     }';

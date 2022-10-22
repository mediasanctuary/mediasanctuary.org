<?php
if ( !defined( 'ABSPATH' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}
/**
 * This file is used only for dynamic styles in carousel layouts.
 */
switch($style){

     /** STYLE-1 **/
     case "style-1":
          /*--- Main Skin Color - CSS ---*/
          $ect_output_css.='
          #ect-carousel-wrapper .style-1 .ect-carousel-date{
               background: '.$thisPlugin::ect_hex2rgba($main_skin_color, .95 ).';
               box-shadow : inset 0px 0px 25px -5px '.Ecttinycolor($main_skin_color)->darken(7)->toString().';
          }
          #ect-carousel-wrapper .style-1 .ect-carousel-date:after {
               border-color: transparent transparent '.Ecttinycolor($main_skin_color)->darken(3)->toString().';
          }
          ';
     /*--- Main Skin Alternate Color - CSS ---*/
     $ect_output_css.='
     #ect-carousel-wrapper .style-1 .ect-carousel-date{
          color: '.$main_skin_alternate_color.';
     }
     ';
     /*--- Featured Event Color - CSS ---*/
     $ect_output_css.='
     #ect-carousel-wrapper .ect-featured-event.style-1 .ect-carousel-date{
          background: '.$thisPlugin::ect_hex2rgba($featured_event_skin_color, .95 ).';
     }
     #ect-carousel-wrapper .ect-featured-event.style-1 .ect-carousel-date:after {
          border-color: transparent transparent '.Ecttinycolor($featured_event_skin_color)->darken(7)->toString().';
     }
     #ect-carousel-wrapper .ect-featured-event.style-1 .ect-carousel-date{
		box-shadow : inset 0px 0px 25px -5px '.Ecttinycolor($featured_event_skin_color)->darken(7)->toString().';
	}
     ';

     break;
     /** STYLE-2 **/
     case "style-2":
          /*--- Main Skin Color - CSS ---*/
          $ect_output_css.='
          #ect-carousel-wrapper .style-2 .ect-carousel-date {
               background: '.$thisPlugin::ect_hex2rgba($main_skin_color, .95 ).';
               box-shadow : inset 0px 0px 25px -5px '.Ecttinycolor($main_skin_color)->darken(7)->toString().';
          }
          ';
          /*--- Main Skin Alternate Color - CSS ---*/
          $ect_output_css.='
          #ect-carousel-wrapper .style-2 .ect-carousel-date{
               color: '.$main_skin_alternate_color.';
          }
          ';
          /*--- Featured Event Color - CSS ---*/
          $ect_output_css.='
          #ect-carousel-wrapper .ect-featured-event.style-2 .ect-carousel-date {
               background: '.$thisPlugin::ect_hex2rgba($featured_event_skin_color, .95 ).';
          }
          #ect-carousel-wrapper .ect-featured-event.style-2 .ect-carousel-date {
               box-shadow : inset 0px 0px 25px -5px '.Ecttinycolor($featured_event_skin_color)->darken(7)->toString().';
          }
          ';
     break;
     /** STYLE-3 **/
     case "style-3":
          /*--- Main Skin Color - CSS ---*/
          $ect_output_css.='
          #ect-carousel-wrapper .style-3 .ect-carousel-event-area {
               border-color: '.$main_skin_color.';
          }
          ';
          /*--- Featured Event Color - CSS ---*/
          $ect_output_css.='
          #ect-carousel-wrapper .ect-featured-event.style-3 .ect-carousel-event-area {
               border-color: '.Ecttinycolor($featured_event_skin_color)->darken(7)->toString().';
               background: '.$featured_event_skin_color.';
               box-shadow : inset 0px 0px 25px -5px '.Ecttinycolor($featured_event_skin_color)->darken(7)->toString().';
          }
          ';
          /*--- Featured Event Font Color - CSS ---*/
          $ect_output_css.='
          #ect-carousel-wrapper .ect-featured-event.style-3 .ect-carousel-title h4,
          #ect-carousel-wrapper .ect-featured-event.style-3 .ect-carousel-title h4 a,
          #ect-carousel-wrapper .ect-featured-event.style-3 .ect-carousel-venue,
          #ect-carousel-wrapper .ect-featured-event.style-3 .ect-carousel-cost{
               color: '.$featured_event_font_color.';
          }
          #ect-carousel-wrapper .ect-featured-event.style-3 .ect-carousel-venue a,
		#ect-carousel-wrapper .ect-featured-event.style-3 .ect-carousel-readmore a{
               color: '.Ecttinycolor($featured_event_font_color)->darken(5)->toString().';
          }';
     break;
     default:
     /*--- Featured Event Color - CSS ---*/
$ect_output_css.='
#ect-carousel-wrapper .ect-featured-event.style-4 .ect-date-schedule{
     border-color: '.Ecttinycolor($featured_event_skin_color)->darken(7)->toString().';
	background: '.$featured_event_skin_color.';
	box-shadow : inset 0px 0px 12px 2px '.Ecttinycolor($featured_event_skin_color)->darken(3)->toString().';;
} 

#ect-carousel-wrapper .ect-featured-event.style-4 .ect-date-schedule-wrap span{
     color: '.$featured_event_font_color.';
}
#ect-carousel-wrapper .style-4 .ect-date-schedule,#ect-carousel-wrapper .style-4 .ect-date-schedule-wrap{
     border-color: '.$ect_date_color.';
}
';
     break;
}
/*--- Main Skin Color - CSS ---*/
$ect_output_css.='
#ect-carousel-wrapper .ect-date-schedule{
     background: '.$main_skin_color.';
}
';

/*--- Featured Event Font Color - CSS ---*/
$ect_output_css.='

#ect-carousel-wrapper .ect-featured-event .ect-carousel-date{
     color: '.$featured_event_font_color.';
}
';
/*--- Event Background Color - CSS ---*/
$ect_output_css.='
#ect-carousel-wrapper .ect-carousel-event-area{
     background: '.$event_desc_bg_color.';
}
#ect-carousel-wrapper .ect-carousel-event-area {
     box-shadow: inset 0 0 25px -5px '.Ecttinycolor($event_desc_bg_color)->darken(10)->toString().';
}
#ect-carousel-wrapper .ect-carousel-image {
     background: '.Ecttinycolor($event_desc_bg_color)->darken(10)->toString().';;
}
#ect-carousel-wrapper .ect-events-carousel .slick-arrow i {
     background: '.$event_desc_bg_color.';
     box-shadow: 2px 2px 0px 1px '.Ecttinycolor($event_desc_bg_color)->darken(10)->toString().';;
}
';
/*--- Event Title - CSS ---*/
$ect_output_css.='
#ect-carousel-wrapper .ect-carousel-title h4,
#ect-carousel-wrapper .ect-carousel-title h4 a{
     '.$title_styles.';
}
';
/*--- Event Description - CSS ---*/
$ect_output_css.='
#ect-carousel-wrapper .ect-carousel-description .ect-event-content p{
     '.$ect_desc_styles.'
}
#ect-carousel-wrapper .ect-events-carousel .slick-arrow {
     color: '.$ect_desc_color.';
}

';
$venue_font_size = $ect_venue_font_size+6;
/*--- Event Venue Color - CSS ---*/
$ect_output_css.='
#ect-carousel-wrapper .ect-carousel-venue{
     '.$ect_venue_styles.'
}
#ect-carousel-wrapper .ect-carousel-cost {
     color:'.$ect_venue_color.';
     font-size:'.$venue_font_size.'px;
     font-weight:bold;
     font-family: '.$ect_venue_font_famiily.';
}
#ect-carousel-wrapper .ect-carousel-venue a,
#ect-carousel-wrapper .ect-carousel-readmore a {
	color: '.Ecttinycolor($ect_venue_color)->darken(6)->toString().';
	font-family: '.$ect_venue_font_famiily.';
}
#ect-carousel-wrapper .ect-carousel-border:before {
	background:'.Ecttinycolor($ect_venue_color)->darken(6)->toString().'; 
}
';
/*--- Event Dates Styles - CSS ---*/
$ect_output_css.='
#ect-carousel-wrapper .ect-carousel-date,
#ect-carousel-wrapper .ect-date-schedule span{
     '.$ect_date_style.';
}

';
$ect_output_css.=' #ect-minimal-list-wrp .ect-share-wrapper .ect-social-share-list a{
     color: '.$main_skin_color.';
}
#ect-minimal-list-wrp .ect-share-wrapper i.ect-icon-share:before {
     background: '.$main_skin_color.';
}';
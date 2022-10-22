<?php
if ( !defined( 'ABSPATH' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}
/**
 * This file is used only for dynamic styles in accordion layouts.
 */
switch($style){

     /** STYLE-1 **/
     case "style-1":
        $ect_output_css.='
        #ect-accordion-wrapper .ect-accordion-event.style-1.ect-featured-event{
			border-left-color: '.$featured_event_skin_color.';
		}';
     break;

     /** STYLE-2 **/
     case "style-2":
          $ect_output_css.='
          #ect-accordion-wrapper .ect-accordion-event.style-2 .ect-accordion-date{
               background: '.$main_skin_color.';
          }
          #ect-accordion-wrapper .style-2 .ect-accordion-date span.ev-yr,
		#ect-accordion-wrapper .style-2 .ect-accordion-date span.ev-time,
		#ect-accordion-wrapper .style-2 .ect-accordion-date span.ev-weekday {
			background: '.Ecttinycolor($main_skin_color)->darken(12)->toString().';
		}
          ';
          /*--- Main Skin Alternate Color - CSS ---*/
          $ect_output_css.='
          #ect-accordion-wrapper .ect-accordion-event.style-2 .ect-accordion-date{
               color: '.$main_skin_alternate_color.';
          }
          ';
          /*--- Featured Event Color - CSS ---*/
          $ect_output_css.='
          #ect-accordion-wrapper .ect-featured-event.style-2 .ect-accordion-date{
               background: '.$featured_event_skin_color.';
          }
          #ect-accordion-wrapper .ect-accordion-event.style-2.ect-featured-event{
               border-left-color: '.$featured_event_skin_color.';
          }
          #ect-accordion-wrapper .ect-featured-event.style-2 .ect-accordion-date span.ev-yr,
		#ect-accordion-wrapper .ect-featured-event.style-2 .ect-accordion-date span.ev-time,
		#ect-accordion-wrapper .ect-featured-event.style-2 .ect-accordion-date span.ev-weekday {
			background: '.Ecttinycolor($featured_event_skin_color)->darken(12)->toString().';
		}
          ';
          /*--- Featured Event Font Color - CSS ---*/
          $ect_output_css.='
          #ect-accordion-wrapper .ect-featured-event.style-2 .ect-accordion-date{
               color: '.$featured_event_font_color.';
          }';
  
     break;

     /** STYLE-3 **/
     case "style-3":
          $ect_output_css.='
          #ect-accordion-wrapper .ect-accordion-event.style-3.ect-simple-event.active-event{
               background: '.$main_skin_color.';
          }
          #ect-accordion-wrapper .ect-simple-event.style-3.active-event {
               box-shadow: inset 0px 0px 25px -5px '.Ecttinycolor($main_skin_color)->darken(7)->toString().';
               border-color: '.Ecttinycolor($main_skin_color)->darken(7)->toString().';
          }
          #ect-accordion-wrapper .ect-simple-event.style-3.active-event .ect-accordion-header:after {
               color: '.Ecttinycolor($main_skin_color)->darken(12)->toString().';
          }
          #ect-accordion-wrapper .ect-simple-event.style-3.active-event .ect-accordion-date span.ev-yr,
		#ect-accordion-wrapper .ect-simple-event.style-3.active-event .ect-accordion-date span.ev-time,
		#ect-accordion-wrapper .ect-simple-event.style-3.active-event .ect-accordion-date span.ev-weekday{
               background: '.Ecttinycolor($main_skin_color)->darken(12)->toString().';
          }	
          #ect-accordion-wrapper .ect-featured-event.style-3.active-event .ect-accordion-date span.ev-yr,
		#ect-accordion-wrapper .ect-featured-event.style-3.active-event .ect-accordion-date span.ev-time,
		#ect-accordion-wrapper .ect-featured-event.style-3.active-event .ect-accordion-date span.ev-weekday,
		#ect-accordion-wrapper .ect-featured-event.style-3.active-event .ect-share-wrapper i.ect-icon-share:before{
               background: '.Ecttinycolor($featured_event_skin_color)->darken(12)->toString().';
          }	
          ';
$ect_output_css.='
          #ect-accordion-wrapper .ect-simple-event.style-3.active-event,
		#ect-accordion-wrapper .ect-simple-event.style-3.active-event .ect-accordion-content,
		#ect-accordion-wrapper .ect-simple-event.style-3.active-event .ect-accordion-content p,
		#ect-accordion-wrapper .ect-simple-event.style-3.active-event .ect-accordion-date,
		#ect-accordion-wrapper .ect-simple-event.style-3.active-event .ect-accordion-venue,
		#ect-accordion-wrapper .ect-simple-event.style-3.active-event h3.ect-accordion-title,
		#ect-accordion-wrapper .ect-simple-event.style-3.active-event .ect-accordion-venue .ect-google a,
		#ect-accordion-wrapper .ect-simple-event.style-3.active-event .ect-accordion-content a.ect-events-read-more,
		#ect-accordion-wrapper .ect-simple-event.style-3.active-event:before,
		#ect-accordion-wrapper .ect-simple-event.style-3.active-event .ect-accordion-cost.no-image,
		#ect-accordion-wrapper .ect-simple-event.style-3.active-event .ect-accordion-date-full.no-image{
               color: '.$main_skin_alternate_color.';
          }
          ';
          /*--- Featured Event Color - CSS ---*/
          $ect_output_css.='
          #ect-accordion-wrapper .ect-accordion-event.style-3.ect-featured-event.active-event{
               background: '.$featured_event_skin_color.';
          }
          #ect-accordion-wrapper .ect-featured-event.style-3.active-event {
               box-shadow: inset 0px 0px 25px -5px '.Ecttinycolor($featured_event_skin_color)->lighten(7)->toString().';
               border-color: '.Ecttinycolor($featured_event_skin_color)->lighten(7)->toString().';
          }
          #ect-accordion-wrapper .ect-featured-event.style-3.active-event .ect-accordion-header:after,
		#ect-accordion-wrapper .ect-featured-event.style-3.active-event .ect-share-wrapper .ect-social-share-list a {
			color: '.Ecttinycolor($featured_event_skin_color)->darken(12)->toString().';
		}
          ';
          /*--- Featured Event Font Color - CSS ---*/
          $ect_output_css.='
          #ect-accordion-wrapper .ect-featured-event.style-3.active-event,
          #ect-accordion-wrapper .ect-featured-event.style-3.active-event .ect-accordion-content,
          #ect-accordion-wrapper .ect-featured-event.style-3.active-event .ect-accordion-content p,
          #ect-accordion-wrapper .ect-featured-event.style-3.active-event .ect-accordion-date,
          #ect-accordion-wrapper .ect-featured-event.style-3.active-event .ect-accordion-venue,
          #ect-accordion-wrapper .ect-featured-event.style-3.active-event h3.ect-accordion-title,
          #ect-accordion-wrapper .ect-featured-event.style-3.active-event .ect-share-wrapper i.ect-icon-share:before,
          #ect-accordion-wrapper .ect-featured-event.style-3.active-event .ect-accordion-venue .ect-google a,
          #ect-accordion-wrapper .ect-featured-event.style-3.active-event .ect-accordion-content a.ect-events-read-more,
          #ect-accordion-wrapper .ect-featured-event.style-3.active-event:before,
          #ect-accordion-wrapper .ect-featured-event.style-3.active-event .ect-accordion-cost.no-image,
          #ect-accordion-wrapper .ect-featured-event.style-3.active-event .ect-accordion-date-full.no-image{
               color:'.$featured_event_font_color.';
          }
          #ect-accordion-wrapper .ect-featured-event.style-3.active-event .ect-share-wrapper .ect-social-share-list {
               background: '.$featured_event_font_color.';
               border-color: '.$featured_event_font_color.';
          }
          #ect-accordion-wrapper .ect-featured-event.style-3.active-event .ect-share-wrapper .ect-social-share-list:before {
               border-top-color: '.Ecttinycolor($featured_event_font_color)->darken(1)->toString().';
          }
          ';
     break;
     default:
     $ect_output_css.='#ect-accordion-wrapper.ect-accordion-view.style-4 span.month-year-box {
	color: '.$main_skin_color.';
     }
     ';
     break;
}

/**Commomn Css */
$ect_output_css.='
#ect-accordion-wrapper .ect-accordion-event{
    border-color : '.Ecttinycolor($event_desc_bg_color)->darken(10)->toString().';
    box-shadow : inset 0px 0px 25px -5px '.Ecttinycolor($event_desc_bg_color)->darken(7)->toString().';
}';
/*--- Main Skin Color - CSS ---*/
$ect_output_css.='
#ect-accordion-wrapper .ect-accordn-slick-prev,
#ect-accordion-wrapper .ect-accordn-slick-next{
     background: '.$main_skin_color.';
}
#ect-accordion-wrapper .ect-accordion-header:after,
#ect-accordion-wrapper .ect-share-wrapper .ect-social-share-list a{
	color: '.$main_skin_color.';
}
#ect-accordion-wrapper .ect-share-wrapper i.ect-icon-share:before {
	background: '.$main_skin_color.';
}
';
/*--- Main Skin Alternate Color - CSS ---*/
$ect_output_css.='
#ect-accordion-wrapper .ect-share-wrapper i.ect-icon-share:before,
#ect-accordion-wrapper .ect-accordn-slick-prev .ect-icon-left:before,
#ect-accordion-wrapper .ect-accordn-slick-next .ect-icon-right:before{
     color: '.$main_skin_alternate_color.';
}
#ect-accordion-wrapper .ect-share-wrapper .ect-social-share-list {
     background: '.$main_skin_alternate_color.';
     
}
#ect-accordion-wrapper .ect-share-wrapper .ect-social-share-list:before {
     border-top-color: '.$main_skin_alternate_color.';
}
';
/*--- Featured Event Color - CSS ---*/
$ect_output_css.='
#ect-accordion-wrapper .ect-featured-event:before{
     color: '.$featured_event_skin_color.';
}
';
/*--- Event Background Color - CSS ---*/
$ect_output_css.='
#ect-accordion-wrapper .ect-accordion-event{
     background: '. $event_desc_bg_color.';
}
';
/*--- Event Title - CSS ---*/
$ect_output_css.='
#ect-accordion-wrapper h3.ect-accordion-title {
    '.$title_styles.';
}
';
/*--- Event Description - CSS ---*/
$ect_output_css.='
#ect-accordion-wrapper .ect-accordion-content,
#ect-accordion-wrapper .ect-accordion-content p
{
	'.$ect_desc_styles.';
}
#ect-accordion-wrapper .ect-accordion-cost.no-image,
#ect-accordion-wrapper .ect-accordion-date-full.no-image,
#ect-accordion-wrapper .ect-accordion-content a.ect-events-read-more {
	color:'.Ecttinycolor($ect_desc_color)->darken(5)->toString().';
}
';
/*--- Event Venue Color - CSS ---*/
$ect_output_css.='
#ect-accordion-wrapper .ect-accordion-venue {
     '.$ect_venue_styles.'
}
#ect-accordion-wrapper .ect-accordion-venue .ect-icon {
     font-size:'.$venue_font_size.';
}
#ect-accordion-wrapper .ect-accordion-venue .ect-google a {
     color: '.Ecttinycolor($ect_venue_color)->darken(5)->toString().';
}
';
/*--- Event Dates Styles - CSS ---*/
$ect_output_css.='
#ect-accordion-wrapper .ect-accordion-date,
#ect-accordion-wrapper.ect-accordion-view span.month-year-box{
     '.$ect_date_style.';
}
#ect-accordion-wrapper .ect-accordion-date span.ev-yr,
#ect-accordion-wrapper .ect-accordion-date span.ev-time,
#ect-accordion-wrapper .ect-accordion-date span.ev-weekday {
	background: '.Ecttinycolor($ect_date_color)->lighten(32)->toString().';
}';
<?php
switch($style){

     /** STYLE-1 **/
     case "style-1":
          /*--- Main Skin Color - CSS ---*/
          $ect_output_css.='
          #ect-grid-wrapper .style-1 .ect-grid-date {
               background: '.$thisPlugin::ect_hex2rgba($main_skin_color, .95 ).';
          }
          ';
          /*--- Main Skin Alternate Color - CSS ---*/
          $ect_output_css.='
          #ect-grid-wrapper .style-1 .ect-grid-date{
               color: '.$main_skin_alternate_color.';
          }
          ';
          /*--- Featured Event Color - CSS ---*/
          $ect_output_css.='
          #ect-grid-wrapper .ect-featured-event.style-1 .ect-grid-date {
               background: '.$thisPlugin::ect_hex2rgba($featured_event_skin_color, .95 ).';
          }
          #ect-grid-wrapper .ect-featured-event.style-1 .ect-grid-date {
			box-shadow : inset 0px 0px 25px -5px '.Ecttinycolor($featured_event_skin_color)->darken(7)->toString().';
		}
          ';

     break;
     /** STYLE-2 **/
     case "style-2":
          /*--- Main Skin Color - CSS ---*/
          $ect_output_css.='
          #ect-grid-wrapper .style-2 .ect-grid-date{
               background: '.$main_skin_color.';
               box-shadow : inset 0px 0px 12px -2px '.Ecttinycolor($main_skin_color)->darken(7)->toString().';
          }
          ';
           /*--- Main Skin Alternate Color - CSS ---*/
           $ect_output_css.='
           #ect-grid-wrapper .style-2 .ect-grid-date{
               color: '.$main_skin_alternate_color.';
          }
           ';
          /*--- Featured Event Color - CSS ---*/
          $ect_output_css.='
          #ect-grid-wrapper .ect-featured-event.style-2 .ect-grid-date{
               background: '.$featured_event_skin_color.';
          }
          #ect-grid-wrapper .ect-featured-event.style-2 .ect-grid-date {
			box-shadow : inset 0px 0px 25px -5px '.Ecttinycolor($featured_event_skin_color)->darken(7)->toString().';
		}
          ';
     break;
      /** STYLE-3 **/
      case "style-3":
          /*--- Main Skin Color - CSS ---*/
          $ect_output_css.='
          #ect-grid-wrapper .style-3 .ect-grid-event-area {
               border-color: '.$main_skin_color.';
          }
          ';
          /*--- Featured Event Color - CSS ---*/
          $ect_output_css.='
          #ect-grid-wrapper .ect-featured-event.style-3 .ect-grid-event-area{
               border-color:'.Ecttinycolor($featured_event_skin_color)->darken(7)->toString().';
               background: '.$featured_event_skin_color.';
               box-shadow : inset 0px 0px 12px 2px '.Ecttinycolor($featured_event_skin_color)->darken(3)->toString().';
          }
          ';
          /*--- Featured Event Font Color - CSS ---*/
          $ect_output_css.='
          #ect-grid-wrapper .ect-featured-event.style-3 .ect-grid-title h4,
		#ect-grid-wrapper .ect-featured-event.style-3 .ect-grid-title h4 a,
		#ect-grid-wrapper .ect-featured-event.style-3 .ect-grid-venue,
		#ect-grid-wrapper .ect-featured-event.style-3 .ect-grid-cost{
               color: '.$featured_event_font_color.';
          }
          #ect-grid-wrapper .ect-featured-event.style-3 .ect-grid-venue a,
		#ect-grid-wrapper .ect-featured-event.style-3 .ect-grid-readmore a{
               color: '.Ecttinycolor($featured_event_font_color)->darken(5)->toString().';
          }
          ';
          break;
          default:
          $ect_output_css.='#ect-grid-wrapper .style-4 .ect-date-schedule-wrap,
#ect-grid-wrapper .style-4 .ect-date-schedule{
     border-color: '.$ect_date_color.';
}

#ect-grid-wrapper .ect-featured-event.style-4 .ect-grid-event-area {
     border-color: '.Ecttinycolor($featured_event_skin_color)->darken(7)->toString().';
     background: '.$featured_event_skin_color.';
     box-shadow : inset 0px 0px 12px 2px '.Ecttinycolor($featured_event_skin_color)->darken(3)->toString().';
}
';
/*--- Featured Event Font Color - CSS ---*/
$ect_output_css.='
#ect-grid-wrapper .ect-featured-event .ect-grid-date,
#ect-grid-wrapper .ect-featured-event.style-4 .ect-grid-title h4,
#ect-grid-wrapper .ect-featured-event.style-4 .ect-grid-title h4 a,
#ect-grid-wrapper .ect-featured-event.style-4 .ect-date-schedule-wrap span,
#ect-grid-wrapper .ect-featured-event.style-4 .ect-grid-venue,
#ect-grid-wrapper .ect-featured-event.style-4 .ect-grid-cost{
     color: '.$featured_event_font_color.';
}
#ect-grid-wrapper .ect-featured-event.style-4 .ect-grid-venue a,
#ect-grid-wrapper .ect-featured-event.style-4 .ect-grid-readmore a{
     color: '.Ecttinycolor($featured_event_font_color)->darken(5)->toString().';
}
#ect-grid-wrapper .ect-featured-event.style-4 .ect-grid-venue a,
#ect-grid-wrapper .ect-featured-event.style-4 .ect-grid-readmore a{
     color: '.Ecttinycolor($featured_event_font_color)->darken(5)->toString().';
}';

          break;
}
/*--- Main Skin Color - CSS ---*/
$ect_output_css.='
#ect-grid-wrapper .ect-date-schedule{
     background: '.$main_skin_color.';
}

';

/*--- Featured Event Font Color - CSS ---*/
$ect_output_css.='
#ect-grid-wrapper .ect-featured-event .ect-grid-date{
     color: '.$featured_event_font_color.';
}
';
/*--- Event Background Color - CSS ---*/
$ect_output_css.='
#ect-grid-wrapper .ect-grid-event-area{
     background: '.$event_desc_bg_color.';
}
#ect-grid-wrapper .ect-grid-event-area {
     box-shadow: inset 0 0 25px -5px '.Ecttinycolor($event_desc_bg_color)->darken(10)->toString().';
}
#ect-grid-wrapper .ect-grid-image {
     background: '.Ecttinycolor($event_desc_bg_color)->darken(10)->toString().';
}
';
/*--- Event Title - CSS ---*/
$ect_output_css.='
#ect-grid-wrapper .ect-grid-title h4,
#ect-grid-wrapper .ect-grid-title h4 a{
     '.$title_styles.';
}
';
/*--- Event Description - CSS ---*/
$ect_output_css.='
#ect-grid-wrapper .ect-grid-description .ect-event-content p{
     '.$ect_desc_styles.';
}
';
$venue_font_size = $ect_venue_font_size+6;
//  var_dump();
/*--- Event Venue Color - CSS ---*/
$ect_output_css.='
#ect-grid-wrapper .ect-grid-venue{
     '.$ect_venue_styles.';
}
#ect-grid-wrapper .ect-grid-cost {
     color:'.$ect_venue_color.';
     font-size:'.$venue_font_size.'px;
     font-weight:bold;
     font-family:'.$ect_venue_font_famiily.';
}
#ect-grid-wrapper .ect-grid-venue a,
#ect-grid-wrapper .ect-grid-readmore a,
.ect-grid-categories ul.tribe_events_cat li a {
     color: '.Ecttinycolor($ect_venue_color)->darken(6)->toString().';
     font-family: '.$ect_venue_font_famiily.';
}
#ect-grid-wrapper .ect-grid-border:before {
     background: '.Ecttinycolor($ect_venue_color)->darken(6)->toString().';
}
';
/*--- Event Dates Styles - CSS ---*/
$ect_output_css.='
#ect-grid-wrapper .ect-grid-date,
#ect-grid-wrapper .ect-date-schedule span{
     '.$ect_date_style.';
}
';
if($template=="masonry-view"){
 // Masonary layout Category
$ect_output_css .='
.ect-masonay-load-more a.ect-load-more-btn,
ul.ect-categories li.ect-active, ul.ect-categories li:hover{
     color: '.$main_skin_alternate_color.';
}
ul.ect-categories li {
     border-color: '.Ecttinycolor($main_skin_color)->darken(9)->toString().';
     color: '.Ecttinycolor($main_skin_color)->darken(9)->toString().';
}
ul.ect-categories li.ect-active, ul.ect-categories li:hover,
.ect-masonay-load-more a.ect-load-more-btn {
     background-color:'.$main_skin_color.';
     border-color: '.Ecttinycolor($main_skin_color)->darken(9)->toString().';
}';
     
}
$ect_output_css.=' #ect-minimal-list-wrp .ect-share-wrapper .ect-social-share-list a{
          color: '.$main_skin_color.';
     }
     #ect-minimal-list-wrp .ect-share-wrapper i.ect-icon-share:before {
          background: '.$main_skin_color.';
     }';
<?php
switch($style){
     /** STYLE-1 **/
     case "style-1":
          /*--- Main Skin Color - CSS ---*/
          $ect_output_css.='
          .ect-list-post.style-1 .ect-list-post-right .ect-list-venue{
               background: '.$main_skin_color.';
               box-shadow : inset 0px 0px 50px -5px '.Ecttinycolor($main_skin_color)->darken(7)->toString().';
          }
          .ect-list-post.style-1 .ect-list-post-left .ect-list-date {
               background: '.$thisPlugin::ect_hex2rgba($main_skin_color, .96 ).';
               box-shadow : inset 2px 0px 14px -2px inset 2px 0px 14px -2px '.Ecttinycolor($main_skin_color)->darken(5)->toString().';
          }';
          /*--- Main Skin Alternate Color - CSS ---*/
          $ect_output_css.='
          .ect-list-post.style-1.ect-simple-event .ect-list-venue .ect-venue-details,
          .ect-list-post.style-1.ect-simple-event .ect-list-venue .ect-icon,
          .ect-list-post.style-1.ect-simple-event .ect-list-venue .ect-google a
          {
               color: '.$main_skin_alternate_color.';
          }
          ';
          /*--- Featured Event Color - CSS ---*/
          $ect_output_css.='
          .ect-list-post.ect-featured-event.style-1 .ect-list-post-right .ect-list-venue{
               background: '.$featured_event_skin_color.'; 
               box-shadow : inset -2px 0px 14px -2px '.Ecttinycolor($featured_event_skin_color)->darken(7)->toString().';
          }
          .ect-list-post.style-1.ect-featured-event .ect-list-post-left .ect-list-date {
               background: '.$thisPlugin::ect_hex2rgba($featured_event_skin_color, .85 ).';
               box-shadow : inset 2px 0px 14px -2px '.Ecttinycolor($featured_event_skin_color)->darken(15)->toString().';
          }
          ';
          /*--- Event Title - CSS ---*/
          $ect_output_css.='
          .ect-list-posts.style-1 .ect-events-title a.ect-event-url{
               '.$title_styles.';
          }
          ';
     break;
     /** STYLE-2 **/
     case "style-2":
          /*--- Main Skin Color - CSS ---*/
          $ect_output_css.='.ect-list-post.style-2 .modern-list-right-side{
               background: '.$main_skin_color.';
               box-shadow : inset 0px 0px 50px -5px '.Ecttinycolor($main_skin_color)->darken(7)->toString().';
          }
          ';
           /*--- Featured Event Color - CSS ---*/
          $ect_output_css.='
          .ect-list-post.ect-featured-event.style-2 .modern-list-right-side{
               background: '.$featured_event_skin_color.'; 
               box-shadow : inset -2px 0px 14px -2px '.Ecttinycolor($featured_event_skin_color)->darken(7)->toString().'; 
          }
          ';
           /*--- Event Title - CSS ---*/
          $ect_output_css.='.ect-list-posts.style-2 .ect-events-title a.ect-event-url{
               '.$title_styles.';
          }
               .modern-list-right-side .ect-list-date .ect-date-area{
                    '.$ect_date_style.';
               }
          ';
          $ect_output_css.='.ect-list-post.style-2 .ect-rate-area span.ect-rate-icon,

 {
	color: '.Ecttinycolor($ect_title_color)->lighten(15)->toString().';
}';
     break;
     /** STYLE-3 **/
     case "style-3":
     /*--- Main Skin Color - CSS ---*/
     $ect_output_css.='.ect-list-post.style-3.ect-simple-event .ect-list-date,
	.ect-list-post.style-3 .ect-clslist-event-details a:hover{
          background: '.$main_skin_color.';
     }
     .ect-list-post.style-3.ect-simple-event .ect-list-date,
	.ect-list-post.style-3.ect-simple-event .ect-clslist-event-details a:hover {
		box-shadow : inset 0px 0px 50px -5px '.Ecttinycolor($main_skin_color)->darken(7)->toString().'; 
	}
     ';
     /*--- Main Skin Alternate Color - CSS ---*/
     $ect_output_css.='
     .ect-list-post.style-3.ect-simple-event .ect-clslist-event-details a:hover{
          color: '.$main_skin_alternate_color.';
     }
     
     ';
      /*--- Featured Event Skin Color/Font Color - CSS ---*/
      $ect_output_css.='
          .ect-list-post.ect-featured-event.style-3 .ect-list-date,
	     .ect-list-post.ect-featured-event.style-3 .ect-clslist-event-details a {
		     box-shadow : inset -2px 0px 14px -2px '.Ecttinycolor($featured_event_skin_color)->darken(7)->toString().';
               background: '.$featured_event_skin_color.'; 
               color: '.$featured_event_font_color.';
	     }
     ';
     /*--- Event Description - CSS ---*/
     $ect_output_css.='
     .ect-list-post .ect-style3-desc .ect-event-content p{
          '.$ect_desc_styles.';
     }
     ';
     // venue
     $ect_output_css.='
     .ect-list-post.style-3 .ect-rate-area span.ect-icon,
	  .ect-list-post.style-3 .ect-rate-area span.ect-rate-icon,
	.ect-list-post.style-3 .ect-rate-area .ect-rate {
	 	color:  '.Ecttinycolor($ect_venue_color)->darken(3)->toString().';
	}
     .style-3 .ect-list-date .ect-date-area{
          '.$ect_date_style.';
     }';
     break;
     default:
     /*--- Main Skin Color - CSS ---*/
     $ect_output_css.='.ect-list-post.style-4 .ect-li st-schedule,
          .ect-list-post .style-4 .ect-list-schedule-wrap{
               background: '.$main_skin_color.';
          }';
     /*--- Featured Event Color - CSS ---*/
     $ect_output_css.='.ect-list-post.ect-featured-event.style-4 .ect-list-schedule,
     .ect-list-post.ect-featured-event.style-4 .ect-list-schedule-wrap{
          border-color:'.Ecttinycolor($featured_event_skin_color)->darken(7)->toString().';
          background: '.$featured_event_skin_color.';
          box-shadow : inset 0px 0px 12px 2px '.Ecttinycolor($featured_event_skin_color)->darken(3)->toString().';
     }
     ';
     /*--- Featured Event Font Color - CSS ---*/
     $ect_output_css.='
     .ect-list-post.ect-featured-event.style-4 .ect-list-schedule-wrap span{
          color: '.$featured_event_font_color.';
     }
     ';
     // Date
     $ect_output_css.='.ect-list-post.style-4 .ect-list-schedule-wrap span {
          '.$ect_date_style.';
     }
     .ect-list-post.style-4 .ect-list-schedule-wrap,.ect-list-post.style-4 .ect-list-schedule,.ect-slider-event.style-4 .ect-date-schedule{
          border-color:  '.$ect_date_color.';
     }
     ';
     break;
}
// Common Css For all list styles
/*--- Main Skin Color - CSS ---*/
$ect_output_css.='.ect-list-post .ect-list-img {
     background-color: '.Ecttinycolor($main_skin_color)->darken(3)->toString().';
}

';
/*--- Main Skin Alternate Color - CSS ---*/
$ect_output_css.='
.ect-list-post.ect-simple-event .ect-list-date .ect-date-area,
.ect-list-post.ect-simple-event .ect-list-date span.ect-custom-schedule,
.ect-list-post.ect-simple-event .ect-list-post-left .ect-list-date .ect-date-area,
.ect-list-post.ect-simple-event .ect-list-post-left .ect-list-date span.ect-custom-schedule{
     color: '.$main_skin_alternate_color.';
}
';
/*--- Featured Event Color - CSS ---*/
$ect_output_css.='
.ect-list-post.ect-featured-event .ect-list-img {
     background-color: '.Ecttinycolor($featured_event_skin_color)->lighten(3)->toString().';
}
';
/*--- Featured Event Font Color - CSS ---*/
$ect_output_css.='
#ect-events-list-content .ect-list-post.ect-featured-event .ect-list-date .ect-date-area,
.ect-list-post.ect-featured-event .ect-list-date span.ect-custom-schedule,
.ect-list-post.ect-featured-event .ect-list-post-left .ect-list-date .ect-date-area,
.ect-list-post.ect-featured-event .ect-list-post-right .ect-list-venue .ect-icon,
.ect-list-post.ect-featured-event .ect-list-post-right .ect-list-venue .ect-venue-details,
.ect-list-post.ect-featured-event .ect-list-post-right .ect-list-venue .ect-google a,
.ect-list-post.ect-featured-event .ect-modern-time{
     color: '.$featured_event_font_color.';
}
';
/*--- Event Background Color - CSS ---*/
$ect_output_css.='
.ect-list-post .ect-list-post-right,
.ect-list-post .ect-clslist-event-info{
     background: '.$event_desc_bg_color.';
}
.ect-list-post .ect-list-post-right .ect-list-description {
     border-color : '.Ecttinycolor($event_desc_bg_color)->darken(10)->toString().';
     box-shadow : inset 0px 0px 25px -5px '.Ecttinycolor($event_desc_bg_color)->darken(10)->toString().';
}
.ect-list-post .ect-clslist-event-info {
     box-shadow: inset 0px 0px 25px -5px '.Ecttinycolor($event_desc_bg_color)->darken(10)->toString().';
}
.ect-list-post .ect-clslist-event-details {
     background: '.Ecttinycolor($event_desc_bg_color)->darken(4)->toString().';
     box-shadow: inset 0px 0px 25px -5px '.Ecttinycolor($event_desc_bg_color)->darken(10)->toString().';
}
@media (max-width: 790px) {
     .ect-list-post .ect-list-post-right .ect-list-description {
          border-bottom : 1px solid '.Ecttinycolor($event_desc_bg_color)->darken(10)->toString().';
     }
     .ect-list-post .ect-clslist-event-details {
          background:'.Ecttinycolor($event_desc_bg_color)->darken(4)->toString().';
     }
}
';
/*--- Event Title - CSS ---*/
$ect_output_css.='.ect-list-post h2.ect-list-title,
     .ect-list-post h2.ect-list-title a.ect-event-url{
          '.$title_styles.';
}
.ect-list-post h2.ect-list-title a:hover {
    color: '.Ecttinycolor($ect_title_color)->darken(10)->toString().';

}
.ect-list-post .ect-rate-area span.ect-icon,
.ect-list-post.style-2 .ect-rate-area span.ect-rate-icon,
.ect-list-post.style-1 span.ect-rate-icon,
.ect-list-post .ect-rate-area span.ect-rate,
.ect-list-post .ect-list-description .ect-event-content a {
	color: '.Ecttinycolor($ect_title_color)->lighten(15)->toString().';
}
';
/*--- Event Description - CSS ---*/
$ect_output_css.='
.ect-clslist-inner-container .ect-clslist-time,
.ect-list-post .ect-list-post-right .ect-list-description .ect-event-content p{
     '.$ect_desc_styles.';
}
.ect-list-post .ect-clslist-event-details a.tribe-events-read-more {
     color: '.$ect_desc_color.';
}
';
// var_dump($ect_venue_font_size);
$venue_font_sizes = $ect_venue_font_size+5;
/*--- Event Venue Color - CSS ---*/
$ect_output_css.='.ect-list-post .ect-list-venue .ect-venue-details,
     .ect-list-post .ect-list-venue .ect-google a,.modern-list-venue{
               '.$ect_venue_styles.';
     }
     .ect-list-post .ect-list-venue .ect-icon {
          color:'.$ect_venue_color.';
          font-size:'.$venue_font_sizes.'px;
     }
     .ect-list-post .ect-list-venue .ect-google a,
     .modern-list-venue .ect-google a{
          color: '.Ecttinycolor($ect_venue_color)->darken(3)->toString().';
     }
     ';
//Date
$ect_output_css.='.ect-list-post .ect-list-post-left .ect-list-date .ect-date-area,
     .ect-list-post .ect-list-post-left .ect-list-date span.ect-custom-schedule{
          '.$ect_date_style.';
     }
     #ect-events-list-content .ect-share-wrapper .ect-social-share-list a{
	color: '.$main_skin_color.';
}
#ect-events-list-content .ect-share-wrapper i.ect-icon-share:before {
	background: '.$main_skin_color.';
}
';
<?php
//Default List Main Skin Color
switch($style){
  case "style-1":
    /*--- Featured Event Color - CSS ---*/
    $ect_output_css.='
    #ect-slider-wrapper .ect-featured-event.style-1 .ect-slider-event-area {
    border-color: '.Ecttinycolor($featured_event_skin_color)->darken(7)->toString().';
    background: '.$thisPlugin::ect_hex2rgba($featured_event_skin_color, .94 ).';
    box-shadow : inset 0px 0px 25px -5px '.Ecttinycolor($featured_event_skin_color)->darken(7)->toString().';
    }
    ';
    /*--- Featured Event Font Color - CSS ---*/
     $ect_output_css .='
     #ect-slider-wrapper .ect-featured-event.style-1 .ect-slider-title h4,
	#ect-slider-wrapper .ect-featured-event.style-1 .ect-slider-title h4 a,
	#ect-slider-wrapper .ect-featured-event.style-1 .ect-slider-venue,
	#ect-slider-wrapper .ect-featured-event.style-1 .ect-slider-cost,
	#ect-slider-wrapper .ect-featured-event.style-1 .ect-slider-description .ect-event-content p{
          color: '.$featured_event_font_color.';
     }
     #ect-slider-wrapper .ect-featured-event.style-1 .ect-slider-venue a,
	#ect-slider-wrapper .ect-featured-event.style-1 .ect-slider-readmore a{
      color: '.Ecttinycolor($featured_event_font_color)->darken(5)->toString().';
     }';
    break;
    
  case "style-2":

    /*--- Main Skin Color - CSS ---*/
    $ect_output_css.='
    #ect-slider-wrapper .style-2 .ect-slider-date{
       background: '.$main_skin_color.';
    }
    #ect-slider-wrapper .style-2 .ect-slider-date {
		box-shadow : inset 0px 0px 12px -2px '.Ecttinycolor($main_skin_color)->darken(7)->toString().';
	}
    #ect-slider-wrapper .style-2 .ect-slider-title:before {
		box-shadow: 0px 2px 30px 1px '.Ecttinycolor($main_skin_color)->darken(7)->toString().';
	}
    ';
    /*--- Main Skin Alternate Color - CSS ---*/
    $ect_output_css.='
    #ect-slider-wrapper .style-2 .ect-slider-date{
        color: '.$main_skin_alternate_color.';
     }';
    /*--- Featured Event Color - CSS ---*/
     $ect_output_css.='
     #ect-slider-wrapper .ect-featured-event.style-2 .ect-slider-date {
		box-shadow : inset 0px 0px 25px -5px '.Ecttinycolor($featured_event_skin_color)->darken(7)->toString().';
		background: '.$featured_event_skin_color.';
	}
     #ect-slider-wrapper .ect-featured-event.style-2 .ect-slider-title:before {
		box-shadow: 0px 3px 20px 1px '.Ecttinycolor($featured_event_skin_color)->darken(7)->toString().';
	}
    ';
    /*--- Event Background Color - CSS ---*/
    $ect_output_css.='
    #ect-slider-wrapper .style-2 .ect-slider-left{
    	background: '.$event_desc_bg_color.';
    }
    #ect-slider-wrapper .style-2 .ect-slider-left{
    	box-shadow: inset 0 0 25px -5px '.Ecttinycolor($event_desc_bg_color)->darken(10)->toString().';
    }';
    break;
    
    case "style-3":
    /*--- Main Skin Color - CSS ---*/
    $ect_output_css.='
    #ect-slider-wrapper .style-3 .ect-slider-left {
		border-color: '.$main_skin_color.' ;
	}    
    ';
   /*--- Featured Event Color - CSS ---*/
     $ect_output_css.='
    		#ect-slider-wrapper .ect-featured-event.style-3 .ect-slider-left{
          border-color: '.Ecttinycolor($featured_event_skin_color)->darken(7)->toString().';
		background: '.$thisPlugin::ect_hex2rgba($featured_event_skin_color, .94 ).';
		box-shadow : inset 0px 0px 25px -5px '.Ecttinycolor($featured_event_skin_color)->darken(7)->toString().';
     }
    ';
     /*--- Featured Event Font Color - CSS ---*/
     $ect_output_css.='
     #ect-slider-wrapper .ect-featured-event.style-3 .ect-slider-title h4,
		#ect-slider-wrapper .ect-featured-event.style-3 .ect-slider-title h4 a,
		#ect-slider-wrapper .ect-featured-event.style-3 .ect-slider-venue,
		#ect-slider-wrapper .ect-featured-event.style-3 .ect-slider-cost{
        color:'.$featured_event_font_color.';
     }
     #ect-slider-wrapper .ect-featured-event.style-3 .ect-slider-venue a,
	#ect-slider-wrapper .ect-featured-event.style-3 .ect-slider-readmore a
	{
		color: '.Ecttinycolor($featured_event_font_color)->darken(5)->toString().';
	}
     ';
    /*--- Event Background Color - CSS ---*/
    $ect_output_css.='
    #ect-slider-wrapper .style-3 .ect-slider-left {
		box-shadow: inset 0 0 25px -5px '.Ecttinycolor($event_desc_bg_color)->darken(10)->toString().';
	}
    #ect-slider-wrapper .style-3 .ect-slider-left {
		background: '.$thisPlugin::ect_hex2rgba($event_desc_bg_color, .94 ).';
	}
    ';
    break;
}
    $ect_output_css.='
   #ect-slider-wrapper .ect-slider-right.ect-slider-image{
		border-color: '.$main_skin_color.';
	}
    ';
    /*--- Featured Event Color - CSS ---*/
    $ect_output_css.='
    #ect-slider-wrapper .ect-featured-event .ect-slider-right.ect-slider-image{
     border-color: '.Ecttinycolor($featured_event_skin_color)->darken(7)->toString().';
		 background: '.$thisPlugin::ect_hex2rgba($featured_event_skin_color, .94 ).';
		 box-shadow : inset 0px 0px 25px -5px '.Ecttinycolor($featured_event_skin_color)->darken(7)->toString().'}';
     /*--- Featured Event Font Color - CSS ---*/
     $ect_output_css.='
     #ect-slider-wrapper .ect-featured-event .ect-slider-date{
         color: '.$featured_event_font_color.';
     }
     ';
    /*--- Event Background Color - CSS ---*/
    $ect_output_css.='
     #ect-slider-wrapper .ect-slider-event-area{
          background-color: '.$event_desc_bg_color.';
     }
     #ect-slider-wrapper .ect-slider-event-area{
      	box-shadow: inset 0 0 25px -5px '.Ecttinycolor($event_desc_bg_color)->darken(10)->toString().';
     }
      #ect-slider-wrapper .ect-slider-image {
		background-color: '.Ecttinycolor($event_desc_bg_color)->darken(10)->toString().';
	}
	#ect-slider-wrapper .ect-events-slider .slick-arrow i {
		background-color: '.$event_desc_bg_color.';
		box-shadow: 2px 2px 0px 1px '.Ecttinycolor($event_desc_bg_color)->darken(1)->toString().';
	}
    ';
    /*--- Event Title - CSS ---*/
     $ect_output_css.='
    	#ect-slider-wrapper .ect-slider-title h4,
	#ect-slider-wrapper .ect-slider-title h4 a{
        '.$title_styles.';
     }
    ';
    /*--- Event Description - CSS ---*/
      $ect_output_css.='
    	#ect-slider-wrapper .ect-slider-description .ect-event-content p{
          '.$ect_desc_styles.';
     }
     #ect-slider-wrapper .ect-events-slider .slick-arrow {
		color: '.$ect_desc_color.';
	}
    ';
    $venue_font_sizes = $ect_venue_font_size+6;
    /*--- Event Venue Style - CSS ---*/
    $ect_output_css.='#ect-slider-wrapper .ect-slider-venue{
     '.$ect_venue_styles.';
    }
    #ect-slider-wrapper .ect-slider-cost {
		color:'.$ect_venue_color.';
		font-size:'.$venue_font_sizes.'px;
		font-family: '.$ect_venue_font_famiily.';
    font-weight:bold;
	}
	#ect-slider-wrapper .ect-slider-venue a,
	#ect-slider-wrapper .ect-slider-readmore a {
		color: '.Ecttinycolor($ect_venue_color)->darken(6)->toString().';
		font-family: '.$ect_venue_font_famiily.';
	}
	#ect-slider-wrapper .ect-slider-border:before {
		background: '.Ecttinycolor($ect_venue_color)->darken(6)->toString().';
	}
    ';
    /*--- Event Dates Styles - CSS ---*/
    $ect_output_css.='#ect-slider-wrapper .ect-slider-date{'.$ect_date_style.'}
    #ect-slider-wrapper .ect-share-wrapper .ect-social-share-list a{
	color: '.$main_skin_color.';
}
#ect-slider-wrapper .ect-share-wrapper i.ect-icon-share:before {
	background: '.$main_skin_color.';
}';

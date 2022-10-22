<?php 
if ( !defined( 'ABSPATH' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}
/**
 * This file is used to  generate slider layout  html.
 */
$slider_style=isset($attribute['style'])?$attribute['style']:'style-1';

$ev_post_img='';
$size='large';
$ev_post_img=ect_pro_get_event_image($event_id,$size='large');
$ect_cate = ect_display_category($event_id);

/**
* Slider view - style-3
*/
if($style=="style-3"){
    $events_html.='<div id="event-'. esc_attr($event_id) .'"'.$cat_colors_attr.' class="ect-slider-event '.$slider_style.' '.$event_type.'" itemscope itemtype="http://schema.org/Event">
                <div class="ect-slider-event-area">
                ';

    $events_html.='<div class="ect-slider-right ect-slider-image">
                <a href="'.esc_url(tribe_get_event_link($event_id)).'">
                <img src="'.$ev_post_img.'" title="'.get_the_title($event_id) .'" alt="'.get_the_title($event_id) .'">
                </a>';
    if($socialshare=="yes") { $events_html.=ect_pro_share_button($event_id); }
    $events_html.='</div>';

    $events_html.='<div class="ect-slider-left">
                <div class="ect-slider-date">
                '.wp_kses_post($event_schedule).'
                </div>';

    $events_html.='<div class="ect-slider-title"><h4>'.wp_kses_post($event_title).'</h4></div>';
    if(!empty($ect_cate)){
        $events_html.= '<div class="ect-event-category ect-slider-categories">';
        $events_html.= $ect_cate;
        $events_html.= '</div>';
    }


    if (tribe_has_venue($event_id) && $attribute['hide-venue']!="yes") {
        $events_html.='<div class="ect-slider-venue">'.wp_kses_post($venue_details_html).'</div>';
    }
    else {
        $events_html.='';
    }
    if($show_description=="yes"){
        $events_html.= '<div class="ect-slider-description">
                        '.wp_kses_post($event_content).'</div>';
        }
    if ( tribe_get_cost($event_id, true ) ) {
        $events_html.= '<div class="ect-slider-cost">'.$ev_cost.'</div>
                        <div class="ect-slider-readmore">
                        <a href="'.tribe_get_event_link($event_id).'" title="'.get_the_title($event_id) .'" rel="bookmark">'.__('Find out more','ect').'</a>
                        </div></div>';
    }
    else {
        $events_html.= '<div class="ect-slider-readmore full-view">
                        <a href="'.tribe_get_event_link($event_id).'" title="'.get_the_title($event_id) .'" rel="bookmark">'.__('Find out more','ect').'</a>
                        </div></div>';
    }

    $events_html.='</div></div>';
}

else if($style=='style-4'){
    $events_html.='
    <div id="event-'. esc_attr($event_id) .'"'.$cat_colors_attr.' class="ect-slider-event '.$slider_style.' '.$event_type.'" itemscope itemtype="http://schema.org/Event">
        <div class="ect-slider-event-area">
            <meta itemprop="image" content="'.$ev_post_img.'">
            <meta itemprop="description" content="'.esc_attr(wp_strip_all_tags( tribe_events_get_the_excerpt($event_id), true )).'">
            <div class="ect-slider-image-'.$slider_style.'">
                <a href="'.esc_url(tribe_get_event_link($event_id)).'">
                <img src="'.$ev_post_img.'" title="'.get_the_title($event_id) .'" alt="'.get_the_title($event_id) .'">
                </a>';
                $events_html.='<div class="ect-date-schedule"><div class="ect-date-schedule-wrap">
            '.$event_schedule.'</div></div>';
                if($socialshare=="yes") { 
                    $events_html.= '<div class="ect-share-wrapper-'.$slider_style.'">'.ect_pro_share_button($event_id);
                    $events_html.='</div>';
                }
            $events_html.='</div>';

            if(!empty($ect_cate)){
                $events_html.= '<div class="ect-event-category ect-slider-categories">';
                $events_html.= $ect_cate;
                $events_html.= '</div>';
            }
            
            $events_html.='
            
            <div class="ect-slider-title"><h4>'.$event_title.'</h4></div>';

            if (tribe_has_venue($event_id) && $attribute['hide-venue']!="yes") {
                $events_html.='<div class="ect-slider-venue">'.wp_kses_post($venue_details_html).'</div>';
            }
            else {
                $events_html.='';
            }
            if($show_description=="yes"){
                $events_html.= '<div class="ect-slider-description">
                '.$event_content.'</div>';
              }
            if ( tribe_get_cost($event_id, true ) ) {
                $events_html.= '<div class="ect-slider-cost">'.$ev_cost.'</div>
                            <div class="ect-slider-readmore">
                            <a href="'.esc_url(tribe_get_event_link($event_id)).'" title="'.get_the_title($event_id) .'" rel="bookmark">'.__('Find out more','ect').'</a>
                            </div>';
            }
            else {
                $events_html.= '<div class="ect-slider-readmore full-view">
                            <a href="'.esc_url(tribe_get_event_link($event_id)).'" title="'.get_the_title($event_id) .'" rel="bookmark">'.__('Find out more','ect').'</a>
                            </div>';
            }

        $events_html.='</div>
    </div>';
}    
/**
* Slider view - style-all
*/
else{
    $events_html.='<div id="event-'. esc_attr($event_id) .'"'.$cat_colors_attr.' class="ect-slider-event '.$slider_style.' '.$event_type.'" itemscope itemtype="http://schema.org/Event">
                <div class="ect-slider-event-area">
                ';

    $events_html.='<div class="ect-slider-right ect-slider-image">
                <a href="'.esc_url(tribe_get_event_link($event_id)).'">
                <img src="'.$ev_post_img.'" title="'.get_the_title($event_id) .'" alt="'.get_the_title($event_id) .'">
                </a>';
    if($socialshare=="yes") { $events_html.=ect_pro_share_button($event_id); }
    $events_html.='</div>';

    $events_html.='<div class="ect-slider-left">
                <div class="ect-slider-date">
                '.wp_kses_post($event_schedule).'
                </div>';

    $events_html.='<div class="ect-slider-title"><h4>'.wp_kses_post($event_title).'</h4></div>';

    if (tribe_has_venue($event_id) && $attribute['hide-venue']!="yes") {
        $events_html.='<div class="ect-slider-venue">'.wp_kses_post($venue_details_html).'</div>';
    }
    else {
        $events_html.='';
    }
    if($show_description=="yes" || $show_description==""){
    $events_html.= '<div class="ect-slider-description">
                    '.$event_content.'</div>';
    }
                    if(!empty($ect_cate)){
                        $events_html.= '<div class="ect-event-category ect-slider-categories">';
                        $events_html.= wp_kses_post($ect_cate);
                        $events_html.= '</div>';
                    }
             
   
    if ( tribe_get_cost($event_id, true ) ) {
        $events_html.= '<div class="ect-slider-cost">'.$ev_cost.'</div>
                        <div class="ect-slider-readmore">
                        <a href="'.esc_url(tribe_get_event_link($event_id)).'" title="'.get_the_title($event_id) .'" rel="bookmark">'.__('Find out more','ect').'</a>
                        </div></div>';
    }
    else {
        $events_html.= '<div class="ect-slider-readmore full-view">
                        <a href="'.esc_url(tribe_get_event_link($event_id)).'" title="'.get_the_title($event_id) .'" rel="bookmark">'.__('Find out more','ect').'</a>
                        </div></div>';
    }
   
    $events_html.='</div></div>';
}


   
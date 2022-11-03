<?php 
if ( !defined( 'ABSPATH' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}
/**
 * This file is used to  generate carousel layout  html.
 */
$carousel_style=isset($attribute['style'])?$attribute['style']:'style-1';
$ev_post_img='';
if(isset($attribute['columns'])&& $attribute['columns']>2){
    $size='medium';
}else{
    $size='large';
}
$ev_post_img=ect_pro_get_event_image($event_id,$size='large');
$ect_cate = ect_display_category($event_id);
/*
* carousel view style-1
*/
if($style=="style-1" || $style=="") {
    $events_html.='
    <div id="event-'. esc_attr($event_id) .'"'.$cat_colors_attr.' class="ect-carousel-event style-1 '.$event_type.' '.$evt_type.'" itemscope itemtype="http://schema.org/Event">
        <div class="ect-carousel-event-area">
            <meta itemprop="image" content="'.$ev_post_img.'">
            <meta itemprop="description" content="'.esc_attr(wp_strip_all_tags( tribe_events_get_the_excerpt($event_id), true )).'">
            <div class="ect-carousel-image">
                <a title="'.wp_kses_post(get_the_title($event_id)) .'"  href="'.esc_url(tribe_get_event_link($event_id)).'">
                <img src="'.$ev_post_img.'"  alt="'.get_the_title($event_id) .'">
                </a>';
                if($socialshare=="yes") { $events_html.=ect_pro_share_button($event_id); }
            $events_html.='</div>
            
            <div class="ect-carousel-date">'.wp_kses_post($event_schedule).'</div>';
            if(!empty($ect_cate)){
                $events_html.= '<div class="ect-event-category ect-carousel-categories">';
                $events_html.= $ect_cate;
                $events_html.= '</div>';
            }         
            $events_html.= '<div class="ect-carousel-title"><h4>'.wp_kses_post($event_title).'</h4></div>';

            if (tribe_has_venue($event_id) && $attribute['hide-venue']!="yes") {
                $events_html.='<div class="ect-carousel-venue">'.wp_kses_post($venue_details_html).'</div>';
            }
            else {
                $events_html.='';
            }

            if($show_description=="yes"){
                $events_html.= '<div class="ect-carousel-description">
                '.$event_content.'</div>';
              }
            if ( tribe_get_cost($event_id, true ) ) {
                $events_html.= '<div class="ect-carousel-cost">'.$ev_cost.'</div>
                            <div class="ect-carousel-readmore">
                            <a href="'.esc_url(tribe_get_event_link($event_id)).'" title="'.get_the_title($event_id) .'" rel="bookmark">'.__('Find out more','ect').'</a>
                            </div>';
            }
            else {
                $events_html.= '<div class="ect-carousel-readmore full-view">
                            <a href="'.esc_url(tribe_get_event_link($event_id)).'" title="'.get_the_title($event_id) .'" rel="bookmark">'.__('Find out more','ect').'</a>
                            </div>';
            }

        $events_html.='</div>
    </div>';
}

else if($style=='style-4'){
    $events_html.='
    <div id="event-'. esc_attr($event_id) .'"'.$cat_colors_attr.' class="ect-carousel-event '.$carousel_style.' '.$event_type.' '.$evt_type.'" itemscope itemtype="http://schema.org/Event">
        <div class="ect-carousel-event-area">
            <meta itemprop="image" content="'.$ev_post_img.'">
            <meta itemprop="description" content="'.esc_attr(wp_strip_all_tags( tribe_events_get_the_excerpt($event_id), true )).'">
            <div class="ect-carousel-image-'.$carousel_style.'">
                <a href="'.esc_url(tribe_get_event_link($event_id)).'">
                <img src="'.$ev_post_img.'" title="'.get_the_title($event_id) .'" alt="'.get_the_title($event_id) .'">
                </a>';
                $events_html.='<div class="ect-date-schedule"><div class="ect-date-schedule-wrap">
            '.$event_schedule.'</div></div>';
                if($socialshare=="yes") { 
                    $events_html.= '<div class="ect-share-wrapper-'.$carousel_style.'">'.ect_pro_share_button($event_id);
                    $events_html.='</div>';
                }
            $events_html.='</div>';

            if(!empty($ect_cate)){
                $events_html.= '<div class="ect-event-category ect-carousel-categories">';
                $events_html.= $ect_cate;
                $events_html.= '</div>';
            }
            
            $events_html.='
            
            <div class="ect-carousel-title"><h4>'.wp_kses_post($event_title).'</h4></div>';

            if (tribe_has_venue($event_id) && $attribute['hide-venue']!="yes") {
                $events_html.='<div class="ect-carousel-venue">'.wp_kses_post($venue_details_html).'</div>';
            }
            else {
                $events_html.='';
            }
            if($show_description=="yes"){
                $events_html.= '<div class="ect-carousel-description">
                '.$event_content.'</div>';
              }
            if ( tribe_get_cost($event_id, true ) ) {
                $events_html.= '<div class="ect-carousel-cost">'.$ev_cost.'</div>
                            <div class="ect-carousel-readmore">
                            <a href="'.esc_url(tribe_get_event_link($event_id)).'" title="'.get_the_title($event_id) .'" rel="bookmark">'.__('Find out more','ect').'</a>
                            </div>';
            }
            else {
                $events_html.= '<div class="ect-carousel-readmore full-view">
                            <a href="'.esc_url(tribe_get_event_link($event_id)).'" title="'.get_the_title($event_id) .'" rel="bookmark">'.__('Find out more','ect').'</a>
                            </div>';
            }

        $events_html.='</div>
    </div>';
}
/*
* carousel view style-2, 3
*/
else {
    $events_html.='
    <div id="event-'. esc_attr($event_id) .'"'.$cat_colors_attr.' class="ect-carousel-event '.$carousel_style.' '.$event_type.' '.$evt_type.'" itemscope itemtype="http://schema.org/Event">
        <div class="ect-carousel-event-area">
            <meta itemprop="image" content="'.$ev_post_img.'">
            <meta itemprop="description" content="'.esc_attr(wp_strip_all_tags( tribe_events_get_the_excerpt($event_id), true )).'">
            <div class="ect-carousel-image">
                <a href="'.esc_url(tribe_get_event_link($event_id)).'">
                <img src="'.$ev_post_img.'" title="'.get_the_title($event_id) .'" alt="'.get_the_title($event_id) .'">
                </a>';
                if($socialshare=="yes") { $events_html.=ect_pro_share_button($event_id); }
            $events_html.='</div>';

            if(!empty($ect_cate)){
                $events_html.= '<div class="ect-event-category ect-carousel-categories">';
                $events_html.= $ect_cate;
                $events_html.= '</div>';
            }
            
            $events_html.='
            <div class="ect-carousel-date">'.wp_kses_post($event_schedule).'</div>
            <div class="ect-carousel-title"><h4>'.wp_kses_post($event_title).'</h4></div>';

            if (tribe_has_venue($event_id) && $attribute['hide-venue']!="yes") {
                $events_html.='<div class="ect-carousel-venue">'.wp_kses_post($venue_details_html).'</div>';
            }
            else {
                $events_html.='';
            }
            if($show_description=="yes"){
                $events_html.= '<div class="ect-carousel-description">
                '.$event_content.'</div>';
              }
            if ( tribe_get_cost($event_id, true ) ) {
                $events_html.= '<div class="ect-carousel-cost">'.wp_kses_post($ev_cost).'</div>
                            <div class="ect-carousel-readmore">
                            <a href="'.esc_url(tribe_get_event_link($event_id)).'" title="'.get_the_title($event_id) .'" rel="bookmark">'.__('Find out more','ect').'</a>
                            </div>';
            }
            else {
                $events_html.= '<div class="ect-carousel-readmore full-view">
                            <a href="'.esc_url(tribe_get_event_link($event_id)).'" title="'.get_the_title($event_id) .'" rel="bookmark">'.__('Find out more','ect').'</a>
                            </div>';
            }

        $events_html.='</div>
    </div>';
}
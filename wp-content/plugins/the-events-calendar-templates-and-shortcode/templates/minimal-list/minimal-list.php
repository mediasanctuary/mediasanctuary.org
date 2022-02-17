<?php
/**
 * Get event status from The Events Calendar Extension: Events Control
 */
if (class_exists('Tribe\Extensions\EventsControl\Main')){
    $online_url = ''; 
    $get_status = get_post_meta( $event_id,'_tribe_events_control_status', true );
    $status = !empty($get_status)?$get_status:'scheduled';
    if($status=='canceled'){
        $reason = get_post_meta($event_id,'_tribe_events_control_status_canceled_reason', true);
    }
    elseif($status=='postponed'){
        $reason = get_post_meta($event_id,'_tribe_events_control_status_postponed_reason', true);
    }
    else{
        $reason = '';
    }
    $online = tribe_is_truthy( get_post_meta( $event_id,'_tribe_events_control_online', true ) );
    if($online){
        $online_url = get_post_meta( $event_id,'_tribe_events_control_online_url', true );
    }
}
else{
    $status='';
}
$ev_day=tribe_get_start_date($event_id, false, 'd' );
$ev_month=tribe_get_start_date($event_id, false, 'M' );
if($list_style=="style-1"){
    $events_html.='<div id="event-'.esc_attr($event_id).'" class="ect-list-posts '.esc_attr($list_style).' '.esc_attr($event_type).'">';
	$events_html.='<div class="ect-event-date-tag"><div class="ect-event-datetimes">
			        <span class="ev-mo">'.$ev_month.'</span>
			        <span class="ev-day">'.$ev_day.'</span>
			        </div></div>';
	$events_html.='<div class="ect-event-details">
                <div class="ect-event-datetime"><i class="ect-icon-clock"></i>
                <span class="ect-minimal-list-time">'.$ev_time.'</span></div>';
                if($status!=''){
                    $events_html.='<div class="ect-events-title">'.$event_title.'
                    <div class="ect-tool-tip-wrapper ect-labels-wrap"><span class="ect-labels-'.$status.'">'.$status.'</span>';
                    if($reason!=''||$online_url!=''){
                    $events_html.='<div class="ect-tip-inr">';
                    if(!empty($reason)){
                        $events_html.='<span class="ect-reason">'.$reason.'</span>';
                    }
                    if(!empty($online_url)){
                        $events_html.='<span class="ect-online-url">'.__('Live stream:-','epta').'<a href="'.$online_url.'"target="_blank">'.__('Watch Now','ect').'</a></span>';
                    }
                    $events_html.='</div>';
                    }
                    $events_html.='</div></div>';
                    }
                    else{
                        $events_html.='<div class="ect-events-title">'.$event_title.'</div>'; 
                    }
                    $events_html.='<div class="ect-'.$style.'-more"><a href="'.esc_url( tribe_get_event_link($event_id) ).'" class="ect-events-read-more" rel="bookmark">'.esc_html__( 'Find out more', 'the-events-calendar' ).' &raquo;</a></div>';
	$events_html.='</div></div>';
}
else if($list_style=="style-2"){
        $event_year = tribe_get_start_date( $event_id, true, 'F Y' );
        if ($event_year != $display_year) {
            $display_year = $event_year;
            if($last_year!= $display_year){
                $events_html.='<div class="ect-month-header">'.$display_year.'</div>';
            }
        }
        $events_html.='<div id="event-'.esc_attr($event_id).'" class="ect-list-posts '.esc_attr($list_style).' '.esc_attr($event_type).'" data-event-year="'.$display_year.'">';
        $events_html.='<div class="ect-event-date ect-schedule-wrp ect-date-viewport">
                <span class="ect-date-viewport">'.$ev_day.'</span>
                <span class="ect-month">'.$ev_month.'</span>
                </div>';
        $events_html.= '<div class="ect-right-wrapper">';
        if($status!=''){
            $events_html.='<div class="ect-events-title">'.$event_title.'
            <div class="ect-tool-tip-wrapper ect-labels-wrap"><span class="ect-labels-'.$status.'">'.$status.'</span>';
            if($reason!=''||$online_url!=''){
            $events_html.='<div class="ect-tip-inr">';
            if(!empty($reason)){
                $events_html.='<span class="ect-reason">'.$reason.'</span>';
            }
            if(!empty($online_url)){
                $events_html.='<span class="ect-online-url">'.__('Live stream:-','ect').'<a href="'.$online_url.'" target="_blank">'.__('Watch Now','ect').'</a></span>';
            }
            $events_html.='</div>';
            }
            $events_html.='</div></div>';
            }
            else{
                $events_html.='<div class="ect-events-title">'.$event_title.'</div>'; 
            }
        $events_html.='<div class="ect-'.$style.'-more"><a href="'.esc_url( tribe_get_event_link($event_id) ).'" class="ect-events-read-more" rel="bookmark">'.esc_html__( 'Find out more', 'the-events-calendar' ).' &raquo;</a></div>';
	    $events_html.='</div></div>';
}
else{
    $events_html.='<div id="event-'.esc_attr($event_id).'" class="ect-list-posts '.esc_attr($list_style).' '.esc_attr($event_type).'">';
    $events_html.='<div class="ect-left-wrapper">';
    $events_html.='<div class="ect-event-dates"><div class="ect-event-datetimes">
                <span class="ev-day">'.$ev_day.'</span>
                 <span class="ev-mo">'.$ev_month.'</span>
                <span class="ev-time">'.tribe_get_start_date($event_id, false, 'D' ).'</span>
                </div></div>';
    $events_html.='</div>'; 
    $events_html.='<div class="ect-right-wrapper">';
    if($status!=''){
        $events_html.='<div class="ect-events-title">'.$event_title.'
        <div class="ect-tool-tip-wrapper ect-labels-wrap"><span class="ect-labels-'.$status.'">'.$status.'</span>';
        if($reason!=''||$online_url!=''){
        $events_html.='<div class="ect-tip-inr">';
        if(!empty($reason)){
            $events_html.='<span class="ect-reason">'.$reason.'</span>';
        }
        if(!empty($online_url)){
            $events_html.='<span class="ect-online-url">'.__('Live stream:-','ect').'<a href="'.$online_url.'"target="_blank">'.__('Watch Now','ect').'</a></span>';
        }
        $events_html.='</div>';
        }
        $events_html.='</div></div>';
        }
        else{
            $events_html.='<div class="ect-events-title">'.$event_title.'</div>'; 
        }
                   
        $events_html.='<div class="ect-event-details"><span class="ect-minimal-list-time"><i class="ect-icon-clock"></i>
                    <span class="ect-minimal-list-time">'.$ev_time.'</span></span></div>';
    $events_html.='<div class="ect-'.$style.'-more"><a href="'.esc_url( tribe_get_event_link($event_id) ).'" class="ect-events-read-more" rel="bookmark">'.esc_html__( 'Find out more', 'the-events-calendar' ).' &raquo;</a></div>';
    $events_html .='</div>';
    $events_html.='</div>';
}
	
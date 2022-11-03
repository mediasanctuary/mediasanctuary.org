<?php
if ( !defined( 'ABSPATH' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}
/**
 * This file is used to  generate timeline layout  html.
 */
$timeline_style=$attribute['style'];
if($template=="timeline") {
	$timeline_style='style-1';
}
else if($template=="classic-timeline") {
	$timeline_style='style-2';
}


$ev_post_img='';
$size='large';
$ev_post_img=ect_pro_get_event_image($event_id,$size='large');
$ect_cate = ect_display_category($event_id);
if ($i % 2 == 0) {
	$even_odd = "even";
}
else {
	$even_odd = "odd";
}

if($timeline_style=="style-1" || $timeline_style=="style-4")
{
	if($events_date_header !=='' && $timeline_style=="style-1"){
		$events_html .= '<div class="ect-timeline-year">
						<div class="year-placeholder">' . $events_date_header . '</div>
						</div>';
	}
	if($events_date_header !=='' && $timeline_style=="style-4"){
		$events_html .= '<div class="ect-timeline-year-'.$timeline_style.'">
						<div class="year-placeholder">' . $events_date_header . '</div>
						</div>';	
	}	
									
	$events_html .= '<div id="event-'. esc_attr($event_id) .'"'.$cat_colors_attr.' class="ect-timeline-post '.$even_odd.' '.$event_type.' '.$timeline_style.'">';
	$events_html .= '<div class="timeline-meta">';
	$events_html .= $event_schedule;
	$events_html .= $venue_details_html;
	
		$events_html .= $ev_cost ;

	$events_html .= '</div>';
	if($timeline_style=="style-1"){	
	$events_html .= '<div class="timeline-dots"></div>';
	}
	if($timeline_style=="style-4"){	
		$events_html .= '<div class="timeline-dots-'.$timeline_style.'"></div>';
	}
	$events_html .= '<div class="timeline-content ' .$even_odd.'">';
	$events_html .= '<h2 class="content-title">' . wp_kses_post($event_title) .'</h2>';
	if($ev_post_img) {
		$events_html .= '<a class="timeline-ev-img" href="'.esc_url( tribe_get_event_link($event_id)).'"><img src= "'.$ev_post_img.'"/></a>';
	}
	if($show_description=="yes" || $show_description==""){
		$events_html.=wp_kses_post($event_content);
		}
		else{
			$events_html.= '<div class="ect-lslist-event-detail">
<a href="'.esc_url( tribe_get_event_link($event_id)).'" class="ect-events-read-more" rel="bookmark" '.$cat_bg_styles.'>'.esc_html__( 'Find out more', 'ect' ).'<i class="ect-icon-right-double"></i></a>
</div>';
	}
	//$events_html .= $event_content;
	if(!empty($ect_cate)){
		$events_html.= '<div class="ect-event-category ect-timeline-categories">';
		$events_html.= wp_kses_post($ect_cate);
		$events_html.= '</div>';
	}
	if($socialshare=="yes") { $events_html.=ect_pro_share_button($event_id); }
	$events_html .= '</div>';
	$events_html .= '</div>';
	$i++;
}

elseif($timeline_style=="style-2")
{
	if($events_date_header !==''){
		$events_html .= '<div class="ect-timeline-year">
						<div class="year-placeholder">' . wp_kses_post($events_date_header) . '</div>
						</div>';
	}		
									
	$events_html .= '<div id="event-'. esc_attr($event_id) .'"'.$cat_colors_attr.' class="ect-timeline-post even '.$event_type.' '.$timeline_style.'">';
	$events_html .= '<div class="timeline-meta">';
	$events_html .= wp_kses_post($event_schedule);
	$events_html .= wp_kses_post($venue_details_html);
	$events_html .= wp_kses_post($ev_cost) ;
	$events_html .= '</div>';	
	$events_html .= '<div class="timeline-dots"></div>';
	$events_html .= '<div class="timeline-content even">';
	if($ev_post_img) {
		$events_html .= '<a class="timeline-ev-img" href="'.esc_url( tribe_get_event_link($event_id)).'"><img src= "'.$ev_post_img.'"/></a>';
	}
	$events_html .= '<h2 class="content-title">' . $event_title .'</h2>';
	//$events_html .= '<img src= "'.$ev_post_img.'"/>';
	// $events_html .= $event_content;
	if($show_description=="yes" || $show_description==""){
		$events_html.=$event_content;
		}
		else{
			$events_html.= '<div class="ect-lslist-event-detail">
<a href="'.esc_url( tribe_get_event_link($event_id)).'" class="ect-events-read-more" rel="bookmark" '.$cat_bg_styles.'>'.esc_html__( 'Find out more', 'ect' ).'<i class="ect-icon-right-double"></i></a>
</div>';
	}
	if(!empty($ect_cate)){
		$events_html.= '<div class="ect-event-category ect-timeline-categories">';
		$events_html.= $ect_cate;
		$events_html.= '</div>';
	}
	if($socialshare=="yes") { $events_html.=ect_pro_share_button($event_id); }
	$events_html .= '</div>';
	$events_html .= '</div>';
}
else {
	if($events_date_header !==''){
		$events_html .= '<div class="ect-timeline-year">
						<div class="year-placeholder">' . wp_kses_post($events_date_header) . '</div>
						</div>';
	}		
									
	$events_html .= '<div id="event-'. esc_attr($event_id) .'"'.$cat_colors_attr.' class="ect-timeline-post even '.esc_attr($event_type).' '.esc_attr($timeline_style).'">';	
	$events_html .= '<div class="timeline-dots"></div>';
	$events_html .= '<div class="timeline-content even">';
	if(!empty($ect_cate)){
		$events_html.= '<div class="ect-event-category ect-timeline-categories">';
		$events_html.= wp_kses_post($ect_cate);
		$events_html.= '</div>';
	}
	$events_html .= '<h2 class="content-title">' . wp_kses_post($event_title) .'</h2>';
	//$events_html .= '<img src= "'.$ev_post_img.'"/>';
	$events_html .= '<div class="timeline-meta">';
	$events_html .= $event_schedule;
	$events_html .= $venue_details_html;
	$events_html .= $ev_cost ;
	if($socialshare=="yes") { $events_html.=ect_pro_share_button($event_id); }
	if($show_description=="yes"){
		$events_html.=$event_content;
		}
		else{
	$events_html .= '<a href="'.esc_url( tribe_get_event_link($event_id) ).'" class="ect-events-read-more" rel="bookmark">'.esc_html__( 'Find out more', 'ect' ).' &raquo;</a>';
		}
	$events_html .= '</div>';
	$events_html .= '</div>';
	$events_html .= '</div>';
}
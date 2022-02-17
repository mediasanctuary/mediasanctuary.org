<?php 
// A Custom function for get an option
if ( ! function_exists( 'ect_get_option' ) ) {
    function ect_get_option( $option = '', $default = null ) {
      $options = get_option( 'ects_options' ); // Attention: Set your unique id of the framework
      return ( isset( $options[$option] ) ) ? $options[$option] : $default;
    }
  }
/**
 * category Filter function
 */
function ect_cats_list() {
    $ect_cat_arr=array();
        if(version_compare(get_bloginfo('version'),'4.5.0', '>=') ){
            $terms = get_terms(array(
            'taxonomy' => 'tribe_events_cat',
            'hide_empty' =>true,
        ));
    }
    else{
        $terms = get_terms('tribe_events_cat', array('hide_empty' => true,) );
    }
    if (!empty($terms) || !is_wp_error($terms)) {
        $allPosts=0;
        foreach ($terms as $term) {
            $ect_cat_arr[$term->slug] =array("name"=>$term->name,"count"=>$term->count);
            $allPosts+=$term->count;	
        }
        $ect_cat_arr['all']=array("name"=>__('All','ect'),"count"=>$allPosts);
    }
    return $ect_cat_arr;
}
// generate category filters list HTML
function create_cat_filter_html($selected_cat,$post_per_page){
	$ect_all_categories=ect_cats_list();
    $html_output='';
    if(count($ect_all_categories)>1){
        $html_output .='<div class="ect-fitlers-wrapper">
        <ul class="ect-categories">';
        $active_cat='';
        asort($ect_all_categories);
        $prefetch='';
        foreach($ect_all_categories as $slug=> $details){
            $totalPosts=$details['count'];
            if($totalPosts>0){
            if($totalPosts>$post_per_page){
                $pages=ceil($totalPosts/$post_per_page);
            }else{
                $pages=0;
            }
                if($slug==$selected_cat){
                $active_cat='ect-active';
                $prefetch='true';
            }else{
                $active_cat='';
                $prefetch='false';
            }
            if($slug=="all"){
                $slug="";
            }else{
                $slug=$slug;
            }
        $html_output .= '<li data-paged="0" data-prefetch="'.$prefetch.'" 
         data-pages="'.$pages.'"
          data-posts="'.$totalPosts.'" class="ect-cat-items '.$active_cat.'"
            data-filter="'. $slug.'">'. $details['name'].'</li>';
        }
        } 
        $html_output.='</ul></div>';
        return $html_output;
    }
 }
// admin side timing
function ect_set_notice_timing(){
    if(version_compare(get_option('ect-v'),'1.7', '<')){		
        set_transient( 'ect-assn-timing', true, DAY_IN_SECONDS);
    }
    if( isset( $_GET['ect_disable_notice'] ) && !empty( $_GET['ect_disable_notice'] ) ){
        $rs=delete_transient( 'ect-assn-timing' );
        update_option('ect-v',ECT_VERSION);
    }
}
/**
 * This file is used to share events.
 * 
 * @package the-events-calendar-templates-and-shortcode/includes
 */
function ect_pro_share_button($event_id){
    $ect_sharecontent = '';
    $ect_geturl = urlencode(get_permalink($event_id));
    //$ect_geturl = get_permalink($event_id);
    $ect_gettitle = htmlspecialchars(urlencode(html_entity_decode(get_the_title($event_id), ENT_COMPAT, 'UTF-8')), ENT_COMPAT, 'UTF-8');
    $ect_getthumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $event_id ), 'full' );
    $subject= str_replace("+"," ",$ect_gettitle);
    // Construct sharing URL
      $ect_twitterURL = 'https://twitter.com/intent/tweet?text='.$ect_gettitle.'&amp;url='.$ect_geturl.'';
      $ect_whatsappURL = 'https://web.whatsapp.com/send?text='.$ect_gettitle . ' ' . $ect_geturl;
      $ect_facebookurl = 'https://www.facebook.com/sharer/sharer.php?u='.$ect_geturl.'';
      $ect_emailUrl = 'mailto:?Subject='.$subject.'&Body='.$ect_geturl.'';
      //$ect_linkedinUrl = "https://www.linkedin.com/sharing/share-offsite/?mini=true&amp;url=$ect_geturl";
      $ect_linkedinUrl = "http://www.linkedin.com/shareArticle?mini=true&amp;url=$ect_geturl";
      // Add sharing button at the end of page/page content
      $ect_sharecontent .= '<div class="ect-share-wrapper">';
      $ect_sharecontent .= '<i class="ect-icon-share"></i>';
      $ect_sharecontent .= '<div class="ect-social-share-list">';
      $ect_sharecontent .= '<a class="ect-share-link" href="'.$ect_facebookurl.'" target="_blank" title="Facebook" aria-haspopup="true"><i class="ect-icon-facebook"></i></a>';
      $ect_sharecontent .= '<a class="ect-share-link" href="'.$ect_twitterURL.'" target="_blank" title="Twitter" aria-haspopup="true"><i class="ect-icon-twitter"></i></a>';
      $ect_sharecontent .= '<a class="ect-share-link" href="'.$ect_linkedinUrl.'" target="_blank" title="Linkedin" aria-haspopup="true"><i class="ect-icon-linkedin"></i></a>';
      $ect_sharecontent .= '<a class="ect-email" href="'.$ect_emailUrl.' "title="Email" aria-haspopup="true"><i class="ect-icon-mail"></i></a>';
      $ect_sharecontent .= '<a class="ect-share-link" href="'.$ect_whatsappURL.'" target="_blank" title="WhatsApp" aria-haspopup="true"><i class="ect-icon-whatsapp"></i></a>';
      $ect_sharecontent .= '</div></div>';
        return $ect_sharecontent;
}
function ect_pro_get_event_image($event_id,$size){
	$default_img = ECT_PRO_PLUGIN_URL."assets/images/event-template-bg.png";
    $ev_post_img='';
    $feat_img_url = wp_get_attachment_image_src(get_post_thumbnail_id($event_id),$size);
    if(!empty($feat_img_url) && $feat_img_url[0] !=false){
        $ev_post_img = $feat_img_url[0];
        }elseif ($feat_img_url==''|| $feat_img_url==false){
            $tect_settings = get_option('ects_options');
            $non_feat_img = !empty($tect_settings['ect_no_featured_img'])?$tect_settings['ect_no_featured_img']:'';
            if(is_array($non_feat_img)){
                $non_feat_img_url = $non_feat_img['id'];
            }
            else{
                $non_feat_img_url = $non_feat_img;
            }
            if ($non_feat_img_url!='' && is_numeric( $non_feat_img_url ) ){
                $imageAttachment = wp_get_attachment_image_src( $non_feat_img_url,$size);
                $ev_post_img= $imageAttachment[0];
            }else{
                $ev_post_img=$default_img;
            }
        }else{
            $ev_post_img=$default_img;
        }
        return $ev_post_img;
}
function ect_display_category($event_id){
	$ect_cate = '';
	$ect_cate_sett = ect_get_option('ect_display_categoery' );
	if($ect_cate_sett=='ect_enable_cat'){
		$ect_cate = get_the_term_list($event_id, 'tribe_events_cat', '<ul class="tribe_events_cat"><li>', '</li><li>', '</li></ul>' );
	}
	return $ect_cate;
}


<?php
wp_enqueue_style('dashicons');
$num = wp_rand( 100, 9999 );
$options                   = get_option( 'ects_options' );
$main_skin_color           = ! empty( $options['main_skin_color'] ) ? $options['main_skin_color'] : '#dbf5ff';
$main_skin_alternate_color = ! empty( $options['main_skin_alternate_color'] ) ? $options['main_skin_alternate_color'] : '';
$output .= '<div id="ect-event-wrapper" class="ect-event-wrapper" data-random = "' . $num . '">';
// wp_enqueue_style('ect-common-styles', ECT_PRO_PLUGIN_URL . 'assets/css/ect-common-styles.css');
$filterbtn_css = "
    .ect-showfilter-btn {
        background-color: {$main_skin_color};
        color: {$main_skin_alternate_color};
    }
    .ect-showfilter-btn:hover {
        background-color: " . Ecttinycolor( $main_skin_color )->darken( 10 )->toString() . ";
        color: {$main_skin_alternate_color};
    }
";
wp_add_inline_style('ect-common-styles', $filterbtn_css);
if ( $filterbarstyle === 'filter' ) {
        $output .= '<div class="ect-filter-bar ect-filters-' . $filterbarstyle . '">';
        $output .= ect_get_filters_option( $attribute );
        $output .= '<span class="ect-clear-filter" style="display:none;" title="Clear">
                    <i class="dashicons dashicons-image-rotate"></i>
                </span>';
        $output .= '</div>';
        
        $output .= '<div id="ect-filter-loader" style="display:none;">
                    <div class="ect-filter-preloader" > </div>
               </div>';
} elseif ( $filterbarstyle === 'search' ) {
    $output .= '<div class="ect-filter-bar ect-filters-' . $filterbarstyle . '">';
    $output .= '<div class="ect-filter-group">
                    <i class="ect-icon-search"></i>
                    <input type="text" id="ect-fb-search" placeholder="Search...">
                </div>
                <span class="ect-clear-filter" style="display:none;" title="Clear">
                    <i class="dashicons dashicons-image-rotate"></i>
                </span>
                ';
    $output .= '</div>';
    $output .= '<div id="ect-filter-loader" style="display:none;">
                    <div class="ect-filter-preloader" > </div>
               </div>';
} else {
    $output .= '<div class="ect-filter-bar ect-filters-' . $filterbarstyle . '">';
    $output .= '<div class="ect-filterbar-main">
                    <div class="ect-filter-group">
                        <i class="ect-icon-search"></i>
                        <input type="text" id="ect-fb-search" placeholder="Search...">
                    </div>';
    $output .= '<div class="ect-showfilter-btn">'. __('Show Filters', 'ect') . '</div>';
    $output .= '  <span class="ect-clear-filter" style="display:none;" title="Clear">
                    <i class="dashicons dashicons-image-rotate"></i>
                </span>';
    $output .= '</div>';
    $output .= '<div class="ect-filterbar-filters">';
    $output .= ect_get_filters_option( $attribute );
    $output .= '</div>';
    $output .= '</div>';
    $output .= '<div id="ect-filter-loader" style="display:none;">
                    <div class="ect-filter-preloader" > </div>
               </div>';
}
$nonce_ect_filter = wp_create_nonce( 'ect-apply-filters' );
wp_localize_script(
    'ect-apply-filterbar-js',
    'ect_event_wrapper_' . $num,
    array(
        'url'             => admin_url( 'admin-ajax.php' ),
        'nonce'           => $nonce_ect_filter,
        'query'           => $ect_args,
        'hideVenue'       => $hide_venue,
        'socialShare'     => $socialshare,
        'showDescription' => $show_description,
        'template'        => $template,
        'dateFormat'      => $date_format,
        'style'           => $style,
        'attribute'       => $attribute,
        'loadmore_nonce'  => $load_nonce,
        'showFiltersText' => __('Show Filters', 'ect'),
        'hideFiltersText' => __('Hide Filters', 'ect'),
    )
);






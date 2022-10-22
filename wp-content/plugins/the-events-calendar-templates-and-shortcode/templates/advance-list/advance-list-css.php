<?php
// var_dump($ect_date_style);
$ect_output_css.="
.ect-featured-event a[rel='tag'], 
.ect-featured-event #ev-advance-date,
.ect-featured-event .ect-event-time,
.ect-featured-event .ect-event-content p,
.ect-featured-event td.ect-advance-list-tittle-name a,
.ect-featured-event #ect-viewmoreBtn span,
.ect-featured-event span.ect-venue-details.ect-address, 
.ect-featured-event span.ect-venue-details.ect-address .ect-google a
{
  color:$featured_event_font_color;
}
.ect-featured-event #ect-viewmoreBtn span{
    background: $featured_event_skin_color; 
}
.ect-advance-list.dataTable thead th,#ect-viewmoreBtn span{
    background-color: $main_skin_color; 
    color: $main_skin_alternate_color;  
}
select.ect-cat-filter,select.ect-tagFilter,.dataTables_wrapper .dataTables_filter input,
div.dataTables_length,div.dataTables_length label,div.dataTables_length select
{
    border-color: $main_skin_alternate_color !important;
    color: $main_skin_alternate_color;  
}
.dataTables_wrapper .dataTables_paginate .paginate_button.disabled,
.dataTables_wrapper .dataTables_paginate .paginate_button.current, .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover{
    color: $main_skin_alternate_color !Important;  
    border-color:$main_skin_alternate_color !Important;
}
.ect-advance-list-refresh{
    color: $main_skin_alternate_color;  
}
.dataTables_wrapper .dataTables_paginate .paginate_button.disabled, .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover, .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:active{
    color: $main_skin_alternate_color;  
}
td.ect-advance-list-tittle-name a{
    $title_styles
}
.ect-advance-list.dataTable thead th{
    font-family:$ect_title_font_famiily;
}
td.ect-advance-list-tittle-name a:hover {
    color: '.Ecttinycolor($ect_title_color)->darken(10)->toString().';
}
#ev-advance-date, .ect-event-time{
    font-size:".($ect_date_font_size-16)."px;
    color:$ect_date_color;
    font-family:$ect_date_font_family;
    font-weight:$ect_date_font_weight;
    font-style:$ect_date_font_style;
}
.ect-event-content p,a[rel='tag']{
    $ect_desc_styles
}
span.ect-venue-details.ect-address, 
span.ect-venue-details.ect-address .ect-google a{
    color:$ect_venue_color;
    font-size:".$ect_venue_font_size."px;
}";
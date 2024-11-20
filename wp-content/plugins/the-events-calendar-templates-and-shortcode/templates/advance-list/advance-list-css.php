<?php
$ect_output_css .= "
.ect-featured-event #ect-viewmoreBtn span{
    background: " . esc_attr($featured_event_skin_color) . ";
    color: " . esc_attr($featured_event_font_color) . ";
}
.ect-advance-list.dataTable thead th,#ect-viewmoreBtn span{
    background-color: " . esc_attr($main_skin_color) . ";
    color: " . esc_attr($main_skin_alternate_color) . ";
}

.dataTables_wrapper .dataTables_paginate .paginate_button.disabled,
.dataTables_wrapper .dataTables_paginate .paginate_button.current,
.dataTables_wrapper .dataTables_paginate .paginate_button.current:hover{
    color: " . esc_attr($main_skin_alternate_color) . " !Important;
    border-color:" . esc_attr($main_skin_alternate_color) . " !Important;
}

.dataTables_wrapper .dataTables_paginate .paginate_button.disabled, .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover, .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:active{
    color: " . esc_attr($main_skin_alternate_color) . ";
}

.ect-advance-list.dataTable thead th{
    font-family:$ect_title_font_famiily;
}

.ect-advance-list.dataTable td.ect-advance-list-tittle-name a,
.ect-advance-list.dataTable #ev-advance-date div span,
.ect-advance-list.dataTable td.ect-advance-list-catTag a ,
.ect-advance-list.dataTable td .ect-event-time,
.ect-advance-list.dataTable td.ect-advance-list-desc p,a[rel='tag'],
.ect-advance-list.dataTable td.ect-advance-list-venue
{
    " . $ect_desc_styles . ";

}
.ect-advance-list.dataTable tbody tr,
.ect-advance-list.dataTable tbody tr td{
    background-color:  " . esc_attr($event_desc_bg_color) . " !important;
}";

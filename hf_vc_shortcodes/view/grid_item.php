<?php
/**
 * @var HF_ShortCodes_DateFormat $obj
 */

use highfusion_vc_short_codes\hf_short_codes\impl\HF_ShortCodes_DateFormat;

$atts_extended = array();
parse_str( $data, $atts_extended );

$date_time_output = '';
if(strlen($data)>0 && !empty($atts_extended['atts']))
{

$date_time_output='<div class="cityfusion-datetime '.$atts_extended['atts']['custom_css_class'].'">';

$date_time_output.='<span class="cityfusion-date">_date_</span>';

    $date_time_output = $obj->cityfusion_formatDateFormat('_date_',$date_time_output,$atts_extended['atts'],$post);

if(boolval($atts_extended['atts']['show_time_part'])) {
    $date_time_output .= '&nbsp;<span class="cistyfusion-time">_time_</span>';
    $date_time_output = $obj->cityfusion_formatDateFormat('_time_',$date_time_output,$atts_extended['atts'],$post);
}
$date_time_output.='</div>';

}

return $date_time_output;



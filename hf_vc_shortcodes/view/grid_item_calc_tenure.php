<?php
/**
 * @var HF_ShortCodes_CalculateTenure $obj
 */

use highfusion_vc_short_codes\hf_short_codes\impl\HF_ShortCodes_CalculateTenure;

$atts_extended = array();
parse_str( $data, $atts_extended );

$dateTime_value = null;
if(isset($atts_extended['atts']['meta_field_name'])) {
	$dateTime_value = get_post_meta( $post->ID, $atts_extended['atts']['meta_field_name'], true );
}
$tenure = $obj->calculateTenure($dateTime_value);


$tenure_format = $atts_extended['atts']['text_undefined_field'];
if($tenure>1)
{
	$tenure_format = $atts_extended['atts']['text_before_field'];
}
if($tenure==1)
{
	$tenure_format = $atts_extended['atts']['text_after_field'];
}
https://git.assembla.com/highfusion/highfusion.vc.git

$output = '<div class="tenure-container '.$atts_extended['atts']['custom_css_class'].'">';
//$output.='<span class="tenure-before">'.$atts_extended['atts']['text_before_field'].'</span>';
$output.='&nbsp;<span class="tenure">'.preg_replace('/\{0\}/',$tenure,$tenure_format).'</span>&nbsp;';
/*if($tenure>0) {
	$output .= '<span class="tenure-after">' . $atts_extended['atts']['text_after_field'] . '</span>';
}*/
$output .= '</div>';

return $output;
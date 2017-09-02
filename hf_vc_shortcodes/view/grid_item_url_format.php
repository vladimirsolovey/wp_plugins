<?php
/**
 * @var WP_Post $post_value
 */
$attr_extended = array();
parse_str( $data, $attr_extended );
$output="";
$link_data = get_post_meta($post->ID,$attr_extended['attr']['custom_field_name'],true);

if(!empty($link_data))
{
    $prefix = '';
    $val = intval($link_data);
    if(is_int($val) && $val!=0)
    {
        $post_value = get_post($link_data);
        if($post_value)
        {
            $link_data = $post_value->guid;
        }

    }else
    {
        if($attr_extended['attr']['link_prefix']!='empty')
        {
         $prefix = $attr_extended['attr']['link_prefix'];
        }
    }

    $link_text = $link_data;

    if(isset($attr_extended['attr']['link_text']) && !empty($attr_extended['attr']['link_text']))
    {
        $link_text = $attr_extended['attr']['link_text'];
    }

    $output = "<div class='highfusion-formatted-url ".$attr_extended['attr']['custom_css_class']."' style='text-align:".$attr_extended['attr']['link_align']."'><a href='".$prefix.$link_data."' class='".$attr_extended['attr']['custom_css_class']."' target='".$attr_extended['attr']['target']."'> ".$link_text."</a></div>";
}
return $output;
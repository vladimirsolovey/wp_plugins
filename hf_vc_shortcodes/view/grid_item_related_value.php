<?php
/**
 * @val WP_Post $post
 */
$attr_extended = array();
parse_str( $data, $attr_extended );
$output="";
$related_post_id = get_post_meta($post->ID,$attr_extended['attr']['custom_field_name_with_post_id'],true);
if(!empty($related_post_id))
{
    $post_value = get_post($related_post_id);

    if($post_value)
    {
        $value = '';
        if(boolval($attr_extended['attr']['show_title_related_post']))
        {
            $value = $post_value->post_title;
        }else
        {
            $value = get_post_meta($post_value->ID, $attr_extended['attr']['custom_field_name_to_get_value_from'], true);
        }


        $output = "<div class='highfusion-vc-related-value ".$attr_extended['attr']['custom_css_class']."'>__LABEL_L__<span>__VALUE__</span>__LABEL_R__</div>";

        if(isset($attr_extended['attr']['label_text']) && !empty($attr_extended['attr']['label_text']))
        {
            if($attr_extended['attr']['label_align']=='right')
            {
                $output = preg_replace('/__LABEL_R__/',"&nbsp;<span>".$attr_extended['attr']['label_text']."</span>",$output);
                $output = preg_replace('/__LABEL_L__/',"",$output);
            }
            else
            {
                $output = preg_replace('/__LABEL_L__/',"<span>".$attr_extended['attr']['label_text']."</span>&nbsp;",$output);
                $output = preg_replace('/__LABEL_R__/',"",$output);
            }
        }
        else
        {
            $output = preg_replace('/__LABEL_L__/',"",$output);
            $output = preg_replace('/__LABEL_R__/',"",$output);
        }
        $output = preg_replace('/__VALUE__/',$value,$output);
    }
}

return $output;
<?php
/**
 * @val WP_Post $post
 */


$attr_extended = array();
parse_str( $data, $attr_extended );
$output="";
$post_categories = wp_get_post_terms($post->ID,$attr_extended['attr']['taxonomy']);
$index = 1;
$cat = array();
foreach($post_categories as $c)
{
    $cat[] = $c->name;
}
$string = implode("<span class='highfusion-vc-separator'>".$attr_extended['attr']['separator']."</span>",$cat);
$output = "<div>".$string."</div>";
return $output;
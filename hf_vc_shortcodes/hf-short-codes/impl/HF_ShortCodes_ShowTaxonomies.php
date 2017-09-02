<?php

namespace highfusion_vc_short_codes\hf_short_codes\impl;


use highfusion_vc_short_codes\hf_short_codes\HF_ShortCodes_BaseClass;
use highfusion_vc_short_codes\hf_short_codes\HF_ShortCodes_Interface;

class HF_ShortCodes_ShowTaxonomies extends HF_ShortCodes_BaseClass implements HF_ShortCodes_Interface
{

    private $default_options=array(
        'taxonomy'=>'',
        'number_to_display'=>'3',
        'separator'=>'|',
        'show_as_link'=>false
    );

    private $separator = array(
        ','=>',',
        ';'=>';',
        '|'=>'|'
    );

    function __construct($sc_name)
    {
        $this->sc_name = $sc_name;
        add_shortcode($sc_name,array($this,'renderShortCode'));
    }

    function load(){
        add_filter('vc_grid_item_shortcodes', array($this,'mapShortCodes') );
        add_filter('vc_gitem_template_attribute_taxonomies_list',array($this,'initAttributes'),10,2);
    }

    function renderShortCode($attr)
    {
        $this->options = shortcode_atts($this->default_options, $attr);
        return "{{taxonomies_list:".http_build_query(array('attr'=>$this->options))."}}";
    }


    function initShortCode()
    {

        $taxonomies = get_taxonomies();

        $params_high_fusion = array(
            array(
                "type"=>"dropdown",
                "holder"=>"div",
                "class"=>"",
                "heading"=>__("Taxonomy"),
                "param_name"=>"taxonomy",
                'save_always' => true,
                "value"=>$taxonomies,
                "description"=>__("Post's taxonomy.")
            ),
            array(
                'type' => 'textfield',
                'heading' =>'Number to Display',
                'param_name' => 'number_to_display',
                'value' => '3',
                'save_always' => true,
                'description' => 'Quantity of the post taxonomies to display',
            ),
            array(
                'type' => 'textfield',
                'heading' => 'Separator',
                'param_name' => 'separator',
                'value' =>'|',
                'save_always'=>true
            ),
            array(
                "type"=>"checkbox",
                "holder"=>"div",
                "class"=>"",
                "heading"=>__("Show as link"),
                "param_name"=>"show_as_link",
                "value"=>'',
                "save_always"=>true
            ),

        );

        $high_fusion_date_field = array(
            "name"=>__("Post Categories"),
            "base"=>$this->sc_name,
            "icon"=>'high-fusion-icon dashicons dashicons-screenoptions',
            "class"=>'',
            "category"=>$this->sc_category,
            "params"=>$params_high_fusion,
            "description"=>"Show post categories",
            'post_type' => 'vc_grid_item',
        );

        return $high_fusion_date_field;
    }

    function initAttributes($value, $data)
    {
        extract( array_merge( array(
            'post' => null,
            'data' => '',
            'obj'=>$this
        ), $data ) );

        return require(HF_VC_SC_PLUGIN_DIR.'view/grid_item_taxonomies.php');
    }


}
<?php

namespace highfusion_vc_short_codes\hf_short_codes\impl;


use highfusion_vc_short_codes\hf_short_codes\HF_ShortCodes_BaseClass;
use highfusion_vc_short_codes\hf_short_codes\HF_ShortCodes_Interface;


require_once(HF_VC_SC_PLUGIN_DIR.'hf-short-codes/HF_ShortCodes_Interface.php');
require_once(HF_VC_SC_PLUGIN_DIR.'hf-short-codes/HF_ShortCodes_BaseClass.php');

class HF_ShortCodes_RelatedValue extends HF_ShortCodes_BaseClass implements HF_ShortCodes_Interface
{
    private $default_options=array(
        'custom_field_name_with_post_id'=>'_EventVenueID',
        'custom_field_name_to_get_value_from'=>'_VenueVenue',
        'show_title_related_post'=>false,
        'label_text'=>'',
        'label_align'=>'left',
        'custom_css_class'=>'',
    );
    function __construct($sc_name)
    {
        $this->sc_name = $sc_name;
        add_shortcode($sc_name,array($this,'renderShortCode'));
    }
    function load()
    {
        add_filter('vc_grid_item_shortcodes', array($this,'mapShortCodes') );
        add_filter('vc_gitem_template_attribute_related_data',array($this,'initAttributes'),10,2);
    }

    function renderShortCode($attr)
    {
        $this->options = shortcode_atts($this->default_options,$attr);
        return "{{related_data:".http_build_query(array('attr'=>$this->options))."}}";
    }

    function initShortCode()
    {
        $params_high_fusion=array(
            array(
                'type' => 'textfield',
                'heading' =>'Meta Field Key',
                'param_name' => 'custom_field_name_with_post_id',
                'value' => '_EventVenueID',
                'save_always' => true,
                'description' => 'The Meta Field Name that contains ID of the related post',
            ),
            array(
                'type' => 'textfield',
                'heading' => 'Meta Field Name',
                'param_name' => 'custom_field_name_to_get_value_from',
                'value' =>'_VenueVenue',
                'save_always' => true,
                'description' => 'The Meta Field Name of the child post to read value from',
            ),
            array(
                "type"=>"checkbox",
                "holder"=>"div",
                "class"=>"",
                "heading"=>__("Show Title of the Related Post"),
                "param_name"=>"show_title_related_post",
                "value"=>'',
            ),
            array(
                'type' => 'textfield',
                'heading' => 'Label',
                'param_name' => 'label_text',
                'value' =>'',
                'save_always' => true,
                'description' => 'The Meta Field Name of the child post to read value from',
            ),
            array(
                'type' => 'dropdown',
                'heading' => 'Align',
                'param_name' => 'label_align',
                'value' =>array('right'=>'right','left'=>'left'),
                'std'=>'left',
                'save_always' => true,
            ),
            array(
                'type' => 'textfield',
                'heading' => 'CSS',
                'param_name' => 'custom_css_class',
                'value' =>'',
                'save_always' => true,
                'description' => 'Add Custom CSS class',
            ),


        );
        $high_fusion_date_field = array(
            "name"=>__("Related Meta"),
            "base"=>$this->sc_name,
            "icon"=>'high-fusion-icon dashicons dashicons-admin-links',
            "class"=>'',
            "category"=>$this->sc_category,
            "params"=>$params_high_fusion,
            "description"=>"Read meta data values from the child post",
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

        return require(HF_VC_SC_PLUGIN_DIR.'view/grid_item_related_value.php');
    }
}
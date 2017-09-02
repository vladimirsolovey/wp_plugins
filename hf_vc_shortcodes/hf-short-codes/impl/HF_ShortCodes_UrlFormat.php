<?php

namespace highfusion_vc_short_codes\hf_short_codes\impl;


use highfusion_vc_short_codes\hf_short_codes\HF_ShortCodes_BaseClass;
use highfusion_vc_short_codes\hf_short_codes\HF_ShortCodes_Interface;

require_once(HF_VC_SC_PLUGIN_DIR.'hf-short-codes/HF_ShortCodes_Interface.php');
require_once(HF_VC_SC_PLUGIN_DIR.'hf-short-codes/HF_ShortCodes_BaseClass.php');

class HF_ShortCodes_UrlFormat extends HF_ShortCodes_BaseClass implements  HF_ShortCodes_Interface
{

    private $default_options = array(
        'custom_field_name'=>'',
        'link_text'=>'',
        'link_prefix'=>'',
        'link_align'=>'',
        'target'=>'',
        'custom_css_class'=>''

    );

    private $link_prefix = array(
        ''=>'empty',
        'HTTP'=>'http://',
        'HTTPS'=>'https://',
        'MAILTO'=>'mailto:',

    );

    private $target = array(
        'New Window'=>'_blank',
        'Same Window'=>'_self'
    );

    function __construct($sc_name)
    {
        $this->sc_name = $sc_name;
        add_shortcode($sc_name,array($this,'renderShortCode'));
    }

    function renderShortCode($attr)
    {
        $this->options = shortcode_atts($this->default_options, $attr);

        return "{{url_formatted:".http_build_query(array('attr'=>$this->options,))."}}";
    }

    function initShortCode()
    {
        $params_high_fusion = array(
            array(
                'type' => 'textfield',
                'heading' =>'Custom Field Name',
                'param_name' => 'custom_field_name',
                'value' => '',
                'save_always' => true,
                'description' => '',
            ),
            array(
                'type' => 'textfield',
                'heading' =>'Link Text',
                'param_name' => 'link_text',
                'value' => '',
                'save_always' => true,
                'description' => 'Stay empty to use default value',
            ),
            array(
                'type' => 'dropdown',
                'heading' => 'Link Prefix',
                'param_name' => 'link_prefix',
                'value' =>$this->link_prefix,
                'std'=>'',
                'save_always' => true,
            ),
            array(
                'type' => 'dropdown',
                'heading' => 'Align',
                'param_name' => 'link_align',
                'value' =>array('right'=>'right','left'=>'left','center'=>'center'),
                'std'=>'left',
                'save_always' => true,
            ),
            array(
                'type' => 'dropdown',
                'heading' => 'Target',
                'param_name' => 'target',
                'value' =>$this->target,
                'std'=>'_self',
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
            "name"=>__("Formatted URL"),
            "base"=>$this->sc_name,
            "icon"=>'high-fusion-icon dashicons dashicons-paperclip',
            "class"=>'',
            "category"=>$this->sc_category,
            "params"=>$params_high_fusion,
            "description"=>"Format url",
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

        return require(HF_VC_SC_PLUGIN_DIR.'view/grid_item_url_format.php');
    }

    function load()
    {
        add_filter('vc_grid_item_shortcodes', array($this,'mapShortCodes') );
        add_filter('vc_gitem_template_attribute_url_formatted',array($this,'initAttributes'),10,2);
    }
}
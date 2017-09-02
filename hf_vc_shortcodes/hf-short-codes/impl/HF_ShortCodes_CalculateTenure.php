<?php


namespace highfusion_vc_short_codes\hf_short_codes\impl;


use highfusion_vc_short_codes\hf_short_codes\HF_ShortCodes_BaseClass;
use highfusion_vc_short_codes\hf_short_codes\HF_ShortCodes_Interface;

require_once(HF_VC_SC_PLUGIN_DIR.'hf-short-codes/HF_ShortCodes_Interface.php');
require_once(HF_VC_SC_PLUGIN_DIR.'hf-short-codes/HF_ShortCodes_BaseClass.php');

class HF_ShortCodes_CalculateTenure extends HF_ShortCodes_BaseClass implements HF_ShortCodes_Interface {


	private $default_options=array(
		'post_types'=>'person',
		'meta_field_name'=>'tenure',
		'text_before_field'=>'',
		'text_after_field'=>'',
		'text_undefined_field'=>'',
		'custom_css_class'=>''

	);

	function __construct($sc_name)
	{
		$this->sc_name = $sc_name;
		add_shortcode($sc_name,array($this,'renderShortCode'));
	}
	function load() {
		add_filter('vc_grid_item_shortcodes', array($this,'mapShortCodes') );
		add_filter('vc_gitem_template_attribute_calculate_tenure',array($this,'initAttributes'),10,2);
	}

	function renderShortCode($attr)
	{

		$this->options = shortcode_atts($this->default_options, $attr);

		return "{{calculate_tenure:".http_build_query(array('atts'=>$this->options,))."}}";
	}

	public function initShortCode()
	{
		$params_high_fusion = array(
			array(
				'type' => 'textfield',
				'heading' =>'Post Type',
				'param_name' => 'post_types',
				'value' => 'person',
				'save_always' => true,
				'description' => 'Select post type.',
			),
			array(
				'type' => 'textfield',
				'heading' => 'Field Name',
				'param_name' => 'meta_field_name',
				'value' =>'tenure',
				'save_always' => true,
				'description' => 'Set meta field name to format its value format.',
			),
			array(
				'type' => 'textfield',
				'heading' => 'Plural Value',
				'param_name' => 'text_before_field',
				'value' =>'',
				'save_always' => true,
				'description' => 'Format string. ex: {0} years',
			),
			array(
				'type' => 'textfield',
				'heading' => 'Singular Value',
				'param_name' => 'text_after_field',
				'value' =>'',
				'save_always' => true,
				'description' => 'Format string. ex: {0} year',
			),
			array(
				'type' => 'textfield',
				'heading' => 'Zero Value',
				'param_name' => 'text_undefined_field',
				'value' =>'Less then a year',
				'save_always' => true,
				'description' => 'String that will be use for undefined/zero value',
			),

			array(
				'type'=>'textfield',
				'heading'=>'CSS Class',
				'param_name'=>'custom_css_class',
				'value'=>'',
				'save_always'=>true,
				'description'=>'Add Custom CSS class'
			),
		);

		$high_fusion_date_field = array(
			"name"=>__("Tenure"),
			"base"=>$this->sc_name,
			"icon"=>'high-fusion-icon dashicons dashicons-universal-access',
			"class"=>'',
			"category"=>$this->sc_category,
			"params"=>$params_high_fusion,
			"description"=>"Calculate Tenure since start date",
			'post_type' => 'vc_grid_item',
		);

		return $high_fusion_date_field;
	}

	function initAttributes($value,$data)
	{
		extract( array_merge( array(
			'post' => null,
			'data' => '',
			'obj'=>$this
		), $data ) );

		return require(HF_VC_SC_PLUGIN_DIR.'view/grid_item_calc_tenure.php');
	}

	function calculateTenure($date_value)
	{
		if(!$date_value)
			return '';

		$tenure_time = strtotime($date_value);
		$today = time();
		$diff_time = floor(($today-$tenure_time)/(3600*24*365.25));
		return intval($diff_time);
	}
}
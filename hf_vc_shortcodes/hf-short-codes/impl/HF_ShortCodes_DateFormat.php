<?php

namespace highfusion_vc_short_codes\hf_short_codes\impl;


use highfusion_vc_short_codes\hf_short_codes\HF_ShortCodes_BaseClass;
use highfusion_vc_short_codes\hf_short_codes\HF_ShortCodes_Interface;

require_once(HF_VC_SC_PLUGIN_DIR.'hf-short-codes/HF_ShortCodes_Interface.php');
require_once(HF_VC_SC_PLUGIN_DIR.'hf-short-codes/HF_ShortCodes_BaseClass.php');

class HF_ShortCodes_DateFormat extends HF_ShortCodes_BaseClass implements HF_ShortCodes_Interface{

	static private $date_formats_list = array(
		'March 15th, 2017'=>'F jS, Y',
		'March 15, 2017'=>'F d, Y',
		'Mar 15, 2017'=>'M d, Y',
		'March 15th'=>'F jS',
		'March 15'=>'F d',
		'Mar 15'=>'M d',
		'Monday, March 15th, 2017'=>'l, F jS, Y',
		'11-02-2017'=>'m-d-Y',
		'11/02/2017'=>'m/d/Y',
		'11.02.2017'=>'m.d.Y',
		'Time Difference'=>'time_different'
	);

	static private $time_formats_list=array(
		'7:45 am' =>'g:i a',
		'13:56'=>'G:i'
	);
	private $default_options=array(
		'post_types'=>'tribe_events',
		'field_name'=>'_EventStartDate',
		'use_default_date'=>false,
		'field_date_format'=>'F jS, Y',
		'show_time_part'=>false,
		'field_time_format'=>'g:i a',
		'custom_css_class'=>''

	);



	function __construct($sc_name)
	{
		$this->sc_name = $sc_name;
		add_shortcode($sc_name,array($this,'renderShortCode'));
	}

	function load() {
		add_filter('vc_grid_item_shortcodes', array($this,'mapShortCodes') );
		add_filter('vc_gitem_template_attribute_format_date',array($this,'initAttributes'),10,2);
	}


	function renderShortCode($attr)
	{
		$this->options = shortcode_atts($this->default_options, $attr);

		return "{{format_date:".http_build_query(array('atts'=>$this->options,))."}}";
	}
	public function initShortCode()
	{
		$params_high_fusion = array(
			array(
				'type' => 'textfield',
				'heading' =>'Post Type',
				'param_name' => 'post_types',
				'value' => 'tribe_events',
				'save_always' => true,
				'description' => 'Select post type.',
			),
			array(
				'type' => 'textfield',
				'heading' => 'Field Name',
				'param_name' => 'field_name',
				'value' =>'_EventStartDate',
				'description' => 'Set meta field name to format its value format.',
			),
			array(
				"type"=>"checkbox",
				"holder"=>"div",
				"class"=>"",
				"heading"=>__("Use Post Date"),
				"param_name"=>"use_default_date",
				"value"=>'',
				"description"=>__("Format post's 'Published on' date")
			),
			array(
				'type'=>'dropdown',
				'heading'=>'Date Format',
				'param_name'=>'field_date_format',
				'value'=>self::$date_formats_list,
				'save_always' => true,
				'std'=>'F jS, Y',
				'description'=>'Select Date Format'
			),
			array(
				"type"=>"checkbox",
				"holder"=>"div",
				"class"=>"",
				"heading"=>__("Show Time"),
				"param_name"=>"show_time_part",
				"value"=>'',
			),
			array(
				'type'=>'dropdown',
				'heading'=>'Time Format',
				'param_name'=>'field_time_format',
				'value'=>self::$time_formats_list,
				'save_always'=>true,
				'std'=>'g:i a',
				'description'=>'Select Time Format'

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
			"name"=>__("Date Format"),
			"base"=>$this->sc_name,
			"icon"=>'high-fusion-icon dashicons dashicons-calendar-alt',
			"class"=>'',
			"category"=>$this->sc_category,
			"params"=>$params_high_fusion,
			"description"=>"Formatted date field",
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

		return require(HF_VC_SC_PLUGIN_DIR.'view/grid_item.php');
	}

	function cityfusion_formatDateFormat($replacePattern,$subject,$attributes,$post)
	{
		if(isset($attributes['use_default_date']) && boolval($attributes['use_default_date'])) {
			if (isset($attributes['field_date_format']) && $attributes['field_date_format'] == 'time_different') {
				$subject = preg_replace('/' . $replacePattern . '/', human_time_diff(get_the_time('U', $post->ID), current_time('timestamp')), $subject);
			} else {
				$subject = preg_replace('/' . $replacePattern . '/', get_the_time($attributes['field' . $replacePattern . 'format'], $post->ID), $subject);
			}
		}
		else
		{
			$dateTime_value = get_post_meta( $post->ID, $attributes['field_name'], true );


			if($dateTime_value)
			{
				$timestamp = strtotime($dateTime_value);
				if (isset($attributes['field_date_format']) && $attributes['field_date_format'] == 'time_different') {

					$subject = preg_replace('/' . $replacePattern . '/', human_time_diff($timestamp, current_time('timestamp')), $subject);
				}
				else {

					$subject = preg_replace('/' . $replacePattern . '/', date($attributes['field' . $replacePattern . 'format'], $timestamp), $subject);
				}
			}
			else
			{
				$subject = preg_replace('/'.$replacePattern.'/','',$subject);
			}
		}

		return $subject;
	}
}
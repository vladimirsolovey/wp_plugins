<?php

namespace highfusion_vc_short_codes\hf_short_codes;


abstract class HF_ShortCodes_BaseClass {

	protected $sc_category = "HighFusion";
	protected $sc_name;
	protected $options = array();
	abstract function renderShortCode($attr);
	//abstract function mapShortCodes(array $short_codes);
	abstract function initShortCode();
	abstract function initAttributes($value,$data);

	function mapShortCodes(array $short_codes)
	{
		$short_codes[$this->sc_name] = $this->initShortCode();
		return $short_codes;
	}
}
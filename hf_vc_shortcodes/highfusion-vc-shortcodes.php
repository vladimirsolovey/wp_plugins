<?php
/*
Plugin Name: Highfusion Shortcodes for VC
Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
Description: Extends Visual Composer with new ShortCodes
Version: 1.0
Author: Vladimir Solovey
Author URI: http://URI_Of_The_Plugin_Author
License: A "Slug" license name e.g. GPL2
*/

namespace highfusion_vc_short_codes;

use highfusion_vc_short_codes\hf_short_codes\impl\HF_ShortCodes_CalculateTenure;
use highfusion_vc_short_codes\hf_short_codes\impl\HF_ShortCodes_DateFormat;
use highfusion_vc_short_codes\hf_short_codes\impl\HF_ShortCodes_RelatedValue;
use highfusion_vc_short_codes\hf_short_codes\impl\HF_ShortCodes_ShowTaxonomies;
use highfusion_vc_short_codes\hf_short_codes\impl\HF_ShortCodes_UrlFormat;

define('HF_VC_SC_VERSION','1.0.0');
define('HF_VC_SC_ROOT_PATH',__FILE__);
define('HF_VC_SC_PLUGIN_URL',plugin_dir_url(HF_VC_SC_ROOT_PATH));
define('HF_VC_SC_PLUGIN_DIR',dirname(__FILE__)."/");

require_once(HF_VC_SC_PLUGIN_DIR.'hf-short-codes/impl/HF_ShortCodes_DateFormat.php');
require_once(HF_VC_SC_PLUGIN_DIR.'hf-short-codes/impl/HF_ShortCodes_CalculateTenure.php');
require_once(HF_VC_SC_PLUGIN_DIR.'hf-short-codes/impl/HF_ShortCodes_RelatedValue.php');
require_once(HF_VC_SC_PLUGIN_DIR.'hf-short-codes/impl/HF_ShortCodes_ShowTaxonomies.php');
require_once(HF_VC_SC_PLUGIN_DIR.'hf-short-codes/impl/HF_ShortCodes_UrlFormat.php');

if(!class_exists('HighFusion_VC_ShortCodes_Service')):

	class HighFusion_VC_ShortCodes_Service
	{
		private static $_instance;

		private function __construct(){
			register_activation_hook(__FILE__, array($this, 'activate'));
			register_deactivation_hook(__FILE__,array($this,'deactivate'));
		}
		function initService()
		{
			if(is_admin())
			{
				add_action("admin_enqueue_scripts", array($this,'initAdminResources'));
			}
			add_action('vc_before_init',array($this,'highfusion_Init_ShortCodes'));
		}


	    function highfusion_Init_ShortCodes()
	    {
		    $obj[] = new HF_ShortCodes_DateFormat('high_fusion_date_format');

			$obj[] = new HF_ShortCodes_CalculateTenure('high_fusion_calc_tenure');

			$obj[] = new HF_ShortCodes_RelatedValue('high_fusion_related_value');

			$obj[] = new HF_ShortCodes_ShowTaxonomies('high_fusion_show_taxonomies');

			$obj[] = new HF_ShortCodes_UrlFormat('high_fusion_url_formatted');

			foreach($obj as $o) {
				add_action('vc_after_set_mode', array($o, 'load'));
			}

	    }

		function activate()
		{

		}
		function deactivate()
		{

		}

		function initAdminResources()
		{
			wp_register_style('high-fusion-sc-style-css',HF_VC_SC_PLUGIN_URL.'content/css/hf-style.css');
			wp_enqueue_style('high-fusion-sc-style-css');
		}
		public static function getInstance()
		{

			if(!(self::$_instance instanceof self))
			{
				self::$_instance = new self();
			}
			return self::$_instance;
		}
	}
global $hf_vc_shortcodes;
if(!$hf_vc_shortcodes)
{
	$hf_vc_shortcodes = HighFusion_VC_ShortCodes_Service::getInstance();
	$hf_vc_shortcodes->initService();
}
endif;
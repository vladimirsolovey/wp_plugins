<?php
/*
Plugin Name: High Fusion SoundCloud Integration
Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
Description: HighFusion SoundCloud Service
Version: 1.0
Author: Solovey
Author URI: http://URI_Of_The_Plugin_Author
License: A "Slug" license name e.g. GPL2
*/
namespace SoundCloud;

use SoundCloud\classes\cron\HF_SoundCloud_Cron;
use SoundCloud\classes\HF_Autoloader;
use SoundCloud\classes\init\HF_SoundCloud_Init;

if ( !function_exists( 'add_action' ) ) {
	echo 'It is a plugin and you can\'t run it directly ';
	exit;
}

define('HF_SOUND_CLOUD_VERSION','1.0.0');
define('HF_SOUND_CLOUD_ROOT_PATH',__FILE__);
define('HF_SOUND_CLOUD_PLUGIN_URL',plugin_dir_url(HF_SOUND_CLOUD_ROOT_PATH));
define('HF_SOUND_CLOUD_PLUGIN_DIR',dirname(__FILE__)."/");


if(! class_exists('HF_SoundCloud')):
	class HF_SoundCloud{
		static private $instance;
		private $settigns = array(
			'vc-category-opt-name' => 'highfusion-soundcloud-vc-category',
			'vc-def-category'=>"HighFusion",
			'vc_active'=>false
		);
		function __construct()
		{
			register_activation_hook(__FILE__,array($this,'HF_SoundCloud_activation'));
			register_deactivation_hook(__FILE__,array($this,'HF_SoundCloud_deactivation'));
		}

		function init()
		{

			$this->init_autoload();


			HF_SoundCloud_Init::getInstance()->init();

			if(is_admin())
			{
				add_action('admin_enqueue_scripts', array($this, 'HF_SoundCloud_Admin_Resources'));
			}
			else {
				add_action( 'wp_enqueue_scripts', array( $this, 'HF_SoundCloud_Resources' ) );
			}
		}

		private  function init_autoload()
		{
			if ( !class_exists('HF_Autoloader')) {
				require_once HF_SOUND_CLOUD_PLUGIN_DIR.'/classes/Autoloader.php';
			}
			$autoloader = HF_Autoloader::getInstance();
			$autoloader->setPrefixes(array("SoundCloud"=>HF_SOUND_CLOUD_PLUGIN_DIR));
			$autoloader->register_autoloader();
		}

		function HF_SoundCloud_Resources(){
			wp_register_style('HF_SoundCloud_mainStyle', HF_SOUND_CLOUD_PLUGIN_URL . 'content/css/sound-cloud-style.css');
			wp_enqueue_style('HF_SoundCloud_mainStyle');
		}
		function HF_SoundCloud_Admin_Resources(){
			wp_register_style('HF_SoundCloud_Admin_Style', HF_SOUND_CLOUD_PLUGIN_URL . 'content/css/sc_style.css');
			wp_enqueue_style('HF_SoundCloud_Admin_Style');
		}

		function HF_SoundCloud_ShortCode_Init(){

		}
		function HF_SoundCloud_activation()
		{

		}

		function HF_SoundCloud_deactivation()
		{
			wp_clear_scheduled_hook(HF_SoundCloud_Cron::getAction());
		}

		static function getInstance()
		{
			if(!(self::$instance instanceof self))
			{
				self::$instance = new self();
			}
			return self::$instance;
		}
	}

	function HF_SoundCloud_Initialization()
	{
		global $hf_SoundCloud;
		if(!isset($hf_SoundCloud))
		{
			$hf_SoundCloud = HF_SoundCloud::getInstance();
			$hf_SoundCloud->init();
		}
	}
	HF_SoundCloud_Initialization();
endif;
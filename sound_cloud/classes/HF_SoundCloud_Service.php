<?php
/**
 * Date: 22.08.17
 * Time: 15:43
 */

namespace SoundCloud\classes;



use SoundCloud\api\SoundCloud;
use SoundCloud\classes\base\HF_SoundCloud_Base_Manager;
use WP_Post;

abstract class HF_SoundCloud_Service implements HF_SoundCloud_Interface {
	protected $settings = array(
		"capabilities"=>"manage_options",
		"scheduler_meta_key"=>'hf-sc-scheduler-'
	);
	protected $default_main_post_type = 'podcast-track';
	protected $import_post_type = 'sound_cloud_import';
	/**
	 * @var SoundCloud
     */
	protected $api;
	protected $input_fields = array('frequency','months','days','hours','user-name');

	protected static $_instance;
	abstract function init();

	function View($viewName, array $args=array())
	{

		ob_start();
		if(!empty($args)) {
			$args = apply_filters('WP_ACPT_IMPORT_view_arguments', $args, $viewName);

			foreach ($args AS $key => $val) {
				$$key = $val;
			}
		}

		$file = HF_SOUND_CLOUD_PLUGIN_DIR.'/view/'. $viewName . '.php';

		include( $file );

		$ret_obj= ob_get_clean();

		return $ret_obj;
	}

	function forward_manager(HF_SoundCloud_Base_Manager $obj)
	{

		$params = $obj->setManager();
		$obj->setNotifications($params);
		return $params;

	}
	function forward_request_manager(HF_SoundCloud_Base_Manager $obj,$page,$query=array())
	{

		try{

			$params = $this->forward_manager($obj);
			$query = array_merge($query,$params['query']);

			$page = isset($query['page'])?$query['page']:$page;

			if (!empty($params['warns'])) {
				wp_redirect(add_query_arg(array('page'=>$page,'warns'=>urlencode($params['warns'][0]),$query),admin_url('admin.php')));
				exit;
			} else {
				wp_redirect(add_query_arg(array('page'=>$page,'success'=>urlencode($params['success'][0]),$query),admin_url('admin.php')));
				exit;
			}
		}catch(\Exception $ex)
		{
			wp_redirect(add_query_arg(array('page'=>$page,'warns'=>urlencode($ex->getMessage()),$query),admin_url('admin.php')));
			exit;
		}

	}

	function getTimeStringFromDelta($time_delta)
	{
		$time_str = '';
		if($time_delta<MINUTE_IN_SECONDS)
		{
			$time_str = ceil($time_delta/MINUTE_IN_SECONDS)." seconds";

		}elseif($time_delta>=MINUTE_IN_SECONDS && $time_delta<HOUR_IN_SECONDS)
		{
			$time_str = round($time_delta/MINUTE_IN_SECONDS)." minutes";
		}
		elseif($time_delta>=HOUR_IN_SECONDS && $time_delta<DAY_IN_SECONDS)
		{
			$time_str = round($time_delta/HOUR_IN_SECONDS)." hours";
		}
		elseif($time_delta>=DAY_IN_SECONDS && $time_delta<MONTH_IN_SECONDS)
		{
			$time_str = round($time_delta/DAY_IN_SECONDS)." days";
		}
		elseif($time_delta>=MONTH_IN_SECONDS && $time_delta<YEAR_IN_SECONDS)
		{
			$time_str = round($time_delta/MONTH_IN_SECONDS)." months";
		}
		elseif($time_delta>=YEAR_IN_SECONDS)
		{
			$time_str = round($time_delta/MONTH_IN_SECONDS)." years";
		}
		return  "about ". $time_str." ago";
	}

	/**
	 * @param WP_Post $post
	 * @return string
	 */
	function getImported($post)
	{
		$total = get_post_meta($post->ID,$this->settings['scheduler_meta_key']."total",true);
		$last = get_post_meta($post->ID,$this->settings['scheduler_meta_key']."last-import-new",true);
		$out = '';
		$out.="<div class='hf-sc-row-import-all'>".($total?$total:0)." all time</div>";
		$out.="<label class='hf-sc-row-import-label'>Latest Import:</label>";
		$out.="<ul class='hf-sc-row-import-list'><li>".($last?$last:0)." new </li></ul>";
		return $out;
	}

	function getImportSchedulerPostId()
	{
		$args = array(
			'post_type'=>$this->import_post_type,
			'post_per_pages'=>-1,
			'post_status'=>'publish'
		);

		return get_posts($args);
	}
}
<?php
/**
 * Date: 22.08.17
 * Time: 19:39
 */

namespace SoundCloud\classes\base;

abstract class HF_SoundCloud_Base_Manager {

	protected $warn = array();
	protected $success = array();
	protected $response_params = array();

	function __construct()
	{

	}

	abstract function setManager();

	protected function is_empty($var)
	{
		return empty($var);
	}

	public function getWarnings()
	{
		return $this->warn;
	}
	public function setNotifications(&$params)
	{
		$params = array_merge($params,array('warns'=>$this->warn,'success'=>$this->success));
	}

}
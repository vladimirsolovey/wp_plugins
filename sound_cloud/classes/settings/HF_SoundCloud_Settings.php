<?php
/**
 * Date: 22.08.17
 * Time: 19:38
 */

namespace SoundCloud\classes\settings;

use SoundCloud\classes\base\HF_SoundCloud_Base_Manager;

class HF_SoundCloud_Settings extends HF_SoundCloud_Base_Manager{

	private $settings_name = "hf_sound_cloud_settings";
	private $settings_values = array();

	function show()
	{
		if(isset($_POST['client-id']))
		{
			if(empty($_POST['client-id']))
				$this->warn[] = "ClientId is require";

			if(empty($this->warn))
			{
				$this->settings_values['client-id']= $_POST['client-id'];
				update_option($this->settings_name,$this->settings_values);

				$this->success[] = "Client ID added successfully";
			}
		}
		$this->settings_values = get_option($this->settings_name);
		$this->response_params['settings'] = $this->settings_values;

	}

	function setManager() {
		$_REQUEST['a'] = (isset($_REQUEST['a']) && !empty($_REQUEST['a'])) ? $_REQUEST['a'] : 'show';
		switch($_REQUEST['a'])
		{
			case 'show':
				$this->show();
				break;

		}
		if(!isset($this->response_params['view']))
		{
			$this->response_params['view'] = 'settings/show';
		}
		if(!isset($this->response_params['query']))
		{
			$this->response_params['query'] = array();
		}
		return $this->response_params;
	}
}
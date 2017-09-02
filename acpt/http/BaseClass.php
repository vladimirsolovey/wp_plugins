<?php

/**
  * Date: 08.02.17
 * Time: 14:06
 */
namespace wichita_webmasters_acpt\http;
use wichita_webmasters_acpt\helpers\RequestService;
use wichita_webmasters_acpt\models\ModelContext;

require_once WWMACPT_PLUGIN_DIR.'helpers/RequestService.php';
require_once WWMACPT_PLUGIN_DIR.'models/ModelContext.php';

abstract class BaseClass
{
    protected $request;
    protected $db;
    protected $db_ctx;
    protected $warn = array();
    protected $success=array();
    protected $response_params =array();

    function __construct()
    {
        global $wpdb;
        $this->db = $wpdb;
        $this->db_ctx = new ModelContext();
        $this->request = new RequestService($_POST);
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
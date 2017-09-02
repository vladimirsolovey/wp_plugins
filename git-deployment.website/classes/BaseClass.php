<?php


namespace wp_git_deploy_service\classes;


use wp_git_deploy_service\helpers\GitService;
use wp_git_deploy_service\helpers\Request;
use wp_git_deploy_service\models\DBContext;

require_once( WP_GIT_DS_PLUGIN_DIR . '/helpers/Request.php' );
require_once( WP_GIT_DS_PLUGIN_DIR . '/models/DBContext.php' );
require_once( WP_GIT_DS_PLUGIN_DIR . '/helpers/GitService.php' );

abstract class BaseClass
{
    protected $warn = array();
    protected $success=array();
    protected $response_params =array();
    protected $dbc;
    protected $gitService;
    function __construct()
    {

        $this->gitService = new GitService();
        $this->dbc = new DBContext();
        $this->request = new Request($_REQUEST);
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
    protected function cleanNum($num)
    {
        return trim(preg_replace('/[^0-9]/','',$num));
    }
}
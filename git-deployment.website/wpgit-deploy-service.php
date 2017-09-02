<?php

/*
Plugin Name: WpGit Deploy Service
Plugin URI: http://highfusion.com
Description: Plugin integrates Git service into your wordpress.
Version: 1.0
Author: Vladimir Solovey
Author URI: http://highfusion.com
License: A "Slug" license name e.g. GPL2
*/

namespace wp_git_deploy_service;

use wp_git_deploy_service\classes\BaseDeployService;
use wp_git_deploy_service\classes\git_deploy_classes\GitDeployService;

define('WP_GIT_DS_VERSION','1.0.0');
define('WP_GIT_DS_ROOT_PATH',__FILE__);
define('WP_GIT_DS_PLUGIN_URL',plugin_dir_url(WP_GIT_DS_ROOT_PATH));
define('WP_GIT_DS_PLUGIN_DIR',dirname(__FILE__)."/");
define('WP_GIT_DS_CONTENT_DIR',ABSPATH.'wp-content');

require_once WP_GIT_DS_PLUGIN_DIR.'/classes/BaseDeployService.php';
require_once WP_GIT_DS_PLUGIN_DIR.'/classes/git-deploy-classes/GitDeployService.php';
if(!class_exists('WPGitDeployService')):

class WPGitDeployService extends BaseDeployService
{
    private static $_instance;

    private function __construct(){
        register_activation_hook(__FILE__, array($this, 'activate'));
        register_deactivation_hook(__FILE__,array($this,'deactivate'));
        //$this->init();
    }

    function init()
    {

        if(is_admin()) {
            add_action('admin_menu',array($this,'init_upload_menu'));
            add_action('admin_enqueue_scripts', array($this, 'init_admin_resources'));
        }
    }

    function init_upload_menu()
    {
        add_submenu_page('options-general.php','Git Deployment','Git Deployment','administrator','git-deploy-service',array($this,'gitService'));

        add_action('admin_init', array($this, 'requestSettings'));
    }

    function gitService()
    {
        $obj = new GitDeployService();
        $params = $this->forward_manager($obj);
        echo $this->View(isset($params['view'])?$params['view']:"base_view",array_merge(array("btObj"=>$obj),$params));

    }

    function addToGitRepo()
    {

    }
    function requestSettings()
    {
        if (((isset($_POST['git-save']) && !empty($_POST['git-save']) && $_POST['git-save'] == 1) || (isset($_REQUEST['id']) && !empty($_REQUEST['id']) && isset($_REQUEST['a']) && ($_REQUEST['a']=='del' || $_REQUEST['a']=='state' || $_REQUEST['a']=='clone' || $_REQUEST['a']=='init' || $_REQUEST['a']=='deploy'))) && $_REQUEST['page'] == 'git-deploy-service') {
            $obj = new GitDeployService();
            $this->forward_request_manager($obj,$_REQUEST['page']);
        }
    }

    function init_admin_resources()
    {
        wp_register_script('git-deploy-dataTables-js',WP_GIT_DS_PLUGIN_URL.'/content/js/dataTables/jquery.dataTables.min.js',array('jquery'));
        wp_enqueue_script('git-deploy-dataTables-js');
        wp_enqueue_style('git-deploy-dataTables-css',WP_GIT_DS_PLUGIN_URL.'/content/css/jquery.dataTables.min.css');
        wp_enqueue_script('cfps-admin-js',WP_GIT_DS_PLUGIN_URL.'/content/js/git.js',array('jquery'));
        wp_enqueue_style('cfps-admin-css',WP_GIT_DS_PLUGIN_URL.'/content/css/git-style.css');
    }

    function activate()
    {
        global $wpdb;

        if(!$this->hasGit())
        {
            deactivate_plugins(plugin_basename(__FILE__));
            wp_die("Git does not install on your system. Please install git first.");
        }else
        {


        $charset_collate = $wpdb->get_charset_collate();
        $table_name = $wpdb->prefix . 'git_projects';

        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`project_name` varchar(50) NOT NULL,
		`remote_git_url` text NOT NULL,
        `local_project_folder` text NOT NULL,
        `createdAt` int(11) NOT NULL,
        `deployedAt` int(11) DEFAULT NULL,
        `isInit` tinyint(4) NOT NULL DEFAULT '0',
        `clone` tinyint(4) NOT NULL DEFAULT '1',
        `username` varchar(50) NOT NULL,
        `password` varchar(50) NOT NULL,
        `use_credentials` varchar(50) NOT NULL,
        `active` tinyint(4) NOT NULL DEFAULT '0',

        PRIMARY KEY (`id`)
	    ) ENGINE=InnoDB AUTO_INCREMENT=0 $charset_collate";

        $wpdb->query($sql);
        //exit;
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );

            }

   }

    function deactivate()
    {
        global $wpdb;
        $table = $wpdb->prefix."git_projects";
        $wpdb->query("DROP TABLE IF EXISTS $table");

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
    function initWP_GIT_Deploy_Service()
    {
        global $wp_git_service;

        if(!isset($wp_git_service))
        {
            $wp_git_service = WPGitDeployService::getInstance();
            $wp_git_service->init();
        }

    }
    initWP_GIT_Deploy_Service();
endif;

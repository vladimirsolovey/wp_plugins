<?php
/*
Plugin Name: Advanced Custom Post Type
Plugin URI: wichitawebmasters.com
Description: Add your own custom post types, taxonomies.
Version: 1.0
Author: Vladimir Solovey - Wichita Webmasters (www.wichita.com)
Author URI: http://www.wichita.com
*/
namespace wichita_webmasters_acpt;

use wichita_webmasters_acpt\helpers\BaseService;
use wichita_webmasters_acpt\http\ACPTRolesService;
use wichita_webmasters_acpt\http\ACPTService;
use wichita_webmasters_acpt\http\ACPTTaxonomyService;

define('WWMACPT_VERSION','1.0.0');
define('WWMACPT_ROOT_PATH',__FILE__);
define('WWMACPT_PLUGIN_URL',plugin_dir_url(WWMACPT_ROOT_PATH));
define('WWMACPT_PLUGIN_DIR',dirname(__FILE__)."/");//plugin_dir_path(WWM_ACPT_ROOT_PATH));

require_once WWMACPT_PLUGIN_DIR.'helpers/BaseService.php';
require_once WWMACPT_PLUGIN_DIR.'http/ACPTService.php';
require_once WWMACPT_PLUGIN_DIR.'http/ACPTRolesService.php';
require_once WWMACPT_PLUGIN_DIR.'http/ACPTTaxonomyService.php';

if(!class_exists('WWMCustomPostType')):

    class WWMCustomPostType extends BaseService
    {
        private static $_instance;

        function __construct()
        {
            parent::__construct();
            register_activation_hook(WWMACPT_ROOT_PATH, array($this, 'activate'));


        }

        function init()
        {
            add_action('init', array($this, 'register_taxonomies'),0);
            add_action('init', array($this, 'register_post_types'));


            if (is_admin()) {
                add_action('admin_init', array($this, 'check_version'));
                add_action('admin_menu', array($this, "initAdminMenu"));
                add_action('admin_enqueue_scripts', array($this, 'registerContent'));
            }

        }

        function initAdminMenu()
        {
            global $acpt_admin_menu_hook, $menu;

            $capability = get_option("wwm_acpt_capability", 'manage_options');

            $acpt_admin_menu_hook = add_menu_page('ACPT Tools', 'ACPT Tools', $capability, 'wwm-post-type', array($this, 'ACPTService'), 'dashicons-clipboard', 99.1);
            add_submenu_page('wwm-post-type', 'Custom Post Types', 'Custom Post Types', $capability, 'wwm-post-type', array($this, 'ACPTService'));
            add_submenu_page('wwm-post-type', 'Custom Taxonomies Manager', 'Custom Taxonomies', $capability, 'wwm-taxonomies', array($this, 'ACPTTaxonomyService'));
            add_submenu_page(null, "Custom Post Roles", "Custom Post Roles", $capability, 'wwm-post-type-roles', array($this, 'ACPTRolesService'));
            add_action('admin_init', array($this, 'RequestManager'));

        }

        function register_post_types()
        {
            $cutom_post_type_list = get_option('wwm_custom_post_type');

            if (empty($cutom_post_type_list))
                return;
            if (is_array($cutom_post_type_list)) {
                foreach ($cutom_post_type_list as $key => $val) {

                    $res = register_post_type($key, $val);
                    if(is_wp_error($res))
                    {
                        var_dump($res->get_error_message());
                    }
                }
            }

        }

        function register_taxonomies()
        {
            $taxonomies = get_option('wwm_taxonomies');

            if (empty($taxonomies))
                return;
            if (is_array($taxonomies)) {
                foreach ($taxonomies as $key => $val) {
                    $object = $val['object_type'];

                    unset($val['object_type']);
                    register_taxonomy($key, $object[0], $val);
                }
            }
        }

        function ACPTService()
        {
            $obj = new ACPTService();

            $params = $this->forward_manager($obj);
            echo $this->View(isset($params['view']) ? $params['view'] : "base_view", array_merge(array("Obj" => $obj), $params));
        }

        function ACPTTaxonomyService()
        {
            $obj = new ACPTTaxonomyService();
            $params = $this->forward_manager($obj);
            echo $this->View(isset($params['view']) ? $params['view'] : "base_view", array_merge(array("Obj" => $obj), $params));
        }

        function ACPTRolesService()
        {
            $obj = new ACPTRolesService($_REQUEST['post-type']);
            $params = $this->forward_manager($obj);
            echo $this->View(isset($params['view']) ? $params['view'] : "base_view", array_merge(array("Obj" => $obj), $params));

        }

        function RequestManager()
        {
            if (((isset($_POST['wwm-save']) && !empty($_POST['wwm-save']) && $_POST['wwm-save'] == 1) || (isset($_REQUEST['a']) && $_REQUEST['a'] == 'del')) && ($_REQUEST['page'] == 'wwm-post-type')) {

                $obj = new ACPTService();

                $this->forward_request_manager($obj, $_REQUEST['page']);
            }
            if (((isset($_POST['wwm-save']) && !empty($_POST['wwm-save']) && $_POST['wwm-save'] == 1) || (isset($_REQUEST['a']) && $_REQUEST['a'] == 'del')) && ($_REQUEST['page'] == 'wwm-post-type-roles')) {
                $obj = new ACPTRolesService($_REQUEST['post-type']);
                $this->forward_request_manager($obj, $_REQUEST['page'], array('post-type' => $_REQUEST['post-type']));
            }

            if (((isset($_POST['wwm-save']) && !empty($_POST['wwm-save']) && $_POST['wwm-save'] == 1) || (isset($_REQUEST['a']) && $_REQUEST['a'] == 'del')) && ($_REQUEST['page'] == 'wwm-taxonomies')) {

                $obj = new ACPTTaxonomyService();

                $this->forward_request_manager($obj, $_REQUEST['page']);
            }
        }

        function activate()
        {
            register_deactivation_hook(__FILE__, array($this, 'deactivate'));

            if (!$this->check_php_version()) {
                deactivate_plugins(plugin_basename(__FILE__));
                wp_die('My Plugin requires PHP 5.1 or higher! Your version is '.PHP_VERSION);
            }
        }

        function deactivate()
        {
            delete_option("wwm_custom_post_type");
            delete_option("wwm_taxonomies");
        }

        function check_version()
        {
            if (!$this->check_php_version()) {
                if (is_plugin_active(plugin_basename(__FILE__))) {
                    deactivate_plugins(plugin_basename(__FILE__));
                    add_action('admin_notices', array($this, 'disabled_notice'));

                    if (isset($_GET['activate'])) {
                        unset($_GET['activate']);
                    }
                }
            }
        }

        function disabled_notice()
        {
            echo '<strong>' . esc_html__( 'My Plugin requires PHP 5.1 or higher! Your version is '.PHP_VERSION, 'wwm-acpt' ) . '</strong>';
        }
        function check_php_version()
        {
            if(version_compare(PHP_VERSION,'5.1','<'))
            {
                return false;
            }
            return true;
        }
        function registerContent()
        {
            wp_register_script('wwm-acpt-dataTables-js',WWMACPT_PLUGIN_URL.'content/js/dataTables/jquery.dataTables.min.js',array('jquery'));
            wp_enqueue_script('wwm-acpt-dataTables-js');
            wp_enqueue_style('wwm-acpt-datatables-css',WWMACPT_PLUGIN_URL.'content/css/jquery.dataTables.min.css');
            wp_enqueue_script('wwm-acpt-admin-js',WWMACPT_PLUGIN_URL.'content/js/acpt.js',array('jquery'));
            wp_enqueue_style('wwm-acpt-admin-css',WWMACPT_PLUGIN_URL.'content/css/style-acpt.css');
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

    function initWWM_ACPT()
    {
        global $wwm_acpt;

        if(!isset($wwm_acpt))
        {
            $wwm_acpt = WWMCustomPostType::getInstance();
            $wwm_acpt->init();
        }
    }
    initWWM_ACPT();
endif;
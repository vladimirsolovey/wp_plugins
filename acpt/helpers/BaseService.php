<?php
/**
  * Date: 08.02.17
 * Time: 14:18
 */

namespace wichita_webmasters_acpt\helpers;


use wichita_webmasters_acpt\http\BaseClass;

class BaseService
{
    function __construct()
    {

    }
    function View($viewName, array $args=array())
    {

        ob_start();
        if(!empty($args)) {
            $args = apply_filters('WWM_ACPT_view_arguments', $args, $viewName);

            foreach ($args AS $key => $val) {
                $$key = $val;
            }
        }

        $file = WWMACPT_PLUGIN_DIR.'/view/'. $viewName . '.php';

        include( $file );

        $ret_obj= ob_get_clean();

        return $ret_obj;
    }

    function forward_manager(BaseClass $obj)
    {

        $params = $obj->setManager();
        $obj->setNotifications($params);
        return $params;

    }
    function forward_request_manager(BaseClass $obj,$page,$query=array())
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
}
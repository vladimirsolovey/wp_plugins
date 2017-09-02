<?php
/**
  * Date: 08.02.17
 * Time: 16:51
 */

namespace wichita_webmasters_acpt\models;


class BaseModel
{
    protected $db;
    protected $option_name;
    function __construct()
    {
        global $wpdb;
        $this->db= $wpdb;
        $wpdb->show_errors = true;
        $wpdb->suppress_errors = false;
    }

    protected function getOption()
    {
        $res = get_option($this->option_name);
        if($res)
        {
            return $res;
        }
        return array();
    }

}
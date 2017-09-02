<?php


namespace wp_git_deploy_service\models;


class BaseModel
{
    protected $db;
    protected $table;

    function __construct()
    {
        global $wpdb;
        $this->db = $wpdb;
        $wpdb->show_errors     = true;
        $wpdb->suppress_errors = false;

    }
    protected function cleanNum($num)
    {
        return trim(preg_replace('/[^0-9]/','',$num));
    }
}
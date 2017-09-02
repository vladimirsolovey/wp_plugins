<?php


namespace wp_git_deploy_service\models;


use wp_git_deploy_service\models\impl\Projects;
require_once WP_GIT_DS_PLUGIN_DIR.'/models/impl/Projects.php';
class DBContext
{
    /**
     * @var Projects
     */
    private $projects;

    function __construct()
    {
        $this->projects = new Projects();
    }

    /**
     * @return Projects
     */
    public function getProjects()
    {
        return $this->projects;
    }


}
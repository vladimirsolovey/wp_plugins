<?php


namespace wp_git_deploy_service\models\impl;


use wp_git_deploy_service\models\BaseModel;
use wp_git_deploy_service\models\IProjects;
use wp_git_deploy_service\objects\Project;

require_once WP_GIT_DS_PLUGIN_DIR.'/models/IProjects.php';
require_once WP_GIT_DS_PLUGIN_DIR.'/models/BaseModel.php';


class Projects extends BaseModel implements IProjects
{

    function __construct()
    {
        parent::__construct();
        $this->table = $this->db->prefix."git_projects";
    }


    /**
     * @param Project $project
     * @return mixed|void
     */
    function create(Project $project)
    {

        $query = $this->db->prepare("INSERT INTO $this->table (project_name,remote_git_url,local_project_folder,createdAt,deployedAt,isInit,clone,username,password,use_credentials,active)VALUES(%s,%s,%s,%d,%d,%d,%d,%s,%s,%d,%d)",
            $project->getName(),
            $project->getRemoteGitUrl(),
            $project->getLocalFolder(),
            $project->getCreatedAt(),
            $project->getLastDeployedAt(),
            $project->isInitProject(),
            $project->isHaveToClone(),
        $project->getUsername(),
        $project->getPassword(),
        $project->isUseCredentials(),
            $project->isActive());

         return $this->db->query($query);

    }

    /**
     * @param int $id
     * @return mixed|void
     */
    function delete($id)
    {
        $res = $this->db->prepare("DELETE FROM $this->table WHERE id=%d",$id);
        return $this->db->query($res);
    }

    function update(Project $project)
    {

        $query = $this->db->prepare("UPDATE $this->table SET project_name=%s,remote_git_url=%s,local_project_folder=%s,createdAt=%d,deployedAt=%d,isInit=%d,clone=%d,username=%s,password=%s,use_credentials=%d,active=%d WHERE id=%d",
            $project->getName(),
            $project->getRemoteGitUrl(),
            $project->getLocalFolder(),
            $project->getCreatedAt(),
            $project->getLastDeployedAt(),
            $project->isInitProject(),
            $project->isHaveToClone(),
        $project->getUsername(),
        $project->getPassword(),
        $project->isUseCredentials(),
            $project->isActive(),
            $project->getId());


        $res = $this->db->query($query);
        if($res==0) {
            return true;
        }
        return $res;
    }

    function getById($id)
    {
        if($id==null)
        {
            return null;
        }
        $query = $this->db->prepare("SELECT * FROM $this->table WHERE id=%d",$id);
        $res = $this->db->get_row($query);
        if($res!=null && !empty($res))
        {
            return $this->initProject($res);
        }
        return null;

    }

    /**
     * @return Project[]
     */
    function getAll()
    {
        $res = $this->db->get_results("SELECT * FROM $this->table WHERE id!=0");

        $projects = array();
        foreach($res as $r)
        {
            $projects[] = $this->initProject($r);
        }
        return $projects;
    }

    function openClose($id, $state)
    {
        switch($state)
        {
            case 'open':
                $this->db->query("UPDATE $this->table SET active=1 WHERE id=".$id);
                break;
            case 'close':
                $this->db->query("UPDATE $this->table SET active=0 WHERE id=".$id);
                break;
        }
    }

    private function initProject($r)
    {
        $prj = new Project();
        $prj->setId($r->id);
        $prj->setName($r->project_name);
        $prj->setRemoteGitUrl($r->remote_git_url);
        $prj->setLocalFolder($r->local_project_folder);
        $prj->setCreatedAt($r->createdAt);
        $prj->setLastDeployedAt($r->deployedAt);
        $prj->setInitProject($r->isInit);
        $prj->setHaveToClone($r->clone);
        $prj->setUsername($r->username);
        $prj->setPassword($r->password);
        $prj->setUseCredentials($r->use_credentials);
        $prj->setActive($r->active);
        return $prj;


    }

}
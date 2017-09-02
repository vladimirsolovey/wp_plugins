<?php


namespace wp_git_deploy_service\classes\git_deploy_classes;


use Exception;
use wp_git_deploy_service\classes\BaseClass;
use wp_git_deploy_service\objects\Project;

require_once WP_GIT_DS_PLUGIN_DIR.'/classes/BaseClass.php';
require_once WP_GIT_DS_PLUGIN_DIR.'/objects/Project.php';
class GitDeployService extends BaseClass
{
    function __construct()
    {
        parent::__construct();
    }

    function show()
    {

        try{
            $projects = $this->dbc->getProjects()->getAll();

            return array("projects"=>$projects);
        }catch(Exception $e)
        {
            $this->warn[] = $e->getMessage();
        }
        return array();

    }

    function add()
    {
        if(isset($_POST['git-save']) && $_POST['git-save']==1) {

            $project = new Project();

            if(isset($_POST['git-deploy-project-credentials']) && !empty($_POST['git-deploy-project-credentials']) && $_POST['git-deploy-project-credentials']==1)
            { $project->setUseCredentials(true);
                if (!isset($_POST['git-deploy-project-username']) || empty($_POST['git-deploy-project-username']))
                {
                        $this->warn[] = 'Username is required';
                }
                else
                {
                    $project->setUsername($_POST['git-deploy-project-username']);
                }

                if (!isset($_POST['git-deploy-project-password']) || empty($_POST['git-deploy-project-password']))
                {
                    $this->warn[] = 'Password is required';
                }
                else
                {
                 $project->setPassword($_POST['git-deploy-project-password']);
                }
            } else
            {
                $project->setUseCredentials(false);
                $project->setUsername('');
                $project->setPassword('');

            }


            if (!isset($_POST['git-deploy-project-name']) || empty($_POST['git-deploy-project-name']))
            {
                $this->warn[]= 'Project Name is required';
            }

            if (!isset($_POST['git-deploy-project-path']) || empty($_POST['git-deploy-project-path']))
            {
                $this->warn[]= 'Project Local path is required';
            }
            if(!isset($_POST['git-deploy-remote-path']) || empty($_POST['git-deploy-remote-path']))
            {
                $this->warn[] = 'Git remote URL is required';
            }
            if(empty($this->warn))
            {

                $project->setName($_POST['git-deploy-project-name']);
                $project->setLocalFolder($_POST['git-deploy-project-path']);
                $project->setRemoteGitUrl($_POST['git-deploy-remote-path']);
                $project->setCreatedAt(time());
                $project->setLastDeployedAt(time());

                if(is_dir($_POST['git-deploy-project-path']) && file_exists($_POST['git-deploy-project-path'].'/.git'))
                {
                    $project->setInitProject(true);
                    $project->setHaveToClone(false);
                }
                else if(is_dir($_POST['git-deploy-project-path']))
                {
                    $project->setInitProject(false);
                    $project->setHaveToClone(false);
                }
                else
                {
                    $project->setInitProject(false);
                    $project->setHaveToClone(true);
                }

                if($this->dbc->getProjects()->create($project))
                {
                    $this->success[] = "Project added successfully";
                    return array('query'=>array('a'=>''));
                }else
                {
                    $this->warn[] = "Something went wrong";
                }
            }

        }

        return array("view"=>'projects/add');
    }

    function cloneProject($id)
    {
        if($id!=null && isset($id) && $this->cleanNum($id)!='') {
            $project = $this->dbc->getProjects()->getById($id);
            if ($project->isHaveToClone()) {
                try {
                    $res = $this->gitService->clone_from($project->getFormattedGitUrl(), $project->getLocalFolder());
                    $this->success[] = $res;
                    $project->setHaveToClone(false);
                    $project->setInitProject(true);
                    $project->setLastDeployedAt(time());
                    $this->dbc->getProjects()->update($project);
                } catch (Exception $e) {
                    $this->warn[] = $e->getMessage();
                }

            }
        }
    }

    function initGitProject($id)
    {
        if($id!=null && isset($id) && $this->cleanNum($id)!='')
        {
            $project = $this->dbc->getProjects()->getById($id);
            if($project)
            {
                try {
                    $res = $this->gitService->addExistingProjectToGit($project->getLocalFolder(), $project->getFormattedGitUrl());
                    $this->success[] = $res;
                    $project->setInitProject(true);
                    $project->setActive(true);
                    if($this->dbc->getProjects()->update($project))
                    {
                        $this->success[] = "Project added to Git successfully";
                    }
                    else
                    {
                        $this->warn[] = "Something went wrong";
                    }

                }catch(Exception $e)
                {
                    $this->warn[]=$e->getMessage()." ".count(glob($project->getLocalFolder()."/*"));
                }
            }
        }
        else
        {
            $this->warn[] = "Incorrect request params (project id not specified)";
        }
        return array();
    }

    function edit($id)
    {
        if($id!=null && isset($id) && $this->cleanNum($id)!='')
        {
            $project = $this->dbc->getProjects()->getById($id);

            if(isset($_POST['git-save']) && $_POST['git-save']==1)
            {
                if(isset($_POST['git-deploy-project-credentials']) && !empty($_POST['git-deploy-project-credentials']) && $_POST['git-deploy-project-credentials']==1)
                { $project->setUseCredentials(true);
                    if (!isset($_POST['git-deploy-project-username']) || empty($_POST['git-deploy-project-username']))
                    {
                        $this->warn[] = 'Username is required';
                    }
                    else
                    {
                        $project->setUsername($_POST['git-deploy-project-username']);
                    }

                    if (!isset($_POST['git-deploy-project-password']) || empty($_POST['git-deploy-project-password']))
                    {
                        $this->warn[] = 'Password is required';
                    }
                    else
                    {
                        $project->setPassword($_POST['git-deploy-project-password']);
                    }
                }
                else
                {
                    $project->setUseCredentials(false);
                    $project->setUsername('');
                    $project->setPassword('');

                }

                if (!isset($_POST['git-deploy-project-name']) || empty($_POST['git-deploy-project-name']))
                {
                    $this->warn[]= 'Project Name is required';
                }

                if (!isset($_POST['git-deploy-project-path']) || empty($_POST['git-deploy-project-path']))
                {
                    $this->warn[]= 'Project Local path is required';
                }
                if(!isset($_POST['git-deploy-remote-path']) || empty($_POST['git-deploy-remote-path']))
                {
                    $this->warn[] = 'Git remote URL is required';
                }
                if(empty($this->warn))
                {

                    $project->setName($_POST['git-deploy-project-name']);
                    $project->setLocalFolder($_POST['git-deploy-project-path']);
                    $project->setRemoteGitUrl($_POST['git-deploy-remote-path']);

                    if(is_dir($_POST['git-deploy-project-path']) && file_exists($_POST['git-deploy-project-path'].'/.git'))
                    {
                        $project->setInitProject(true);
                        $project->setHaveToClone(false);
                    }
                    else if(is_dir($_POST['git-deploy-project-path']))
                    {
                        $project->setInitProject(false);
                        $project->setHaveToClone(false);
                    }
                    else
                    {
                        $project->setInitProject(false);
                        $project->setHaveToClone(true);
                    }

                    if($this->dbc->getProjects()->update($project))
                    {
                        $this->success[] = "Project updated successfully";
                        return array();
                    }
                    else
                    {
                        $this->warn[] = "Something went wrong";
                        return array();
                    }
                }
            }


            return array("view"=>'projects/edit','project'=>$project,'query'=>array('a'=>'edit','id'=>$id));
        }
        else
        {
            $this->warn[] = "Incorrect request params (project id not specified)";
        }

        return array();

    }

    function delete($id)
    {
        if($id!=null && isset($id) && $this->cleanNum($id)!='') {
            if($this->dbc->getProjects()->delete($id))
            {
                $this->success[]="Project delete successfully";
            }
            else
            {
                $this->warn[]="Something went wrong";
            }
        }else
        {
            $this->warn[] = "Incorrect request params (project id not specified)";
        }

    }
    function deploy($id)
    {
        if($id!=null && isset($id) && $this->cleanNum($id)!='') {
            $project = $this->dbc->getProjects()->getById($id);

            if($project)
            {
                try{
                    $res = $this->gitService->pull($project->getLocalFolder(),$project->getFormattedGitUrl(),"master");
                    $this->success[] = $res;
                    $project->setLastDeployedAt(time());
                    if($this->dbc->getProjects()->update($project))
                    {
                        $this->success[] = "Deployed successfully";
                    }
                    else
                    {
                        $this->warn[] = "Something went wrong";
                    }
                }catch(Exception $e)
                {
                    $this->warn[] = $e->getMessage();
                }
            }

        }else
        {
            $this->warn[] = "Incorrect request params (project id not specified)";
        }


    }

    function state($id,$state)
    {
        $this->dbc->getProjects()->openClose($id,$state);
    }

    function setManager()
    {
        $_REQUEST['a'] = (isset($_REQUEST['a']) && !empty($_REQUEST['a'])) ? $_REQUEST['a'] : 'show';
        switch($_REQUEST['a'])
        {
            case 'show':
                $this->response_params = $this->show();
                break;
            case 'clone':
                $this->cloneProject(isset($_REQUEST['id'])?$_REQUEST['id']:null);
                break;
            case 'init':
                $this->initGitProject(isset($_REQUEST['id'])?$_REQUEST['id']:null);
                break;
            case 'add':
                $this->response_params = $this->add();
                break;
            case 'edit':
                $this->response_params = $this->edit(isset($_REQUEST['id'])?$_REQUEST['id']:null);
                break;
            case 'del':
                $this->delete(isset($_REQUEST['id'])?$_REQUEST['id']:null);
                break;
            case 'deploy':
                $this->deploy(isset($_REQUEST['id'])?$_REQUEST['id']:null);
                break;
            case 'state':
                $this->response_params = $this->state(isset($_REQUEST['id'])?$_REQUEST['id']:null,$_REQUEST['w']);
                break;
        }
        if(!isset($this->response_params['view']))
        {
            $this->response_params['view'] = 'projects/list';
        }
        if(!isset($this->response_params['query']))
        {
            $this->response_params['query'] = array();
        }
        return $this->response_params;
    }
}
<?php


namespace wp_git_deploy_service\models;


use wp_git_deploy_service\objects\Project;

interface IProjects
{
    /**
     * @param Project $project
     * @return mixed
     */
    function create(Project $project);

    /**
     * @param int $Id
     * @return mixed
     */
    function delete($Id);

    /**
     * @param Project $project
     * @return mixed
     */
    function update(Project $project);

    /**
     * @param $id
     * @return mixed
     */
    function getById($id);

    /**
     * @return Project[]
     */
    function getAll();

    /**
     * @param $id
     * @param $state
     * @return mixed
     */
    function openClose($id,$state);


}
<?php


namespace wp_git_deploy_service\objects;


class Project
{
    /**
     * @var int
     */
    private $id;
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $remoteGitUrl;
    /**
     * @var string
     */
    private $localFolder;
    /**
     * @var int
     */
    private $createdAt;
    /**
     * @var int
     */
    private $lastDeployedAt;

    /**
     * @var string
     */
    private $username;
    /**
     * @var string
     */
    private $password;
    /**
     * @var boolean
     */
    private $use_credentials;
    /**
     * @var boolean
     */
    private $active;

    /**
     * @var boolean
     */
    private $initProject;

    /**
     * @var boolean
     */
    private $haveToClone;


    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getRemoteGitUrl()
    {

        return $this->remoteGitUrl;
    }

    /**
     * @param string $remoteGitUrl
     */
    public function setRemoteGitUrl($remoteGitUrl)
    {
        $this->remoteGitUrl = $remoteGitUrl;
    }

    /**
     * @return string
     */
    public function getLocalFolder()
    {
        return $this->localFolder;
    }

    /**
     * @param string $localFolder
     */
    public function setLocalFolder($localFolder)
    {
        $this->localFolder = $localFolder;
    }

    /**
     * @return int
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param int $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return int
     */
    public function getLastDeployedAt()
    {
        return $this->lastDeployedAt;
    }

    /**
     * @param int $lastDeployedAt
     */
    public function setLastDeployedAt($lastDeployedAt)
    {
        $this->lastDeployedAt = $lastDeployedAt;
    }

    /**
     * @return boolean
     */
    public function isActive()
    {
        return $this->active==1?true:false;
    }

    /**
     * @param boolean $active
     */
    public function setActive($active)
    {

        $this->active = $active==1?true:false;
    }

    /**
     * @return boolean
     */
    public function isInitProject()
    {
        return $this->initProject;
    }

    /**
     * @param boolean $initProject
     */
    public function setInitProject($initProject)
    {
        $this->initProject = $initProject;
    }

    /**
     * @return boolean
     */
    public function isHaveToClone()
    {
        return $this->haveToClone;
    }

    /**
     * @param boolean $haveToClone
     */
    public function setHaveToClone($haveToClone)
    {
        $this->haveToClone = $haveToClone;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return boolean
     */
    public function isUseCredentials()
    {
        return $this->use_credentials;
    }

    /**
     * @param boolean $use_credentials
     */
    public function setUseCredentials($use_credentials)
    {
        $this->use_credentials = $use_credentials;
    }

    public function getFormattedGitUrl()
    {
        if($this->isUseCredentials())
        {
            return preg_replace('/(https\:\/\/)/','$1'.$this->getUsername().":".$this->getPassword()."@",$this->remoteGitUrl);
        }
        else
        {
            return $this->remoteGitUrl;
        }
    }




}
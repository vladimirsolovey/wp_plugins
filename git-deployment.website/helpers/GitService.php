<?php


namespace wp_git_deploy_service\helpers;


use Exception;

class GitService
{
    private $git = '/usr/bin/git';
    private $repo_path = null;
    private $envopts=array();

    /**
     * @param null $repo_path
     */
    public function setRepoPath($repo_path)
    {
        $this->repo_path = $repo_path;
    }




    private function run_command($command)
    {
        $descriptorspec = array(
            1 => array('pipe', 'w'),
            2 => array('pipe', 'w'),
        );
        $pipes = array();

        if(count($_ENV) === 0) {
            $env = NULL;
            foreach($this->envopts as $k => $v) {
                putenv(sprintf("%s=%s",$k,$v));
            }
        } else {
            $env = array_merge($_ENV, $this->envopts);
        }
        $cwd = $this->repo_path;
        $resource = proc_open($command, $descriptorspec, $pipes, $cwd, $env);
        $stdout = stream_get_contents($pipes[1]);
        $stderr = stream_get_contents($pipes[2]);
        foreach ($pipes as $pipe) {
            fclose($pipe);
        }
        $status = trim(proc_close($resource));
        if ($status) throw new Exception($stderr . "\n" . $stdout);
        return $stdout;
    }

    public function run($command)
    {
        return $this->run_command($this->git." ".$command);
    }


    public function test_git()
    {
        $descr = array(
            1=>array('pipe','w'),
            2=>array('pipe','w')
        );

        $pipes = array();
        $resource =proc_open($this->git, $descr,$pipes);

        $stdout = stream_get_contents($pipes[1]);
        $stderr = stream_get_contents($pipes[2]);
        foreach ($pipes as $pipe) {
            fclose($pipe);
        }
        $status = trim(proc_close($resource));
        return ($status != 127);

    }

    public function addExistingProjectToGit($repo,$remote)
    {
        $this->repo_path = $repo;
        $output = " ";
        $output .= $this->run("init");
        if (count(glob("path/*")) != 0 ) {
            $output.='<br>';
            $output.=$this->run("add -A -v");
            $output.='<br>';
            $output.=$this->run("commit -v -m 'Add Project to Git repository'");
        }

        $output.='<br>';
        $output.=$this->run("remote add origin '$remote'");
        $output.='<br>';
        $output.=$this->run("remote -v");
        $output.='<br>';
        try{
            $output .= $this->run("pull origin master");
        }catch(Exception $e)
        {

        }
        $output.='<br>';
        try {
            $output .= $this->run("push -u origin master");
        }catch(Exception $e)
        {

        }
        return $output;
    }

    public function pull($repo, $remote="",$branch="")
    {
        $this->repo_path = $repo;
        return $this->run("pull '$remote' $branch");
    }

//git clone git://github.com/schacon/grit.git mygrit
    public function clone_from($remote,$local)
    {
        return $this->run("clone '$remote' $local");
    }

    /**
     * @return string
     */
    public function getGit()
    {
        return $this->git;
    }

    /**
     * @param string $git
     */
    public function setGit($git)
    {
        $this->git = $git;
    }


}
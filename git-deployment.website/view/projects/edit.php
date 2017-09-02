<?php
/**
 * @var Project $project
 */
use wp_git_deploy_service\objects\Project;

?>

<script type="text/javascript">
    $j = jQuery.noConflict();
    $j(document).ready(function(){
        manageUserCtrl($j('#git-deploy-project-credentials'));

        $j('#git-deploy-project-credentials').click(function(){
            manageUserCtrl($j(this));
        });
    });

    function manageUserCtrl(id)
    {
        if(id.is(":checked"))
        {
            $j('#git-deploy-project-username-c').show();
            $j('#git-deploy-project-password-c').show();
        }
        else
        {
            $j('#git-deploy-project-username-c').hide();
            $j('#git-deploy-project-password-c').hide();
        }
    }
</script>

<div class="wrap wp-git-deploy-service">
    <h1>Edit Project</h1>
    <hr>
    <?php include WP_GIT_DS_PLUGIN_DIR.'/view/notification/notify.php'?>

    <div class="git-deploy-box">
        <div class="git-deploy-box-title">
            Technical information
        </div>
        <div class="git-deploy-box-body">
            <table class="git-deploy-technical">
                <tr>
                    <th>
                        Path to wp-content:
                    </th>
                    <td>
                        <?php echo WP_GIT_DS_CONTENT_DIR;?>
                    </td>
                </tr>
                <tr>
                    <th>
                        Path to themes:
                    </th>
                    <td>
                        <?php echo WP_GIT_DS_CONTENT_DIR.'/themes';?>
                    </td>
                </tr>
                <tr>
                    <th>
                        Path to plugins:
                    </th>
                    <td>
                        <?php echo WP_GIT_DS_CONTENT_DIR.'/plugins';?>
                    </td>
                </tr>
                <tr>
                    <th>
                        Path to your Project:
                    </th>
                    <td>
                        <?php echo WP_GIT_DS_CONTENT_DIR.'/plugins/[Project folder]';?>
                    </td>
                </tr>
            </table>

        </div>
    </div>


    <form action="" method="post">
        <table class="form-table">
            <input type="hidden" name="git-save" value="1">
            <tbody>
            <tr class="form-field">
                <th><label for="git-deploy-project-credentials">Use Credentials</label></th>
                <td>
                    <input type="checkbox" name="git-deploy-project-credentials" id="git-deploy-project-credentials" value="1" <?php if($project->isUseCredentials()){echo "checked='checked'";}?>>
                </td>
            </tr>
            <tr id="git-deploy-project-username-c" class="hidden">
                <th>
                    <label for="git-deploy-project-username">UserName</label>
                </th>
                <td>
                    <input type="text" class="" name="git-deploy-project-username" id="git-deploy-project-username" value="<?php echo $project->getUsername();?>">
                </td>
            </tr>
            <tr id="git-deploy-project-password-c" class="hidden">
                <th>
                    <label for="git-deploy-project-password">Password</label>
                </th>
                <td>
                    <input type="password" name="git-deploy-project-password" id="git-deploy-project-password" value="<?php echo $project->getPassword();?>">
                </td>
            </tr>
            <tr class="form-field">
                <th class="row"><label for="git-deploy-project-name">Project name<span class="description">(required)</span></label></th>
                <td><input type="text" class="" name="git-deploy-project-name" id="git-deploy-project-name" aria-required="true" value="<?php echo $project->getName();?>" ></td>
            </tr>
            <tr class="form-field">
                <th class="row"><label for="git-deploy-project-path">Project path <span class="description">(required)</span></label></th>
                <td><input type="text" class="" name="git-deploy-project-path" id="git-deploy-project-path" aria-required="true" value="<?php echo $project->getLocalFolder();?>" ></td>
            </tr>
            <tr class="form-field">
                <th class="row"><label for="git-deploy-remote-path">Remote git <span class="description">(required)</span></label></th>
                <td><input type="text" class="" name="git-deploy-remote-path" id="git-deploy-remote-path" aria-required="true" value="<?php echo $project->getRemoteGitUrl();?>">
                </td>
            </tr>
            </tbody>
        </table>
        <p>
            <input type="submit" class="button button-primary" value="Update">
            <a href="?page=git-deploy-service" class="button button-default">Cancel</a>
        </p>
    </form>

</div>

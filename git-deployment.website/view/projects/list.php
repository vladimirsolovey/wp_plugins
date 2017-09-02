<?php
/**
 * @var Project[] $projects
 */
use wp_git_deploy_service\objects\Project;

?>
<script type="text/javascript">
    $j = jQuery.noConflict();
    $j(document).ready(function(){
        $j("#sort-table").dataTable({"order":[0,'desc'],"pageLength": 50});
    });
</script>
<div class="wrap wp-git-deploy-service">
    <h1>Projects List
        <a href="?page=git-deploy-service&a=add" class="add-new-h2"><?php _e('Add New Project', 'WPGitDeployLang') ?></a>           </h1>
    <?php include WP_GIT_DS_PLUGIN_DIR.'/view/notification/notify.php'?>
    <div class="wp-git-table-box">

        <table class="wp-list-table widefat striped git-projects" id="sort-table">
            <thead>
            <tr>
                <th>#</th>
                <th>Project Name</th>
                <th>Paths</th>
                <th>Created At</th>
                <th>Deployed At</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($projects as $val) { ?>
                <tr>
                    <td><?php echo $val->getId();?></td>
                    <td><?php echo $val->getName();?></td>
                    <td>
                        <?php
                        echo "<strong>Git repo:</strong> ".$val->getRemoteGitUrl()."</br> <strong>Local Path:</strong> ".$val->getLocalFolder();
                        ?>
                    </td>
                    <td><?php echo date("m-d-Y",$val->getCreatedAt());?></td>
                    <td><?php
                        if($val->getCreatedAt()!=$val->getLastDeployedAt()) {
                            echo date("m-d-Y", $val->getLastDeployedAt());
                        }else
                        {
                            echo "N/A";
                        }
                        ?></td>
                    <td><?php

                        if($val->isActive()) { ?>
                            <a href="?page=git-deploy-service&a=state&id=<?php echo $val->getId();?>&w=close" class="button button-success">Disable</a>
                        <?php }
                        else
                        { ?>
                            <a href="?page=git-deploy-service&a=state&id=<?php echo $val->getId();?>&w=open" class="button button-default">Enable</a>
                        <?php } ?>

                    </td>
                    <td>
                        <?php if($val->isActive()) { ?>
                        <?php if($val->isInitProject() && !$val->isHaveToClone()){ ?>
                            <a href="?page=git-deploy-service&a=deploy&id=<?php echo $val->getId();?>" class="button button-switcher">Deploy</a>
                        <?php } else if(!$val->isInitProject() && !$val->isHaveToClone()) { ?>
                            <a href="?page=git-deploy-service&a=init&id=<?php echo $val->getId();?>" class="button button-info">Init</a>
                        <?php } else if(!$val->isInitProject() && $val->isHaveToClone()) { ?>
                            <a href="?page=git-deploy-service&a=clone&id=<?php echo $val->getId();?>" class="button button-info">Clone</a>
                        <?php } ?>
                        <?php } ?>
                        <a href="?page=git-deploy-service&a=edit&id=<?php echo $val->getId();?>" class="button button-warning">Edit</a>
                        <a href="?page=git-deploy-service&a=del&id=<?php echo $val->getId();?>" class="button button-danger">Delete</a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>

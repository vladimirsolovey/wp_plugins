<?php
/**
  * Date: 08.02.17
 * Time: 14:25
 * @var CustomPost[] $customPosts
 */
use wichita_webmasters_acpt\domain\CustomPost;

?>

<script type="text/javascript">
    $j(document).ready(function(){
        $j("#sort-table").dataTable({"order":[0,'desc'],"pageLength": 50,});
    });
</script>

<div class="wrap">
    <h2>Custom Post-Type List
        <a href="?page=wwm-post-type&a=add" class="add-new-h2"><?php _e('Add New', 'PayServiceLang') ?></a>
    </h2>
    <?php include WWMACPT_PLUGIN_DIR.'view/notification/notify.php'?>
    <div class="bt-table-box">

        <table class="wp-list-table widefat striped users" id="sort-table">
            <thead>
            <tr>

                <th>Label</th>
                <th>Post Type</th>
                <th>Public</th>
                <th>Capability</th>
                <th>Taxonomies</th>
                <th>Rewrite Slug</th>
                <th>Position in menu</th>
                <th>Description</th>
                <th style="width:200px">Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($customPosts as $c):?>
                <tr>
                    <td><?php echo $c->getLabel();?></td>

                    <td><?php echo $c->getPostType();?></td>
                    <td><?php
                            echo $c->isPublic()?'true':'false';

                        ?></td>
                    <td><?php echo $c->getCapabilityType();?></td>

                    <td><?php

                            echo $c->getTaxonomies();

                        ?></td>

                    <td><?php
                        if(isset($c->getRewrite()['slug']))
                        {
                            echo $c->getRewrite()['slug'];
                        }
                        else {
                            echo "N/A";
                        }
                        ?></td>
                    <td><?php echo $c->getMenuPosition();?></td>
                    <td><?php echo $c->getDescription();  ?></td>

                    <td >
                        <a href="?page=wwm-post-type-roles&a=show&post-type=<?php echo $c->getPostType(); ?>" class="button button-warning" >Roles</a>
                        <a href="?page=wwm-post-type&a=edit&post-type=<?php echo $c->getPostType(); ?>" class="button button-primary">Edit</a>
                        <!--<a href="admin.php?page=bt-users&a=options&uid=<?php /*echo $u->getId()*/?>">Options</a>-->


                        <a href="?page=wwm-post-type&a=del&post-type=<?php echo $c->getPostType(); ?>" class="button button-danger hf-delete-button" data-element-name="Post Type: <?php echo $c->getPostType()?>">Delete</a>

                    </td>
                </tr>
            <?php endforeach;?>
            </tbody>
        </table>

    </div>

</div>

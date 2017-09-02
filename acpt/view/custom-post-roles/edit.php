<?php
/**
  * Date: 13.02.17
 * Time: 15:41
 * @var ACPTRolesService $Obj;
 * @var WP_Role $roleInfo;
 * @var array $capsList;
 */
use wichita_webmasters_acpt\http\ACPTRolesService;

?>
<div class="wrap">

    <h2>Edit Role's Capabilities
        <a href="?page=wwm-post-type-roles&a=show&post-type=<?php echo $Obj->getPostType()->getPostType();?>" class="add-new-h2"><?php _e('Back to Role List', 'ACPTService') ?></a>
    </h2>
    <p><strong>Custom Post Type:</strong><?php echo " ".$Obj->getPostType()->getPostType();?></p>
    <p><strong>Role:</strong><?php echo " ".$roleInfo->name;?></p>
    <hr>
    <div class="edit-role-table">
        <form id="edit-role-post-type" action="" method="post" autocomplete="off" class="validate" novalidate="novalidate">
            <input type="hidden" name="wwm-save" value="1">
            <table class="wp-list-table widefat striped users" id="sort-table">
                <thead>
                <tr>

                    <th>Capability</th>
                    <th>Grand</th>
                    <th>Deny</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($capsList as $key=>$val):?>
                    <tr>
                        <td><?php echo $key;?></td>
                        <td><input type="radio" name="cap[<?php echo $key?>]" value="1" <?php if($val){echo 'checked';}?>></td>
                        <td><input type="radio" name="cap[<?php echo $key?>]" value="0" <?php if(!$val){echo 'checked';}?>></td>
                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>
            <p class="button-controls wp-clearfix">
                <input type="submit" name="bt-user-btn" id="bt-user-btn" class="button button-primary left" value="Update"
            </p>
        </form>
    </div>
</div>

<?php
/**
  * Date: 13.02.17
 * Time: 15:12
 * @var ACPTRolesService $Obj;
 */
use wichita_webmasters_acpt\http\ACPTRolesService;

?>
<div>Show Custom posts list</div>

<script type="text/javascript">
    $j(document).ready(function(){
        $j("#sort-table").dataTable({"order":[0,'desc'],"pageLength": 50});
    });
</script>

<div class="wrap">
    <h2>Custom Post-Type: "<?php echo $Obj->getPostType()->getPostType();?>" - Capability Manager

        <a href="?page=wwm-post-type" class="add-new-h2"><?php _e('Back To List', 'CPTL') ?></a>
    </h2>

    <?php include WWMACPT_PLUGIN_DIR.'view/notification/notify.php'?>
    <div class="bt-table-box">

        <table class="wp-list-table widefat striped users" id="sort-table">
            <thead>
            <tr>

                <th>Role Name</th>
                <th>role</th>
                <th>Action</th>

            </tr>
            </thead>
            <tbody>
            <?php foreach($roles as $key=>$val):?>
                <tr>
                    <td><?php echo $val['name']?></td>
                    <td><?php echo $key;?></td>
                    <td><a href="?page=wwm-post-type-roles&a=edit&post-type=<?php echo $Obj->getPostType()->getPostType(); ?>&role=<?php echo $key;?>" class="button button-warning" >Edit Capabilities</a></td>
                </tr>
            <?php endforeach;?>
            </tbody>
        </table>

    </div>

</div>


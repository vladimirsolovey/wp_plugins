<?php
/**
  * Date: 15.02.17
 * Time: 09:52
 * @var CustomTaxonomy[] $customTaxonomies
 */
use wichita_webmasters_acpt\domain\CustomTaxonomy;

?>

<script type="text/javascript">
    $j(document).ready(function(){
        $j("#sort-table").dataTable({"order":[0,'desc'],"pageLength": 50,});
    });
</script>

<div class="wrap">
    <h2>Custom Taxonomies List
        <a href="?page=wwm-taxonomies&a=add" class="add-new-h2"><?php _e('Add New', 'PayServiceLang') ?></a>
    </h2>
    <?php include WWMACPT_PLUGIN_DIR.'view/notification/notify.php'?>
<div class="bt-table-box">

    <table class="wp-list-table widefat striped users" id="sort-table">
        <thead>
        <tr>

            <th>Label</th>
            <th>Taxonomy Name</th>
            <th>Public</th>
            <th>Rewrite Slug</th>
            <th>Assigned Post Types</th>
            <th>Description</th>
            <th style="width:200px">Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($customTaxonomies as $t):?>
            <tr>
                <td><?php echo $t->getLabel();?></td>

                <td><?php echo $t->getTaxonomy();?></td>
                <td><?php
                    echo $t->isPublic()?'true':'false';

                    ?></td>


                <td><?php
                    if(isset($t->getRewrite()['slug']))
                    {
                        echo $t->getRewrite()['slug'];
                    }
                    else {
                        echo "N/A";
                    }
                    ?></td>
                <td><?php
                    echo $t->getObjectType();
                    ?></td>
                <td><?php echo $t->getDescription();  ?></td>

                <td >

                    <a href="?page=wwm-taxonomies&a=edit&taxonomy=<?php echo $t->getTaxonomy(); ?>" class="button button-primary">Edit</a>
                    <!--<a href="admin.php?page=bt-users&a=options&uid=<?php /*echo $u->getId()*/?>">Options</a>-->


                    <a href="?page=wwm-taxonomies&a=del&taxonomy=<?php echo $t->getTaxonomy(); ?>" class="button button-danger hf-delete-button" data-element-name="Taxonomy: <?php echo $t->getTaxonomy()?>">Delete</a>

                </td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>

</div>
    </div>

<?php
/**
  * Date: 08.02.17
 * Time: 18:55
 * @var CustomPost $post_type
 */
use wichita_webmasters_acpt\domain\CustomPost;

?>
<script type="text/javascript">
    $j(document).ready(function(){

        ManagePanelBtn("#btn-show-labels, #btn-show-params");

        ManageDependentFields("#post-type-name");

        $j("#label-name").on('change',function(){
            var _self = this;
            var current_value = $j(this).val();
            var singular_value = current_value.replace(/s$/g,'');
            console.log(singular_value);
            $j.each(valuesList(),function(i,value){
                $j("#label-"+i).val(value.replace(/__ITEM__/g,singular_value));
            });
        });
    });

    function valuesList()
    {
        return  {
            name : "__ITEM__s",
            singular_name:'__ITEM__',
            add_new : 'Add New',
            add_new_item : 'Add New __ITEM__',
            edit_item : 'Edit __ITEM__',
            new_item : 'New __ITEM__',
            view_item : 'View __ITEM__',
            view_items : 'View __ITEM__s',
            search_items : 'Search __ITEM__',
            not_found : 'Not __ITEM__ found',
            not_found_in_trash : 'No __ITEM__ found in Trash',
            parent_item_colon : 'Parent __ITEM__:',
            all_items : 'All __ITEM__s',
            archives : '__ITEM__ Archives',
            attributes : '__ITEM__ Attributes',
            insert_into_item : 'Insert into __ITEM__',
            uploaded_to_this_item : 'Uploaded to the __ITEM__',
            featured_image : 'Featured Image’',
            set_featured_image : 'Set featured image',
            remove_featured_image : 'Remove featured image',
            use_featured_image : 'Use as featured image',
            menu_name : "__ITEM__s",
            filter_items_list : 'Filter __ITEM__s list',
            items_list_navigation : '__ITEM__s list navigation',
            add_item : 'New __ITEM__ Items',
            items_list : '__ITEM__s list',

        };

    }
</script>
<div class="wrap">
    <h2>Add New Custom Post type
        <a href="admin.php?page=wwm-post-type" class="add-new-h2"><?php _e('Back To List') ?></a>
    </h2>
    <p></p>
    <?php include WWMACPT_PLUGIN_DIR.'view/notification/notify.php'?>

    <form id="add-post-type" action="" method="post" autocomplete="off" class="validate" novalidate="novalidate">
        <input type="hidden" name="wwm-save" value="1">
        <div id="col-container" class="wp-clearfix">
            <div id="col-left" class="wwm-post-type-col-left">
                <div class="col-wrap">
                    <div class="section-header">
                        <h2>Custom Post Parameters</h2>
                        <hr>
                    </div>
                    <div class="section-body">

                        <div class="form-field form-required term-name-wrap">
                            <label for="post-type-name">Post Type<span class="description">(required)</span>-<span class="acpt-param-item">[post_type]</span></label>
                            <div class="small-param-info">Must not exceed 20 characters and may only contain lowercase alphanumeric characters, dashes, and underscores</div>
                            <input name="post-type-name" type="text" id="post-type-name" value="<?php echo $post_type->getPostType()?>" aria-required="true" data-dependent-fields="post-type-capability_type|rewrite-slug">
                        </div>
                        <div class="form-field term-name-wrap ">
                            <label for="post-type-taxonomies">Categories<span class="description"></span>-<span class="acpt-param-item">[taxonomies]</span></label>
                            <div class="small-param-info">Comma separate list of taxonomies slugs. Taxonomies can be registered later.</div>
                            <input name="post-type-taxonomies" type="text" id="post-type-taxonomies" value="<?php echo $post_type->getTaxonomies();?>">
                        </div>
                        <div class="form-field term-name-wrap ">
                            <label for="post-type-menu_position">Position in Admin Menu<span class="description"></span>-<span class="acpt-param-item">[menu_position]</span></label>
                            <div class="small-param-info">The position in the menu order the post type should appear. To work, $show_in_menu must be true</div>
                            <input name="post-type-menu_position" type="number" id="post-type-menu_position" value="<?php echo $post_type->getMenuPosition();?>" placeholder="default null (at the bottom)">
                        </div>
                        <div class="form-field term-name-wrap ">
                            <label for="post-type-menu_icon">Navigation Menu Icon<span class="description"></span>-<span class="acpt-param-item">[menu_icon]</span></label>
                            <div class="small-param-info">The url to the icon to be used for this menu. Pass a base64-encoded SVG using a data URI, which will be colored to match the color scheme -- this should begin with 'data:image/svg+xml;base64,'. Pass the name of a Dashicons helper class to use a font icon, e.g. 'dashicons-chart-pie'. Pass 'none' to leave div.wp-menu-image empty so an icon can be added via CSS.</div>
                            <input name="post-type-menu_icon" type="text" id="post-type-menu_icon" value="<?php echo $post_type->getMenuIcon();?>" placeholder="defaults to use the post icon">
                        </div>
                        <div class="form-field term-name-wrap ">
                            <label for="post-type-supports">Core Features<span class="description"></span>-<span class="acpt-param-item">[supports]</span></label>
                            <div class="small-param-info">Core feature(s) the post type supports. Core features include 'title', 'editor', 'comments', 'revisions', 'trackbacks', 'author', 'excerpt', 'page-attributes', 'thumbnail', 'custom-fields', and 'post-formats'. (comma separate list)</div>
                            <input name="post-type-supports" type="text" id="post-type-supports" placeholder="default (title,editor)" value="<?php echo $post_type->getSupports();?>">
                        </div>
                        <div class="form-field term-name-wrap">
                            <label for="post-type-public">
                                <input name="post-type-public" type="checkbox" value="1" id="post-type-public" <?php if($post_type->isPublic()){echo "checked";};?>>
                                Use Post Type on the Front-End<span class="description"></span>-<span class="acpt-param-item">[public]</span></label>
                            <div class="small-param-info">Whether a post type is intended for use publicly either via the admin interface or by front-end users. While the default settings of $exclude_from_search, $publicly_queryable, $show_ui, and $show_in_nav_menus are inherited from public, each does not rely on this relationship and controls a very specific intention</div>

                        </div>
                    </div>
                    <div class="section-header">
                        <h2>Additional Parameters
                            <a href="javascript:void(0);" class="add-new-h2" id="btn-show-params" data-manage-panel-id="sub-params"><?php _e('Show') ?></a>
                        </h2>
                        <hr>
                    </div>

                    <div class="hidden" id="sub-params">
                        <div class="form-field term-name-wrap ">
                            <label for="post-type-capability_type">Role Name<span class="description"></span>-<span class="acpt-param-item">[capability_type]</span></label>
                            <div class="small-param-info">The string to use to build the read, edit, and delete capabilities.</div>
                            <input name="post-type-capability_type" type="text" id="post-type-capability_type" placeholder="default 'post'" value="<?php echo $post_type->getCapabilityType();?>">
                        </div>
                        <div class="form-field term-name-wrap">
                            <label for="post-type-name">Description<span class="description"></span></label>
                            <div class="small-param-info">A short descriptive summary of what the post type is</div>
                            <input name="post-type-description" type="text" id="post-type-description" value="<?php echo $post_type->getDescription();?>">
                        </div>

                        <div class="form-field term-name-wrap">
                            <label for="post-type-hierarchical">
                                <input name="post-type-hierarchical" type="checkbox" value="1" id="post-type-public" <?php if($post_type->isHierarchical()){echo "checked";};?>>
                                Hierarchical<span class="description"></span>-<span class="acpt-param-item">[hierarchical]</span></label>
                            <div class="small-param-info">Whether the post type is hierarchical (e.g. page)</div>

                        </div>
                        <div class="form-field term-name-wrap">
                            <label for="post-type-exclude_from_search">
                                <input name="post-type-exclude_from_search" type="checkbox" value="1" id="post-type-exclude_from_search" <?php if($post_type->getExcludeFromSearch()){echo "checked";};?>>
                                Exclude from Search on Front-End<span class="description"></span>-<span class="acpt-param-item">[exclude_from_search]</span></label>
                            <div class="small-param-info">Whether to exclude posts with this post type from front end search results.</div>

                        </div>
                        <div class="form-field term-name-wrap">
                            <label for="post-type-publicly_queryable">
                                <input name="post-type-publicly_queryable" type="checkbox" value="1" id="post-type-publicly_queryable" <?php if($post_type->getPubliclyQueryable()){echo "checked";};?>>
                                Able to use in Public Query<span class="description"></span>-<span class="acpt-param-item">[publicly_queryable]</span></label>
                            <div class="small-param-info">Whether queries can be performed on the front end for the post type as part of parse_request(). Endpoints would include:
                                    * ?post_type={post_type_key}
                                    * ?{post_type_key}={single_post_slug}
                                    * ?{post_type_query_var}={single_post_slug} </div>

                        </div>
                        <div class="form-field term-name-wrap">
                            <label for="post-type-show_ui">
                                <input name="post-type-show_ui" type="checkbox" value="1" id="post-type-show_ui" <?php if($post_type->getShowUi()){echo "checked";};?> >
                                Use UI in Admin<span class="description"></span>-<span class="acpt-param-item">[show_ui]</span></label>
                            <div class="small-param-info">WWhether to generate and allow a UI for managing this post type in the admin</div>

                        </div>
                        <div class="form-field term-name-wrap">
                            <label for="post-type-show_in_menu">
                                <input name="post-type-show_in_menu" type="checkbox" value="1" id="post-type-show_in_menu" <?php if($post_type->getShowInMenu()){echo "checked";};?>>
                                Show in Admin Menu<span class="description"></span>-<span class="acpt-param-item">[show_in_menu]</span></label>
                            <div class="small-param-info">Where to show the post type in the admin menu. To work, $show_ui must be true. If true, the post type is shown in its own top level menu.</div>

                        </div>
                        <div class="form-field term-name-wrap">
                            <label for="post-type-show_in_nav_menu">
                                <input name="post-type-show_in_nav_menu" type="checkbox" value="1" id="post-type-show_in_nav_menu" <?php if($post_type->getShowInNavMenus()){echo "checked";};?>>
                                Show in Navigation Menu<span class="description"></span>-<span class="acpt-param-item">[show_in_nav_menu]</span></label>
                            <div class="small-param-info">Makes this post type available for selection in navigation menus</div>

                        </div>
                        <div class="form-field term-name-wrap">
                            <label for="post-type-show_in_admin_bar">
                                <input name="post-type-show_in_admin_bar" type="checkbox" value="1" id="post-type-show_in_admin_bar" <?php if($post_type->getShowInAdminBar()){echo "checked";};?> >
                                Show in Admin Bar<span class="description"></span>-<span class="acpt-param-item">[show_in_admin_bar]</span></label>
                            <div class="small-param-info">Makes this post type available via the admin bar</div>

                        </div>

                        <div class="form-field term-name-wrap">
                            <label for="post-type-map_meta_cap">
                                <input name="post-type-map_meta_cap" type="checkbox" value="1" id="post-type-map_meta_cap" <?php if($post_type->isMapMetaCap()){echo "checked";};?>>
                                Map Meta Capability<span class="description"></span>-<span class="acpt-param-item">[map_meta_cap]</span></label>
                            <div class="small-param-info">Whether to use the internal default meta capability handling</div>

                        </div>

                        <div class="form-field term-name-wrap ">
                            <label for="post-type-register_meta_box_cb">Callback for Meta Box<span class="description"></span>-<span class="acpt-param-item">[register_meta_box_cb]</span></label>
                            <div class="small-param-info">Provide a callback function that sets up the meta boxes for the edit form. Do remove_meta_box() and add_meta_box() calls in the callback</div>
                            <input name="post-type-register_meta_box_cb" type="text" id="post-type-register_meta_box_cb" placeholder="default null" value="<?php echo $post_type->getRegisterMetaBoxCb();?>">
                        </div>

                        <div class="form-field term-name-wrap ">
                            <label for="post-type-has_archive">
                                <input name="post-type-has_archive" type="checkbox" value="1" id="post-type-has_archive" <?php if($post_type->isHasArchive()){echo "checked";};?>>
                                Has Archive<span class="description"></span>-<span class="acpt-param-item">[has_archive]</span></label>
                            <div class="small-param-info">Whether there should be post type archives, or if a string, the archive slug to use.</div>

                        </div>
                        <div class="form-field term-name-wrap ">
                            <label for="post-type-query_var">Query Variable<span class="description"></span>-<span class="acpt-param-item">[query_var]</span></label>
                            <div class="small-param-info">Sets the query_var key for this post type. Defaults to $post_type key. If false, a post type cannot be loaded at ?{query_var}={post_slug}. If specified as a string, the query ?{query_var_string}={post_slug} will be valid.</div>
                            <input name="post-type-query_var" type="text" id="post-type-query_var" value="<?php echo $post_type->isQueryVar()?>" placeholder="Default value true">
                        </div>
                        <div class="form-field term-name-wrap ">
                            <label for="post-type-can_export">
                                <input name="post-type-can_export" type="checkbox" value="1" id="post-type-can_export" <?php if($post_type->isCanExport()){echo "checked";};?>>
                                Can Export<span class="description"></span>-<span class="acpt-param-item">[can_export]</span></label>
                            <div class="small-param-info">Whether to allow this post type to be exported</div>

                        </div>
                        <div class="form-field term-name-wrap ">
                            <label for="post-type-delete_with_user">
                                <input name="post-type-delete_with_user" type="checkbox" value="1" id="post-type-delete_with_user" <?php if($post_type->getDeleteWithUser()){echo "checked";};?>>
                                Bound Post Type with User<span class="description"></span>-<span class="acpt-param-item">[delete_with_user]</span></label>
                            <div class="small-param-info">Whether to delete posts of this type when deleting a user. If true, posts of this type belonging to the user will be moved to trash when then user is deleted. If false, posts of this type belonging to the user will *not* be trashed or deleted.</div>

                        </div>
                        <div class="form-field term-name-wrap ">
                            <label for="post-type-builtin">
                                <input name="post-type-builtin" type="checkbox" value="1" id="post-type-builtin" <?php if($post_type->isBuiltin()){echo "checked";};?>>
                                _builtin<span class="description"></span></label>
                            <div class="small-param-info">FOR INTERNAL USE ONLY! True if this post type is a native or "built-in" post_type</div>

                        </div>
                        <div class="form-field term-name-wrap ">
                            <label for="post-type-edit_link">_edit_link<span class="description"></span></label>
                            <div class="small-param-info">FOR INTERNAL USE ONLY! URL segment to use for edit link of this post type.</div>
                            <input name="post-type-edit_link" type="text" id="post-type-edit_link" value="<?php echo $post_type->getEditLink();?>" placeholder="Default 'post.php?post=%d'">
                        </div>
                        <hr>
                    </div>


                </div>
            </div>
            <div id="col-right" class="wwm-post-type-col-right">
                <div class="col-wrap">
                    <div class="section-header">
                        <h2>Labels</h2>
                        <hr>
                    </div>

                    <div class="form-field form-required term-name-wrap">
                        <label for="labels[name]">Name<span class="description">(required)</span>-<span class="acpt-param-item">[name]</span></label>
                        <div class="small-param-info">General name for the post type, usually plural.</div>
                        <input name="labels[name]" type="text" id="label-name" value="<?php echo $post_type->getLabels()['name'];?>" aria-required="true">

                    </div>
                    <div class="section-header">
                        <h2>
                            Labels additional params
                            <a href="javascript:void(0);" class="add-new-h2" id="btn-show-labels" data-manage-panel-id="args-labels"><?php _e('Show') ?></a>
                        </h2>
                        <hr>
                    </div>

                    <div class="args-labels hidden" id="args-labels">
                        <div id="col-left">
                            <div class="form-field term-name-wrap">
                                <label for="labels[singular_name]">Singular Name<span class="description"></span>-<span class="acpt-param-item">[singular_name]</span></label>

                                <div class="small-param-info">Name for one object of this post type
                                </div>
                                <input name="labels[singular_name]" type="text" id="label-singular_name" value="<?php echo $post_type->getLabels()['singular_name'];?>">

                            </div>
                            <div class="form-field term-name-wrap">
                                <label for="labels[add_new]">Add New<span class="description"></span>-<span class="acpt-param-item">[add_new]</span></label>
                                <div class="small-param-info">Default is ‘Add New’ for both hierarchical and non-hierarchical types.</div>
                                <input name="labels[add_new]" type="text" id="label-add_new" value="<?php echo $post_type->getLabels()['add_new'];?>">

                            </div>
                            <div class="form-field  term-name-wrap">
                                <label for="labels[add_new_item]">Add New Item<span class="description"></span>-<span class="acpt-param-item">[add_new_item]</span></label>
                                <div class="small-param-info">Label for adding a new singular item.</div>
                                <input name="labels[add_new_item]" type="text" id="label-add_new_item" value="<?php echo $post_type->getLabels()['add_new_item'];?>" >

                            </div>
                            <div class="form-field  term-name-wrap">
                                <label for="labels[edit_item]">Edit Item<span class="description"></span>-<span class="acpt-param-item">[edit_item]</span></label>
                                <div class="small-param-info">Label for editing a singular item</div>
                                <input name="labels[edit_item]" type="text" id="label-edit_item" value="<?php echo $post_type->getLabels()['edit_item'];?>" >

                            </div>
                            <div class="form-field  term-name-wrap">
                                <label for="labels[new_item]">New Item<span class="description"></span>-<span class="acpt-param-item">[new_item]</span></label>
                                <div class="small-param-info">Label for the new item page title
                                </div>
                                <input name="labels[new_item]" type="text" id="label-new_item" value="<?php echo $post_type->getLabels()['new_item'];?>" >

                            </div>
                            <div class="form-field  term-name-wrap">
                                <label for="labels[view_item]">View Item<span class="description"></span>-<span class="acpt-param-item">[view_item]</span></label>
                                <div class="small-param-info">Label for viewing a singular item
                                </div>
                                <input name="labels[view_item]" type="text" id="label-view_item" value="<?php echo $post_type->getLabels()['view_item'];?>" >

                            </div>
                            <div class="form-field  term-name-wrap">
                                <label for="labels[view_items]">View Items<span class="description"></span>-<span class="acpt-param-item">[view_items]</span></label>
                                <div class="small-param-info">Label for viewing post type archives
                                </div>
                                <input name="labels[view_items]" type="text" id="label-view_items" value="<?php echo $post_type->getLabels()['view_items'];?>" >

                            </div>
                            <div class="form-field  term-name-wrap">
                                <label for="labels[search_items]">Search Items<span class="description"></span>-<span class="acpt-param-item">[search_items]</span></label>

                                <div class="small-param-info">Label for searching plural items
                                </div>
                                <input name="labels[search_items]" type="text" id="label-search_items" value="<?php echo $post_type->getLabels()['search_items'];?>" >

                            </div>
                            <div class="form-field  term-name-wrap">
                                <label for="labels[not_found]">Not Found<span class="description"></span>-<span class="acpt-param-item">[not_found]</span></label>

                                <div class="small-param-info">Label used when no items are found
                                </div>
                                <input name="labels[not_found]" type="text" id="label-not_found" value="<?php echo $post_type->getLabels()['not_found'];?>" >

                            </div>
                            <div class="form-field  term-name-wrap">
                                <label for="labels[not_found_in_trash]">Not Found in Trash<span class="description"></span>-<span class="acpt-param-item">[not_found_in_trash]</span></label>

                                <div class="small-param-info">Label used when no items are in the trash
                                </div>
                                <input name="labels[not_found_in_trash]" type="text" id="label-not_found_in_trash" value="<?php echo $post_type->getLabels()['not_found_in_trash'];?>" >

                            </div>
                            <div class="form-field  term-name-wrap">
                                <label for="labels[parent_item_colon]">Parent Item Colon<span class="description"></span>-<span class="acpt-param-item">[parent_item_colon]</span></label>

                                <div class="small-param-info">Label used to prefix parents of hierarchical items
                                </div>
                                <input name="labels[parent_item_colon]" type="text" id="label-parent_item_colon" value="<?php echo $post_type->getLabels()['parent_item_colon'];?>" >

                            </div>
                            <div class="form-field  term-name-wrap">
                                <label for="labels[all_items]">All Items<span class="description"></span>-<span class="acpt-param-item">[all_items]</span></label>


                                <div class="small-param-info">Label to signify all items in a submenu link
                                </div>
                                <input name="labels[all_items]" type="text" id="label-all_items" value="<?php echo $post_type->getLabels()['all_items'];?>" >

                            </div>
                        </div>
                        <div id="col-right">
                            <div class="form-field  term-name-wrap">
                                <label for="labels[archives]">Archives<span class="description"></span>-<span class="acpt-param-item">[archives]</span></label>

                                <div class="small-param-info">Label for archives in nav menus
                                </div>
                                <input name="labels[archives]" type="text" id="label-archives" value="<?php echo $post_type->getLabels()['archives'];?>" >

                            </div>
                            <div class="form-field  term-name-wrap">
                                <label for="labels[attributes]">Attributes<span class="description"></span>-<span class="acpt-param-item">[attributes]</span></label>

                                <div class="small-param-info">Label for the attributes meta box
                                </div>
                                <input name="label-attributes" type="text" id="label-attributes" value="" >

                            </div>
                            <div class="form-field  term-name-wrap">
                                <label for="labels[insert_into_item]">Insert into Item<span class="description"></span>-<span class="acpt-param-item">[insert_into_item]</span></label>

                                <div class="small-param-info">Label for the media frame button
                                </div>
                                <input name="labels[insert_into_item]" type="text" id="label-insert_into_item" value="<?php echo $post_type->getLabels()['insert_into_item'];?>" >

                            </div>
                            <div class="form-field  term-name-wrap">
                                <label for="labels[uploaded_to_this_item]">Uploaded to this Item<span class="description"></span>-<span class="acpt-param-item">[uploaded_to_this_item]</span></label>

                                <div class="small-param-info">Label for the media frame filter
                                </div>
                                <input name="labels[uploaded_to_this_item]" type="text" id="label-uploaded_to_this_item" value="<?php echo $post_type->getLabels()['name'];?>" >

                            </div>
                            <div class="form-field  term-name-wrap">
                                <label for="labels[featured_image]">Featured Image<span class="description"></span>-<span class="acpt-param-item">[featured_image]</span></label>

                                <div class="small-param-info">Label for the Featured Image meta box title
                                </div>
                                <input name="labels[featured_image]" type="text" id="label-featured_image" value="<?php echo $post_type->getLabels()['featured_image'];?>" >

                            </div>
                            <div class="form-field  term-name-wrap">
                                <label for="labels[set_featured_image]">Set Featured Image<span class="description"></span>-<span class="acpt-param-item">[set_featured_image]</span></label>
                                <div class="small-param-info">Label for setting the featured image
                                </div>
                                <input name="labels[set_featured_image]" type="text" id="label-set_featured_image" value="<?php echo $post_type->getLabels()['set_featured_image'];?>" >

                            </div>
                            <div class="form-field  term-name-wrap">
                                <label for="labels[remove_featured_image]">Remove Featured Image<span class="description"></span>-<span class="acpt-param-item">[remove_featured_image]</span></label>

                                <div class="small-param-info">Label for removing the featured image
                                </div>
                                <input name="labels[remove_featured_image]" type="text" id="label-remove_featured_image" value="<?php echo $post_type->getLabels()['remove_featured_image'];?>" >

                            </div>
                            <div class="form-field  term-name-wrap">
                                <label for="labels[use_featured_image]">Use Featured Image<span class="description"></span>-<span class="acpt-param-item">[use_featured_image]</span></label>

                                <div class="small-param-info">Label in the media frame for using a featured image
                                </div>
                                <input name="labels[use_featured_image]" type="text" id="label-use_featured_image" value="<?php echo $post_type->getLabels()['use_featured_image'];?>" >

                            </div>
                            <div class="form-field  term-name-wrap">
                                <label for="labels[menu_name]">Menu Name<span class="description"></span>-<span class="acpt-param-item">[menu_name]</span></label>

                                <div class="small-param-info">Label for the menu name
                                </div>
                                <input name="labels[menu_name]" type="text" id="label-menu_name" value="<?php echo $post_type->getLabels()['menu_name'];?>" >

                            </div>
                            <div class="form-field  term-name-wrap">
                                <label for="labels[filter_items_list]">Filter Items List<span class="description"></span>-<span class="acpt-param-item">[filter_items_list]</span></label>

                                <div class="small-param-info">Label for the table views hidden heading
                                </div>
                                <input name="labels[filter_items_list]" type="text" id="label-filter_items_list" value="<?php echo $post_type->getLabels()['filter_items_list'];?>" >

                            </div>
                            <div class="form-field term-name-wrap">
                                <label for="labels[items_list_navigation]">Items List Navigation<span class="description"></span>-<span class="acpt-param-item">[items_list_navigation]</span></label>

                                <div class="small-param-info">Label for the table pagination hidden heading
                                </div>
                                <input name="labels[items_list_navigation]" type="text" id="label-items_list_navigation" value="<?php echo $post_type->getLabels()['items_list_navigation'];?>" >

                            </div>

                            <div class="form-field term-name-wrap">
                                <label for="labels[items_list]">Items List<span class="description"></span>-<span class="acpt-param-item">[items_list]</span></label>

                                <div class="small-param-info">Label for the table hidden heading
                                </div>
                                <input name="labels[items_list]" type="text" id="label-items_list" value="<?php echo $post_type->getLabels()['items_list'];?>" >

                            </div>
                        </div>
                        <div class="wp-clearfix"></div>
                    </div>
                    <div class="section-header">
                        <h2>Rewrite parameters</h2>
                        <hr>
                    </div>

                    <div class="form-field form-required term-name-wrap">
                        <label for="rewrite[slug]">Slug<span class="description">(required)</span>-<span class="acpt-param-item">[slug]</span></label>
                        <div class="small-param-info">Customize the permastruct slug.</div>
                        <input name="rewrite[slug]" type="text" id="rewrite-slug" value="<?php echo $post_type->getRewrite()['slug'];?>" aria-required="true">

                    </div>
                    <div class="form-field term-name-wrap">
                        <label for="rewrite[with_front]">
                            <input name="rewrite[with_front]" type="checkbox" value="1" id="rewrite-with_front" <?php if($post_type->getRewrite()['with_front']){echo "checked";};?>>
                            With Front<span class="description"></span>-<span class="acpt-param-item">[with_front]</span></label>
                        <div class="small-param-info">Whether the permastruct should be prepended with WP_Rewrite::$front.</div>
                    </div>
                    <div class="form-field term-name-wrap">
                        <label for="rewrite[feeds]">
                            <input name="rewrite[feeds]" type="checkbox" value="1"  id="rewrite-feeds" <?php if($post_type->getRewrite()['feeds']){echo "checked";};?>>
                            Feeds<span class="description"></span>-<span class="acpt-param-item">[feeds]</span> </label>
                        <div class="small-param-info">Whether the feed permastruct should be built for this post type.</div>
                    </div>
                    <div class="form-field term-name-wrap">
                        <label for="rewrite[pages]">
                            <input name="rewrite[pages]" type="checkbox" value="1"  id="rewrite-pages" <?php if($post_type->getRewrite()['pages']){echo "checked";};?>>
                            Pages<span class="description"></span>-<span class="acpt-param-item">[pages]</span></label>
                        <div class="small-param-info">Whether the permastruct should provide for pagination.</div>
                    </div>

                </div>
            </div>

        </div>
        <div class="button-controls wp-clearfix">
            <input type="submit" name="bt-user-btn" id="bt-user-btn" class="button button-primary left" value="Update"
        </div>
    </form>


</div>
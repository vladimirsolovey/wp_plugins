<?php
/**
  * Date: 08.02.17
 * Time: 18:55
 */
?>
<script type="text/javascript">
    $j(document).ready(function(){

        ManagePanelBtn("#btn-show-labels, #btn-show-params");

        ManageDependentFields("#taxonomy-name");

        $j("#label-name").on('change',function(){
            var _self = this;
            var current_value = $j(this).val();
            var singular_value = current_value.replace(/s$/g,'');
            console.log(singular_value);
            $j.each(valuesList(),function(i,value){
                $j("#label-"+i).val(value.replace(/__ITEM__/g,singular_value).replace(/ie$/g,'y').replace(/ie:$/g,'y:'));
            });
        });
    });

    function valuesList()
    {
        return  {
            name : "__ITEM__s",
         singular_name:"__ITEM__",
         menu_name:"__ITEM__s",
         all_items : "All __ITEM__s",
         edit_item : "Edit __ITEM__",
         view_item : "View __ITEM__",
         update_item : "Update __ITEM__",
         add_new_item : "Add New __ITEM__",
         new_item_name : "New __ITEM__ Name",
         parent_item : "Parent __ITEM__",
         parent_item_colon :"Parent __ITEM__:",
         search_items : "Search __ITEM__s",
         popular_items : "Popular __ITEM__s",
         separate_items_with_commas : "Separate __ITEM__s by comma",
         add_or_remove_items : "Add or Remove __ITEM__s",
         choose_from_most_used : "Choose from the most used __ITEM__s",
         not_found : "No __ITEM__s found",
         no_terms : "No __ITEM__s",
         items_list_navigation : "__ITEM__s list navigation",
         items_list : "__ITEM__s list",
         name_admin_bar : "__ITEM__",
         archives : "All __ITEM__s"
        };

    }
</script>
<div class="wrap">
    <h2>Add New Taxonomy
        <a href="admin.php?page=wwm-taxonomies" class="add-new-h2"><?php _e('Back To List') ?></a>
    </h2>
    <p></p>
    <?php include WWMACPT_PLUGIN_DIR.'view/notification/notify.php'?>

    <form id="add-taxonomy" action="" method="post" autocomplete="off" class="validate" novalidate="novalidate">
        <input type="hidden" name="wwm-save" value="1">
        <div id="col-container" class="wp-clearfix">
            <div id="col-left" class="wwm-taxonomy-col-left">
                <div class="col-wrap">
                    <h2>Custom Taxonomy Parameters</h2>
                    <div class="form-field form-required term-name-wrap">
                        <label for="taxonomy-name">Taxonomy<span class="description">(required)</span></label>
                        <div><small>The name of the taxonomy. Name should only contain lowercase letters and the underscore character, and not be more than 32 characters long (database structure restriction).</small></div>
                        <input name="taxonomy-name" type="text" id="taxonomy-name" value="" aria-required="true" data-dependent-fields="taxonomy-query_var|rewrite-slug">
                    </div>
                    <div class="form-field term-name-wrap ">
                        <label for="taxonomy-object_type">Object type<span class="description"></span></label>
                        <div><small>Name of the object type for the taxonomy object. Object-types can be built-in Post Type or any Custom Post Type that may be registered. (Comma separated list)</small></div>
                        <input name="taxonomy-object_type" type="text" id="taxonomy-object_type">
                    </div>
                    <div class="form-field term-name-wrap">
                        <label for="taxonomy-hierarchical">hierarchical<span class="description"></span></label>
                        <div><small>Is this taxonomy hierarchical (have descendants) like categories or not hierarchical like tags.</small></div>
                        <input name="taxonomy-hierarchical" type="checkbox" value="1" id="taxonomy-public" >
                    </div>
                    <div class="form-field term-name-wrap">
                        <label for="taxonomy-public">public<span class="description"></span></label>
                        <div><small>Whether a taxonomy is intended for use publicly either via the admin interface or by front-end users. The default settings of `$publicly_queryable`, `$show_ui`, and `$show_in_nav_menus` are inherited from `$public`.</small></div>
                        <input name="taxonomy-public" type="checkbox" value="1" id="taxonomy-public" checked>
                    </div>
                    <h2>Additional Parameters
                        <a href="javascript:void(0);" class="add-new-h2" id="btn-show-params" data-manage-panel-id="sub-params"><?php _e('Show') ?></a>
                    </h2>
                    <div class="hidden" id="sub-params">
                        <hr>
                    <div class="form-field term-name-wrap">
                        <label for="taxonomy-show_ui">show_ui<span class="description"></span></label>
                        <div><small>Whether to generate a default UI for managing this taxonomy.</small></div>
                        <input name="taxonomy-show_ui" type="checkbox" value="1" id="taxonomy-show_ui">
                    </div>
                    <div class="form-field term-name-wrap">
                        <label for="taxonomy-show_in_menu">show_in_menu<span class="description"></span></label>
                        <div><small>Where to show the taxonomy in the admin menu. show_ui must be true.</small></div>
                        <input name="taxonomy-show_in_menu" type="checkbox" value="1" id="taxonomy-show_in_menu" >
                    </div>
                    <div class="form-field term-name-wrap">
                        <label for="taxonomy-show_in_nav_menus">show_in_nav_menu<span class="description"></span></label>
                        <div><small>true makes this taxonomy available for selection in navigation menus.</small></div>
                        <input name="taxonomy-show_in_nav_menus" type="checkbox" value="1" id="taxonomy-show_in_nav_menus" >
                    </div>
                    <div class="form-field term-name-wrap">
                        <label for="taxonomy-show_tagcloud">show_tagcloud<span class="description"></span></label>
                        <div><small>Whether to allow the Tag Cloud widget to use this taxonomy.</small></div>
                        <input name="taxonomy-show_tagcloud" type="checkbox" value="1" id="taxonomy-show_tagcloud" >
                    </div>
                    <div class="form-field term-name-wrap">
                        <label for="taxonomy-show_in_quick_edit">show_in_quick_edit<span class="description"></span></label>
                        <div><small>Whether to show the taxonomy in the quick/bulk edit panel</small></div>
                        <input name="taxonomy-show_in_quick_edit" type="checkbox" value="1" id="taxonomy-show_in_quick_edit" >
                    </div>
                    <div class="form-field term-name-wrap">
                        <label for="taxonomy-show_admin_column">show_admin_column<span class="description"></span></label>
                        <div><small>Whether to allow automatic creation of taxonomy columns on associated post-types table.</small></div>
                        <input name="taxonomy-show_admin_column" type="checkbox" value="1" id="taxonomy-show_admin_column" >
                    </div>
                    <div class="form-field term-name-wrap ">
                        <label for="taxonomy-meta_box_cb">meta_box_cb<span class="description"></span></label>
                        <div><small>Provide a callback function name for the meta box display.</small></div>
                        <input name="taxonomy-meta_box_cb" type="text" id="taxonomy-meta_box_cb" placeholder="default null">
                    </div>
                    <div class="form-field term-name-wrap ">
                        <label for="taxonomy-query_var">query_var<span class="description"></span></label>
                        <div><small>False to disable the query_var, set as string to use custom query_var instead of default which is $taxonomy, the taxonomy's "name".</small></div>
                        <input name="taxonomy-query_var" type="text" id="taxonomy-query_var" value="" placeholder="Default value taxonomy name">
                    </div>
                    <div class="form-field term-name-wrap ">
                        <label for="taxonomy-update_count_callback">register_meta_box_cb<span class="description"></span></label>
                        <div><small>A function name that will be called when the count of an associated $object_type, such as post, is updated. Works much like a hook.</small></div>
                        <input name="taxonomy-update_count_callback" type="text" id="taxonomy-update_count_callback" placeholder="default null">
                    </div>
                    <div class="form-field term-name-wrap">
                        <label for="taxonomy-name">Description<span class="description"></span></label>
                        <div><small>A short descriptive summary of what the post type is</small></div>
                        <input name="taxonomy-description" type="text" id="taxonomy-description" value="">
                    </div>
                    </div>
                    <hr>
                </div>
            </div>
            <div id="col-right" class="wwm-taxonomy-col-right">
                <div class="col-wrap">
                    <h2>Labels</h2>
                    <div class="form-field form-required term-name-wrap">
                        <label for="labels[name]">name<span class="description">(required)</span></label>
                        <div><small>general name for the taxonomy, usually plural.</small></div>
                        <input name="labels[name]" type="text" id="label-name" value="" aria-required="true">

                    </div>
                    <h2>
                        Labels additional params
                        <a href="javascript:void(0);" class="add-new-h2" id="btn-show-labels" data-manage-panel-id="args-labels"><?php _e('Show') ?></a>
                    </h2>
                    <hr>
                    <div class="args-labels wp-clearfix hidden" id="args-labels">
                        <div id="col-left">
                            <div class="form-field term-name-wrap">
                                <label for="labels[singular_name]">singular_name<span class="description"></span></label>

                                <div>
                                    <small>name for one object of this taxonomy.</small>
                                </div>
                                <input name="labels[singular_name]" type="text" id="label-singular_name" value="">

                            </div>
                            <div class="form-field term-name-wrap">
                                <label for="labels[menu_name]">menu_name<span class="description"></span></label>
                                <div><small>the menu name text.</small></div>
                                <input name="labels[menu_name]" type="text" id="label-menu_name" value="">

                            </div>
                            <div class="form-field  term-name-wrap">
                                <label for="labels[all_items]">add_new_item<span class="description"></span></label>
                                <div><small>the all items text.</small></div>
                                <input name="labels[all_items]" type="text" id="label-all_items" value="" >

                            </div>
                            <div class="form-field  term-name-wrap">
                                <label for="labels[edit_item]">edit_item<span class="description"></span></label>
                                <div><small>the edit item text.</small></div>
                                <input name="labels[edit_item]" type="text" id="label-edit_item" value="" >

                            </div>
                            <div class="form-field  term-name-wrap">
                                <label for="labels[view_item]">view_item<span class="description"></span></label>
                                <div>
                                    <small>the view item text</small>
                                </div>
                                <input name="labels[view_item]" type="text" id="label-view_item" value="" >

                            </div>
                            <div class="form-field  term-name-wrap">
                                <label for="labels[update_item]">update_item<span class="description"></span></label>
                                <div>
                                    <small>he update item text</small>
                                </div>
                                <input name="labels[update_item]" type="text" id="label-update_item" value="" >

                            </div>
                            <div class="form-field  term-name-wrap">
                                <label for="labels[add_new_item]">add_new_item<span class="description"></span></label>
                                <div>
                                    <small>the add new item text.</small>
                                </div>
                                <input name="labels[add_new_item]" type="text" id="label-add_new_item" value="" >

                            </div>

                            <div class="form-field  term-name-wrap">
                                <label for="labels[new_item_name]">new_item_name<span class="description"></span></label>
                                <div>
                                    <small>the new item name text.</small>
                                </div>
                                <input name="labels[new_item_name]" type="text" id="label-new_item_name" value="" >

                            </div>
                            <div class="form-field  term-name-wrap">
                                <label for="labels[parent_item]">parent_item<span class="description"></span></label>

                                <div>
                                    <small>the parent item text. This string is not used on non-hierarchical taxonomies such as post tags.</small>
                                </div>
                                <input name="labels[parent_item]" type="text" id="label-parent_item" value="" >

                            </div>
                            <div class="form-field  term-name-wrap">
                                <label for="labels[parent_item_colon]">parent_item_colon<span class="description"></span></label>

                                <div>
                                    <small>The same as parent_item, but with colon</small>
                                </div>
                                <input name="labels[parent_item_colon]" type="text" id="label-parent_item_colon" value="" >

                            </div>
                            <div class="form-field  term-name-wrap">
                                <label for="labels[not_found]">not_found<span class="description"></span></label>

                                <div>
                                    <small>the text used in the terms list table when there are no items for a taxonomy.</small>
                                </div>
                                <input name="labels[not_found]" type="text" id="label-not_found" value="" >

                            </div>

                        </div>
                        <div id="col-right">
                            <div class="form-field  term-name-wrap">
                                <label for="labels[search_items]">search_items<span class="description"></span></label>

                                <div>
                                    <small>the search items text.</small>
                                </div>
                                <input name="labels[search_items]" type="text" id="label-search_items" value="" >

                            </div>
                            <div class="form-field  term-name-wrap">
                                <label for="labels[popular_items]">popular_items<span class="description"></span></label>

                                <div>
                                    <small>the popular items text. This string is not used on hierarchical taxonomies.</small>
                                </div>
                                <input name="labels[popular_items]" type="text" id="label-popular_items" value="" >

                            </div>
                            <div class="form-field  term-name-wrap">
                                <label for="labels[separate_items_with_commas]">separate_items_with_commas<span class="description"></span></label>

                                <div>
                                    <small>the separate item with commas text used in the taxonomy meta box. This string is not used on hierarchical taxonomies.</small>
                                </div>
                                <input name="labels[separate_items_with_commas]" type="text" id="label-separate_items_with_commas" value="" >

                            </div>
                            <div class="form-field  term-name-wrap">
                                <label for="labels[add_or_remove_items]">add_or_remove_items<span class="description"></span></label>

                                <div>
                                    <small> the add or remove items text and used in the meta box when JavaScript is disabled. This string is not used on hierarchical taxonomies.</small>
                                </div>
                                <input name="labels[add_or_remove_items]" type="text" id="label-add_or_remove_items" value="" >

                            </div>
                            <div class="form-field  term-name-wrap">
                                <label for="labels[choose_from_most_used]">choose_from_most_used<span class="description"></span></label>

                                <div>
                                    <small>the choose from most used text used in the taxonomy meta box. This string is not used on hierarchical taxonomies.</small>
                                </div>
                                <input name="labels[choose_from_most_used]" type="text" id="label-choose_from_most_used" value="" >

                            </div>

                            <div class="form-field  term-name-wrap">
                                <label for="labels[no_terms]">no_terms<span class="description"></span></label>

                                <div>
                                    <small>the no terms text.</small>
                                </div>
                                <input name="labels[no_terms]" type="text" id="label-no_terms" value="" >

                            </div>
                            <div class="form-field  term-name-wrap">
                                <label for="labels[items_list_navigation]">items_list_navigation<span class="description"></span></label>

                                <div>
                                    <small>String for the table pagination hidden heading.</small>
                                </div>
                                <input name="labels[items_list_navigation]" type="text" id="label-items_list_navigation" value="" >

                            </div>
                            <div class="form-field  term-name-wrap">
                                <label for="labels[items_list]">items_list<span class="description"></span></label>
                                <div>
                                    <small>String for the table hidden heading.</small>
                                </div>
                                <input name="labels[items_list]" type="text" id="label-items_list" value="" >

                            </div>
                            <div class="form-field  term-name-wrap">
                                <label for="labels[name_admin_bar]">name_admin_bar<span class="description"></span></label>

                                <div>
                                    <small>String for use in New in Admin menu bar.</small>
                                </div>
                                <input name="labels[name_admin_bar]" type="text" id="label-name_admin_bar" value="" >

                            </div>
                            <div class="form-field  term-name-wrap">
                                <label for="labels[archives]">archives<span class="description"></span></label>

                                <div>
                                    <small>String for use with archives in nav menus.</small>
                                </div>
                                <input name="labels[archives]" type="text" id="label-archives" value="" >

                            </div>

                        </div>

                    </div>

                    <h2>Rewrite parameters</h2>
                    <hr>
                    <div class="form-field form-required term-name-wrap">
                        <label for="rewrite[slug]">Slug<span class="description">(required)</span></label>
                        <div><small>Customize the permastruct slug.</small></div>
                        <input name="rewrite[slug]" type="text" id="rewrite-slug" value="" aria-required="true">

                    </div>
                    <div class="form-field term-name-wrap">
                        <label for="rewrite[with_front]">With Front</label>
                        <div><small>Whether the permastruct should be prepended with WP_Rewrite::$front.</small></div>
                        <input name="rewrite[with_front]" type="checkbox" value="1" id="rewrite-with_front"  checked>

                    </div>
                    <div class="form-field term-name-wrap">
                        <label for="rewrite[hierarchical]">hierarchical </label>
                        <div><small> true or false allow hierarchical urls</small></div>
                        <input name="rewrite[hierarchical]" type="checkbox" value="1"  id="rewrite-hierarchical" >
                    </div>

                </div>
            </div>

        </div>

        <p class="button-controls wp-clearfix">
            <input type="submit" name="bt-user-btn" id="bt-user-btn" class="button button-primary left" value="Add New"
        </p>
    </form>


</div>
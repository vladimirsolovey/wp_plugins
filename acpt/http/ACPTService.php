<?php

/**
  * Date: 08.02.17
 * Time: 14:07
 */
namespace wichita_webmasters_acpt\http;
use wichita_webmasters_acpt\domain\CustomPost;
use wichita_webmasters_acpt\domain\CustomPostRewrite;
use WP_Role;

require_once WWMACPT_PLUGIN_DIR.'http/BaseClass.php';
require_once WWMACPT_PLUGIN_DIR.'domain/CustomPostLabels.php';
require_once WWMACPT_PLUGIN_DIR.'domain/CustomPostRewrite.php';

class ACPTService extends BaseClass
{
    function __construct()
    {
        parent::__construct();
    }

    function show()
    {
        $customPosts = $this->db_ctx->getCustomPosts()->getAllCustomPostTypes();
        return array("customPosts"=>$customPosts);
    }

    function add()
    {

        if($this->request->get('wwm-save')!=null && !$this->is_empty($this->request->get('wwm-save')) && $this->request->get('wwm-save')==1)
        {

            if($this->is_empty($this->request->get('post-type-name')))
            {
                $this->warn[] = "Post type is required";
            }

            if($this->is_empty($this->request->get('labels')) || $this->is_empty($this->request->get('labels')['name']))
            {
                $this->warn[] = "name field in the Labels is required";
            }

            if($this->is_empty($this->request->get('rewrite')) || $this->is_empty($this->request->get('rewrite')['slug']))
            {
                $this->warn[] = "Rewrite slug is required";
            }
            if($this->db_ctx->getCustomPosts()->isExists($this->request->get('post-type-name')))
            {
                $this->warn[] = 'Post-type with this name is already exists';
            }
            if(empty($this->warn))
            {
                $rewrite_obj = new CustomPostRewrite();
                $rewrite_obj->initObject($this->request->get('rewrite'));
                $post_type = new CustomPost();
                $post_type->setPostType($this->request->get('post-type-name'));
                $post_type->setLabel($this->request->get('labels')['name']);
                $post_type->setLabels($this->request->get('labels'));
                $post_type->setName($this->request->get('post-type-name'));
                $post_type->setDescription($this->request->get('post-type-description'));
                $post_type->setPublic($this->request->get('post-type-public'));
                $post_type->setHierarchical($this->request->get('post-type-hierarchical'));
                $post_type->setExcludeFromSearch($this->request->get('post-type-exclude_from_search'));
                $post_type->setPubliclyQueryable($this->request->get('post-type-publicly_queryable'));
                $post_type->setShowUi($this->request->get('post-type-show_ui'));
                $post_type->setShowInMenu($this->request->get('post-type-show_in_menu'));
                $post_type->setShowInNavMenus($this->request->get('post-type-show_in_nav_menu'));
                $post_type->setShowInAdminBar($this->request->get('post-type-show_in_admin_bar'));
                $post_type->setMenuPosition($this->request->get('post-type-menu_position'));
                $post_type->setMenuIcon($this->request->get('post-type-menu_icon'));
                $post_type->setCapabilityType($this->request->get('post-type-capability_type'));
                $post_type->setCapabilities($this->request->get('post-type-capabilities'));
                $post_type->setMapMetaCap($this->request->get('post-type-map_meta_cap'));
                $post_type->setSupports($this->request->get('post-type-supports'));
                $post_type->setRegisterMetaBoxCb($this->request->get('post-type-register_meta_box_cb'));
                $post_type->setTaxonomies($this->request->get('post-type-taxonomies'));
                $post_type->setHasArchive($this->request->get('post-type-has_archive'));
                $post_type->setQueryVar($this->request->get('post-type-query_var'));
                $post_type->setCanExport($this->request->get('post-type-can_export'));
                if(!$this->is_empty($this->request->get('post-type-delete_with_user')))
                $post_type->setDeleteWithUser($this->request->get('post-type-delete_with_user'));
                $post_type->setBuiltin($this->request->get('post-type-builtin'));
                $post_type->setEditLink($this->request->get('post-type-edit_link'));
                $post_type->setRewrite($rewrite_obj->toArray());



                $this->db_ctx->getCustomPosts()->create($post_type);

            }

        }
        return array("view"=>'custom-post/add','a'=>'show');
    }

    function edit()
    {



        if($this->request->get('wwm-save')!=null && !$this->is_empty($this->request->get('wwm-save')) && $this->request->get('wwm-save')==1)
        {
            if($this->request->get('wwm-save')!=null && !$this->is_empty($this->request->get('wwm-save')) && $this->request->get('wwm-save')==1)
            {

                if($this->is_empty($this->request->get('post-type-name')))
                {
                    $this->warn[] = "Post type is required";
                }

                if($this->is_empty($this->request->get('labels')) || $this->is_empty($this->request->get('labels')['name']))
                {
                    $this->warn[] = "name field in the Labels is required";
                }

                if($this->is_empty($this->request->get('rewrite')) || $this->is_empty($this->request->get('rewrite')['slug']))
                {
                    $this->warn[] = "Rewrite slug is required";
                }

                if(empty($this->warn))
                {
                    $post_type1 = $this->db_ctx->getCustomPosts()->getCustomPostByName($_REQUEST['post-type']);
                    $rewrite_obj = new CustomPostRewrite();
                    $rewrite_obj->initObject($this->request->get('rewrite'));

                    $post_type1->setPostType($this->request->get('post-type-name'));
                    $post_type1->setLabel($this->request->get('labels')['name']);
                    $post_type1->setLabels($this->request->get('labels'));
                    $post_type1->setName($this->request->get('post-type-name'));
                    $post_type1->setDescription($this->request->get('post-type-description'));
                    $post_type1->setPublic($this->request->get('post-type-public'));
                    $post_type1->setHierarchical($this->request->get('post-type-hierarchical'));
                    $post_type1->setExcludeFromSearch($this->request->get('post-type-exclude_from_search'));
                    $post_type1->setPubliclyQueryable($this->request->get('post-type-publicly_queryable'));
                    $post_type1->setShowUi($this->request->get('post-type-show_ui'));
                    $post_type1->setShowInMenu($this->request->get('post-type-show_in_menu'));
                    $post_type1->setShowInNavMenus($this->request->get('post-type-show_in_nav_menu'));
                    $post_type1->setShowInAdminBar($this->request->get('post-type-show_in_admin_bar'));
                    $post_type1->setMenuPosition($this->request->get('post-type-menu_position'));
                    $post_type1->setMenuIcon($this->request->get('post-type-menu_icon'));
                    $post_type1->setCapabilityType($this->request->get('post-type-capability_type'));
                    $post_type1->setCapabilities($this->request->get('post-type-capabilities'));
                    $post_type1->setMapMetaCap($this->request->get('post-type-map_meta_cap'));
                    $post_type1->setSupports($this->request->get('post-type-supports'));
                    $post_type1->setRegisterMetaBoxCb($this->request->get('post-type-register_meta_box_cb'));
                    $post_type1->setTaxonomies($this->request->get('post-type-taxonomies'));
                    $post_type1->setHasArchive($this->request->get('post-type-has_archive'));
                    $post_type1->setQueryVar($this->request->get('post-type-query_var'));
                    $post_type1->setCanExport($this->request->get('post-type-can_export'));
                    if(!$this->is_empty($this->request->get('post-type-delete_with_user')))
                        $post_type1->setDeleteWithUser($this->request->get('post-type-delete_with_user'));
                    $post_type1->setBuiltin($this->request->get('post-type-builtin'));
                    $post_type1->setEditLink($this->request->get('post-type-edit_link'));
                    $post_type1->setRewrite($rewrite_obj->toArray());

                    $this->db_ctx->getCustomPosts()->update($post_type1);


                }

            }
        }
        $post_type = $this->db_ctx->getCustomPosts()->getCustomPostByName($_REQUEST['post-type']);

        return array("view"=>'custom-post/edit','a'=>'show','post_type'=>$post_type);
    }

    function del()
    {
        global $wp_roles;


        if(isset($_REQUEST['post-type'])) {

            $post_type = $this->db_ctx->getCustomPosts()->getCustomPostByName($_REQUEST['post-type']);
            if($post_type!=null)
            {
                $capsList = $post_type->getCapabilities();


                if($post_type->getCapabilityType()!='post') {
                    /** @var WP_Role $role */
                    foreach ($wp_roles->roles as $role) {

                        foreach ($capsList as $key => $val) {

                            if(in_array($val, array_keys($role['capabilities']))) {
                                $wp_roles->remove_cap($role['name'], $val);
                            }
                        }
                    }
                }
            }
            $this->db_ctx->getCustomPosts()->delete($_REQUEST['post-type']);
        }

    }

    function editRoles()
    {
        global $wp_roles;
        $role = get_role(array_keys($wp_roles->roles)[0]);

        $this->db_ctx->getCustomPosts()->getCapabilitiesByPostType($_REQUEST['post-type']);
        return array("view"=>'custom-post/edit-roles');
    }

    function setManager()
    {
        $_REQUEST['a'] = (isset($_REQUEST['a']) && !empty($_REQUEST['a'])) ? $_REQUEST['a'] : 'show';
        switch($_REQUEST['a'])
        {
            case 'show':
                $this->response_params = $this->show();
                break;
           case 'add':
                $this->response_params = $this->add();
                break;
            case 'edit':
                $this->response_params = $this->edit();
                break;
            case 'del':
                $this->response_params = $this->del();
                break;
            case 'edit-roles':
                $this->response_params = $this->editRoles();
                break;
        }
        if(!isset($this->response_params['view']))
        {
            $this->response_params['view'] = 'custom-post/list';
        }
        if(!isset($this->response_params['query']))
        {
            $this->response_params['query'] = array();
        }
        return $this->response_params;
    }


}
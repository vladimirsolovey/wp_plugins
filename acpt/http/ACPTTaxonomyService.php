<?php
/**
  * Date: 15.02.17
 * Time: 09:50
 */

namespace wichita_webmasters_acpt\http;


use wichita_webmasters_acpt\domain\CustomTaxonomy;
use wichita_webmasters_acpt\domain\CustomTaxonomyRewrite;

require_once WWMACPT_PLUGIN_DIR.'http/BaseClass.php';
require_once WWMACPT_PLUGIN_DIR.'domain/CustomTaxonomyLabels.php';
require_once WWMACPT_PLUGIN_DIR.'domain/CustomTaxonomyRewrite.php';

class ACPTTaxonomyService extends BaseClass
{
    function __construct()
    {
        parent::__construct();

    }

    function show()
    {
        $customTaxonomies = $this->db_ctx->getCustomTaxonomies()->getAllTaxonomies();

        return array("customTaxonomies"=>$customTaxonomies);
    }

    function add()
    {
        if($this->request->get('wwm-save')!=null && !$this->is_empty($this->request->get('wwm-save')) && $this->request->get('wwm-save')==1)
        {

            if($this->is_empty($this->request->get('taxonomy-name')))
            {
                $this->warn[] = "Taxonomy is required";
            }

            if($this->is_empty($this->request->get('labels')) || $this->is_empty($this->request->get('labels')['name']))
            {
                $this->warn[] = "Name field in the Labels is required";
            }

            if($this->is_empty($this->request->get('rewrite')) || $this->is_empty($this->request->get('rewrite')['slug']))
            {
                $this->warn[] = "Rewrite slug is required";
            }
            if($this->db_ctx->getCustomTaxonomies()->isExists($this->request->get('post-type-name')))
            {
                $this->warn[] = 'Taxonomy with this name is already exists';
            }
            if(empty($this->warn))
            {
                $rewrite_obj = new CustomTaxonomyRewrite();
                $rewrite_obj->initObject($this->request->get('rewrite'));
                $taxonomy = new CustomTaxonomy();
                $taxonomy->setTaxonomy($this->request->get("taxonomy-name"));
                $taxonomy->setObjectType($this->request->get("taxonomy-object_type"));
                $taxonomy->setLabel($this->request->get('labels')['name']);
                $taxonomy->setLabels($this->request->get('labels'));
                $taxonomy->setPublic($this->request->get('taxonomy-public'));
                $taxonomy->setPubliclyQueryable($this->request->get('taxonomy-publicly_queryable'));
                $taxonomy->setDescription($this->request->get('taxonomy-description'));
                $taxonomy->setHierarchical($this->request->get('taxonomy-hierarchical'));
                $taxonomy->setShowUi($this->request->get('taxonomy-show_ui'));
                $taxonomy->setShowInMenu($this->request->get('taxonomy-show_in_menu'));
                $taxonomy->setShowInNavMenus($this->request->get('taxonomy-show_in_nav_menus'));
                $taxonomy->setShowTagCloud($this->request->get('taxonomy-show_tagcloud'));
                $taxonomy->setShowInQuickEdit($this->request->get('taxonomy-show_in_quick_edit'));
                $taxonomy->setShowAdminColumn($this->request->get('taxonomy-show_admin_column'));
                $taxonomy->setMetaBoxCb($this->request->get('taxonomy-meta_box_cb'));
                $taxonomy->setRewrite($rewrite_obj->toArray());
                $taxonomy->setQueryVar($this->request->get('taxonomy-query_var'));
                $taxonomy->setUpdateCountCallback($this->request->get('taxonomy-update_count_callback'));
                $taxonomy->setName($this->request->get("taxonomy-name"));


                $this->db_ctx->getCustomTaxonomies()->create($taxonomy);

            }

        }
        return array("view"=>'custom-taxonomies/add','a'=>'show');
    }

    function edit()
    {
        if($this->request->get('wwm-save')!=null && !$this->is_empty($this->request->get('wwm-save')) && $this->request->get('wwm-save')==1)
        {
            if($this->request->get('wwm-save')!=null && !$this->is_empty($this->request->get('wwm-save')) && $this->request->get('wwm-save')==1)
            {

                if($this->is_empty($this->request->get('taxonomy-name')))
                {
                    $this->warn[] = "Taxonomy is required";
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

                    $taxonomy = $this->db_ctx->getCustomTaxonomies()->getTaxonomyByName($_REQUEST['taxonomy']);
                    if($taxonomy) {
                        $rewrite_obj = new CustomTaxonomyRewrite();
                        $rewrite_obj->initObject($this->request->get('rewrite'));

                        $taxonomy->setTaxonomy($this->request->get("taxonomy-name"));
                        $taxonomy->setObjectType($this->request->get("taxonomy-object_type"));
                        $taxonomy->setLabel($this->request->get('labels')['name']);
                        $taxonomy->setLabels($this->request->get('labels'));
                        $taxonomy->setPublic($this->request->get('taxonomy-public'));
                        $taxonomy->setPubliclyQueryable($this->request->get('taxonomy-publicly_queryable'));
                        $taxonomy->setDescription($this->request->get('taxonomy-description'));
                        $taxonomy->setHierarchical($this->request->get('taxonomy-hierarchical'));
                        $taxonomy->setShowUi($this->request->get('taxonomy-show_ui'));
                        $taxonomy->setShowInMenu($this->request->get('taxonomy-show_in_menu'));
                        $taxonomy->setShowInNavMenus($this->request->get('taxonomy-show_in_nav_menus'));
                        $taxonomy->setShowTagCloud($this->request->get('taxonomy-show_tagcloud'));
                        $taxonomy->setShowInQuickEdit($this->request->get('taxonomy-show_in_quick_edit'));
                        $taxonomy->setShowAdminColumn($this->request->get('taxonomy-show_admin_column'));
                        $taxonomy->setMetaBoxCb($this->request->get('taxonomy-meta_box_cb'));
                        $taxonomy->setRewrite($rewrite_obj->toArray());
                        $taxonomy->setQueryVar($this->request->get('taxonomy-query_var'));
                        $taxonomy->setUpdateCountCallback($this->request->get('taxonomy-update_count_callback'));
                        $taxonomy->setName($this->request->get("taxonomy-name"));
                        $taxonomy->setCapabilities($this->request->get("taxonomy-capabilities"));

                        $this->db_ctx->getCustomTaxonomies()->update($taxonomy);
                    }

                }

            }
        }
        $taxonomy = $this->db_ctx->getCustomTaxonomies()->getTaxonomyByName($_REQUEST['taxonomy']);

        return array("view"=>'custom-taxonomies/edit','a'=>'show','taxonomy'=>$taxonomy);
    }
    function del()
    {


        if(isset($_REQUEST['taxonomy'])) {

            $this->db_ctx->getCustomTaxonomies()->delete($_REQUEST['taxonomy']);
        }
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

        }
        if(!isset($this->response_params['view']))
        {
            $this->response_params['view'] = 'custom-taxonomies/list';
        }
        if(!isset($this->response_params['query']))
        {
            $this->response_params['query'] = array();
        }
        return $this->response_params;
    }
}
<?php
/**
  * Date: 08.02.17
 * Time: 14:28
 */

namespace wichita_webmasters_acpt\domain;


class CustomPost
{
    /**
     * @var string
     */
    private $post_type;

    /**
     * @var string
     */
    private $label;
    /**
     * @var string
     */
    private $name;
    /**
     * @var array|object
     */
    private $labels=array();
    private $description='';
    private $public = false;
    private $hierarchical = false;
    private $exclude_from_search=null;
    private $publicly_queryable=null;
    private $show_ui=null;
    private $show_in_menu=null;
    private $show_in_nav_menus=null;
    private $show_in_admin_bar=null;
    private $menu_position = null;
    private $menu_icon=null;
    private $capability_type='post';
    /**
     * @var array|object
     */
    private $capabilities=array();
    private $map_meta_cap = false;
    private $supports=array('title','editor');
    private $register_meta_box_cb=null;
    private $taxonomies=array();
    private $has_archive=false;
    private $rewrite = array();
    /**
     * @var bool|string
     */
    private $query_var = true;
    private $can_export = true;
    private $delete_with_user = null;
    private $_builtin = false;
    private $_edit_link = 'post.php?post=%id';


    /**
     * @return string
     */
    public function getPostType()
    {
        return $this->post_type;
    }

    /**
     * @param string $post_type
     */
    public function setPostType($post_type)
    {
        $this->post_type = strtolower($post_type);
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param string $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * @return array|object
     */
    public function getLabels()
    {
        return $this->labels;
    }

    /**
     * @param array|object $labels
     */
    public function setLabels($labels)
    {
        $this->labels = $labels;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return boolean
     */
    public function isPublic()
    {
        return $this->public;
    }

    /**
     * @param boolean $public
     */
    public function setPublic($public)
    {
        $this->public = (boolean)$public;
    }

    /**
     * @return boolean
     */
    public function isHierarchical()
    {
        return $this->hierarchical;
    }

    /**
     * @param boolean $hierarchical
     */
    public function setHierarchical($hierarchical)
    {
        $this->hierarchical = (boolean)$hierarchical;
    }

    /**
     * @return bool
     */
    public function getExcludeFromSearch()
    {
        return $this->exclude_from_search;
    }

    /**
     * @param bool|null $exclude_from_search
     */
    public function setExcludeFromSearch($exclude_from_search)
    {
        $this->exclude_from_search = !empty($exclude_from_search)?(boolean)$exclude_from_search:!$this->public;
    }

    /**
     * @return bool
     */
    public function getPubliclyQueryable()
    {
        return $this->publicly_queryable;
    }

    /**
     * @param bool|null $publicly_queryable
     */
    public function setPubliclyQueryable($publicly_queryable)
    {
        $this->publicly_queryable = !empty($publicly_queryable)?(boolean)$publicly_queryable:$this->public;
    }

    /**
     * @return boolean
     */
    public function getShowUi()
    {
        return $this->show_ui;
    }

    /**
     * @param boolean $show_ui
     */
    public function setShowUi($show_ui)
    {
        $this->show_ui = (boolean)$show_ui;
    }

    /**
     * @return boolean
     */
    public function getShowInMenu()
    {
        return $this->show_in_menu;
    }

    /**
     * @param boolean $show_in_menu
     */
    public function setShowInMenu($show_in_menu)
    {
        $this->show_in_menu = (boolean)$show_in_menu;
    }

    /**
     * @return bool
     */
    public function getShowInNavMenus()
    {

        return $this->show_in_nav_menus;
    }

    /**
     * @param bool $show_in_nav_menus
     */
    public function setShowInNavMenus($show_in_nav_menus)
    {
        $this->show_in_nav_menus = (boolean)$show_in_nav_menus;
    }

    /**
     * @return bool
     */
    public function getShowInAdminBar()
    {
        return $this->show_in_admin_bar;
    }

    /**
     * @param bool $show_in_admin_bar
     */
    public function setShowInAdminBar($show_in_admin_bar)
    {
        $this->show_in_admin_bar = (boolean)$show_in_admin_bar;
    }

    /**
     * @return int|null
     */
    public function getMenuPosition()
    {
        return $this->menu_position;
    }

    /**
     * @param int|null $menu_position
     */
    public function setMenuPosition($menu_position)
    {
        $this->menu_position = !empty($menu_position)?intval($menu_position):null;
    }

    /**
     * @return string|null
     */
    public function getMenuIcon()
    {
        return $this->menu_icon;
    }

    /**
     * @param string|null $menu_icon
     */
    public function setMenuIcon($menu_icon)
    {
        $this->menu_icon = !empty($menu_icon)?$menu_icon:null;
    }

    /**
     * @return string
     */
    public function getCapabilityType()
    {
        return $this->capability_type;
    }

    /**
     * @param string $capability_type
     */
    public function setCapabilityType($capability_type)
    {
        if(isset($capability_type) && !empty($capability_type))
        $this->capability_type = $capability_type;
    }

    /**
     * @return array|object
     */
    public function getCapabilities()
    {
        return $this->capabilities;
    }

    /**
     * @param array|object $capabilities
     */
    public function setCapabilities($capabilities)
    {
        $this->capabilities = !empty($capabilities)?$capabilities:array();
    }

    /**
     * @return boolean
     */
    public function isMapMetaCap()
    {
        return $this->map_meta_cap;
    }

    /**
     * @param boolean $map_meta_cap
     */
    public function setMapMetaCap($map_meta_cap)
    {
        $this->map_meta_cap = (boolean)$map_meta_cap;
    }

    /**
     * @return string
     */
    public function getSupports()
    {
        if(!empty($this->supports))
        {
            return implode(", ",$this->supports);
        }
        return '';

    }

    /**
     * @param array $supports
     */
    public function setSupports($supports)
    {
        $supports = preg_replace('/\s+/','',$supports);
        if(!empty($supports))
        {
            $this->supports = explode(",",$supports);
        }
    }

    /**
     * @return string|null
     */
    public function getRegisterMetaBoxCb()
    {
        return $this->register_meta_box_cb;
    }

    /**
     * @param string|null $register_meta_box_cb
     */
    public function setRegisterMetaBoxCb($register_meta_box_cb)
    {
        $this->register_meta_box_cb = !empty($register_meta_box_cb)?$register_meta_box_cb:null;
    }

    /**
     * @return string
     */
    public function getTaxonomies()
    {
        if(!empty($this->taxonomies))
        {
            return implode(", ",$this->taxonomies);
        }
        return '';
    }

    /**
     * @param array $taxonomies
     */
    public function setTaxonomies($taxonomies)
    {
        if(!empty($taxonomies))
        {
            if(is_array($taxonomies))
            {
                $this->taxonomies = $taxonomies;
            }
            else {
                $this->taxonomies = explode(',', $taxonomies);
            }
        }

    }

    /**
     * @return boolean
     */
    public function isHasArchive()
    {
        return $this->has_archive;
    }

    /**
     * @param boolean $has_archive
     */
    public function setHasArchive($has_archive)
    {
        $this->has_archive = (boolean)$has_archive;
    }

    /**
     * @return array
     */
    public function getRewrite()
    {
        return $this->rewrite;
    }

    /**
     * @param array $rewrite
     */
    public function setRewrite($rewrite)
    {
        $this->rewrite = $rewrite;
    }

    /**
     * @return string
     */
    public function isQueryVar()
    {
        if(is_bool($this->query_var))
        {
                if($this->query_var) {
                    return 'true';
                }
                else {
                    return 'false';
                }
        }
        return $this->query_var;
    }

    /**
     * @param boolean|string $query_var
     */
    public function setQueryVar($query_var)
    {
        if(empty($query_var) || $query_var=='true') {
            $this->query_var = true;
        }
        elseif($query_var=='false') {
            $this->query_var = false;
        }else {

            $this->query_var = $query_var;
        }
    }

    /**
     * @return boolean
     */
    public function isCanExport()
    {
        return $this->can_export;
    }

    /**
     * @param boolean $can_export
     */
    public function setCanExport($can_export)
    {
        $this->can_export = (boolean)$can_export;
    }

    /**
     * @return boolean
     */
    public function getDeleteWithUser()
    {
        return $this->delete_with_user;
    }

    /**
     * @param boolean $delete_with_user
     */
    public function setDeleteWithUser($delete_with_user)
    {
        $this->delete_with_user = (boolean)$delete_with_user;
    }

    /**
     * @return boolean
     */
    public function isBuiltin()
    {
        return $this->_builtin;
    }

    /**
     * @param boolean $builtin
     */
    public function setBuiltin($builtin)
    {
        $this->_builtin = (boolean)$builtin;

    }

    /**
     * @return string
     */
    public function getEditLink()
    {
        return $this->_edit_link;
    }

    /**
     * @param string $edit_link
     */
    public function setEditLink($edit_link)
    {
        $this->_edit_link = !empty($edit_link)?$edit_link:'post.php?post=%d';
    }


    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    public function toArray()
    {
        return get_object_vars($this);
    }


    private function toBoolVal($var)
    {
        (boolean)$var;
        filter_var($var,FILTER_VALIDATE_BOOLEAN);
    }


}
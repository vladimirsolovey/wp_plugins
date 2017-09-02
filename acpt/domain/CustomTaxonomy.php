<?php
/**
  * Date: 15.02.17
 * Time: 09:55
 */

namespace wichita_webmasters_acpt\domain;


class CustomTaxonomy
{
    /**
     * @var
     */
    private $taxonomy;
    /**
     * @var null
     */
    private $object_type = null;
    /**
     * @var
     */
    private $label;
    /**
     * @var array
     */
    private $labels=array();
    /**
     * @var bool
     */
    private $public=true;
    /**
     * @var bool
     */
    private $publicly_queryable = true;
    /**
     * @var string
     */
    private $description = '';
    /**
     * @var bool
     */
    private $hierarchical = false;
    /**
     * @var null
     */
    private $show_ui = null;
    /**
     * @var null
     */
    private $show_in_menu = null;
    /**
     * @var null
     */
    private $show_in_nav_menus = null;
    /**
     * @var null
     */
    private $show_tagcloud = null;
    /**
     * @var null
     */
    private $show_in_quick_edit	= null;
    /**
     * @var bool
     */
    private $show_admin_column = false;
    /**
     * @var string
     */
    private $meta_box_cb = null;
    /**
     * @var array
     */
    private $capabilities = array();
    /**
     * @var array
     */
    private $rewrite = array();
    /**
     * @var string
     */
    private $query_var;
    /**
     * @var string
     */
    private $update_count_callback = '';
    /**
     * @var bool
     */
    private $_builtin = false;

    /**
     * @var string
     */
    private $name;

    /**
     * @return mixed
     */
    public function getTaxonomy()
    {
        return $this->taxonomy;
    }

    /**
     * @param mixed $taxonomy
     */
    public function setTaxonomy($taxonomy)
    {
        $this->taxonomy = strtolower($taxonomy);
    }

    /**
     * @return string
     */
    public function getObjectType()
    {
        if(!empty($this->object_type)) {
            return implode(",", $this->object_type);
        }
        return '';
    }

    /**
     * @param array $object_type
     */
    public function setObjectType($object_type)
    {
        if(is_array($object_type)) {
            $this->object_type = $object_type;
        }
        else
        {
        $this->object_type = !empty($object_type)?explode(",",$object_type):array();
        }
    }

    /**
     * @return mixed
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param mixed $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * @return array
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
    public function isPubliclyQueryable()
    {
        return $this->publicly_queryable;
    }

    /**
     * @param boolean $publicly_queryable
     */
    public function setPubliclyQueryable($publicly_queryable)
    {
        $this->publicly_queryable = !empty($publicly_queryable)?(boolean)$publicly_queryable:$this->public;
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
        $this->show_ui = isset($show_ui)&&!empty($show_ui)?(boolean)$show_ui:$this->public;
    }

    /**
     * @return null
     */
    public function getShowInMenu()
    {
        return $this->show_in_menu;
    }

    /**
     * @param null $show_in_menu
     */
    public function setShowInMenu($show_in_menu)
    {
        $this->show_in_menu = (boolean)$show_in_menu;
    }

    /**
     * @return boolean
     */
    public function getShowInNavMenus()
    {
        return $this->show_in_nav_menus;
    }

    /**
     * @param boolean $show_in_nav_menus
     */
    public function setShowInNavMenus($show_in_nav_menus)
    {
        $this->show_in_nav_menus = (boolean)$show_in_nav_menus;
    }

    /**
     * @return boolean
     */
    public function getShowTagCloud()
    {
        return $this->show_tagcloud;
    }

    /**
     * @param boolean $show_tagcloud
     */
    public function setShowTagCloud($show_tagcloud)
    {
        $this->show_tagcloud = isset($show_tagcloud)?(boolean)$show_tagcloud:$this->show_ui;
    }

    /**
     * @return boolean
     */
    public function getShowInQuickEdit()
    {
        return $this->show_in_quick_edit;
    }

    /**
     * @param boolean $show_in_quick_edit
     */
    public function setShowInQuickEdit($show_in_quick_edit)
    {
        $this->show_in_quick_edit = isset($show_in_quick_edit)?(boolean)$show_in_quick_edit:$this->show_ui;
    }

    /**
     * @return boolean
     */
    public function isShowAdminColumn()
    {
        return $this->show_admin_column;
    }

    /**
     * @param boolean $show_admin_column
     */
    public function setShowAdminColumn($show_admin_column)
    {
        $this->show_admin_column = (boolean)$show_admin_column;
    }

    /**
     * @return string
     */
    public function getMetaBoxCb()
    {
        return $this->meta_box_cb;
    }

    /**
     * @param string $meta_box_cb
     */
    public function setMetaBoxCb($meta_box_cb)
    {
        if(!isset($meta_box_cb) || $meta_box_cb=='')
        {
            $this->meta_box_cb = null;
        }else {
            $this->meta_box_cb = $meta_box_cb;
        }
    }

    /**
     * @return array
     */
    public function getCapabilities()
    {
        return $this->capabilities;
    }

    /**
     * @param array $capabilities
     */
    public function setCapabilities($capabilities)
    {
        $this->capabilities = !empty($capabilities)?$capabilities:array();
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
    public function getQueryVar()
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

            $this->query_var = (isset($query_var)&&!empty($query_var))?$query_var:$this->taxonomy ;
        }
    }

    /**
     * @return string
     */
    public function getUpdateCountCallback()
    {
        return $this->update_count_callback;
    }

    /**
     * @param string $update_count_callback
     */
    public function setUpdateCountCallback($update_count_callback)
    {
        $this->update_count_callback = $update_count_callback;
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

}
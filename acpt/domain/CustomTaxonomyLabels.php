<?php
/**
  * Date: 15.02.17
 * Time: 09:59
 */

namespace wichita_webmasters_acpt\domain;


class CustomTaxonomyLabels
{

    /**
     * @var string
     */
    public $name = "__ITEM__s";
    /**
     * @var string
     */
    public $singular_name;
    /**
     * @var string
     */
    public $menu_name; //dafault has $name value
    /**
     * @var string
     */
    public $all_items = "All __ITEM__s";
    /**
     * @var string
     */
    public $edit_item = "Edit __ITEM__";
    /**
     * @var string
     */
    public $view_item = "View __ITEM__";
    /**
     * @var string
     */
    public $update_item = "Update __ITEM__";
    /**
     * @var string
     */
    public $add_new_item = "Add New __ITEM__";
    /**
     * @var string
     */
    public $new_item_name = "New __ITEM__ Name";
    /**
     * @var string
     */
    public $parent_item = "Parent __ITEM__";
    /**
     * @var string
     */
    public $parent_item_colon ="Parent __ITEM__:";
    /**
     * @var string
     */
    public $search_items = "Search __ITEM__s";
    /**
     * @var string
     */
    public $popular_items = "Popular __ITEM__s";
    /**
     * @var string
     */
    public $separate_items_with_commas = "Separate __ITEM__s by comma";
    /**
     * @var string
     */
    public $add_or_remove_items = "Add or Remove __ITEM__s";
    /**
     * @var string
     */
    public $choose_from_most_used = "Choose from the most used __ITEM__s";
    /**
     * @var string
     */
    public $not_found = "No __ITEM__s found";
    public $no_terms = "No __ITEM__s";
    public $items_list_navigation = "__ITEM__s list navigation";
    public $items_list = "__ITEM__s list";
    public $name_admin_bar = "__ITEM__";
    public $archives = "All __ITEM__s";



    function __construct($customTaxonomyName)
    {
        $this->singular_name =$customTaxonomyName;
        $this->initDefault();
    }
    function initDefault()
    {
        $arr_properties = get_object_vars($this);

        foreach($arr_properties as $key=>$val)
        {
            if($key!='singular_name')
            {
                $this->$key=preg_replace('/__ITEM__/',$this->singular_name,$val);
                $this->$key=preg_replace('/ie$/','y',$val);
            }
        }
    }

    function toArray()
    {
        return get_object_vars($this);
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

    /**
     * @return string
     */
    public function getSingularName()
    {
        return $this->singular_name;
    }

    /**
     * @param string $singular_name
     */
    public function setSingularName($singular_name)
    {
        $this->singular_name = $singular_name;
    }

    /**
     * @return string
     */
    public function getMenuName()
    {
        return $this->menu_name;
    }

    /**
     * @param string $menu_name
     */
    public function setMenuName($menu_name)
    {
        $this->menu_name = $menu_name;
    }

    /**
     * @return string
     */
    public function getAllItems()
    {
        return $this->all_items;
    }

    /**
     * @param string $all_items
     */
    public function setAllItems($all_items)
    {
        $this->all_items = $all_items;
    }

    /**
     * @return string
     */
    public function getEditItem()
    {
        return $this->edit_item;
    }

    /**
     * @param string $edit_item
     */
    public function setEditItem($edit_item)
    {
        $this->edit_item = $edit_item;
    }

    /**
     * @return string
     */
    public function getViewItem()
    {
        return $this->view_item;
    }

    /**
     * @param string $view_item
     */
    public function setViewItem($view_item)
    {
        $this->view_item = $view_item;
    }

    /**
     * @return string
     */
    public function getUpdateItem()
    {
        return $this->update_item;
    }

    /**
     * @param string $update_item
     */
    public function setUpdateItem($update_item)
    {
        $this->update_item = $update_item;
    }

    /**
     * @return string
     */
    public function getAddNewItem()
    {
        return $this->add_new_item;
    }

    /**
     * @param string $add_new_item
     */
    public function setAddNewItem($add_new_item)
    {
        $this->add_new_item = $add_new_item;
    }

    /**
     * @return string
     */
    public function getNewItemName()
    {
        return $this->new_item_name;
    }

    /**
     * @param string $new_item_name
     */
    public function setNewItemName($new_item_name)
    {
        $this->new_item_name = $new_item_name;
    }

    /**
     * @return string
     */
    public function getParentItem()
    {
        return $this->parent_item;
    }

    /**
     * @param string $parent_item
     */
    public function setParentItem($parent_item)
    {
        $this->parent_item = $parent_item;
    }

    /**
     * @return string
     */
    public function getParentItemColon()
    {
        return $this->parent_item_colon;
    }

    /**
     * @param string $parent_item_colon
     */
    public function setParentItemColon($parent_item_colon)
    {
        $this->parent_item_colon = $parent_item_colon;
    }

    /**
     * @return string
     */
    public function getSearchItems()
    {
        return $this->search_items;
    }

    /**
     * @param string $search_items
     */
    public function setSearchItems($search_items)
    {
        $this->search_items = $search_items;
    }

    /**
     * @return string
     */
    public function getPopularItems()
    {
        return $this->popular_items;
    }

    /**
     * @param string $popular_items
     */
    public function setPopularItems($popular_items)
    {
        $this->popular_items = $popular_items;
    }

    /**
     * @return string
     */
    public function getSeparateItemsWithCommas()
    {
        return $this->separate_items_with_commas;
    }

    /**
     * @param string $separate_items_with_commas
     */
    public function setSeparateItemsWithCommas($separate_items_with_commas)
    {
        $this->separate_items_with_commas = $separate_items_with_commas;
    }

    /**
     * @return string
     */
    public function getAddOrRemoveItems()
    {
        return $this->add_or_remove_items;
    }

    /**
     * @param string $add_or_remove_items
     */
    public function setAddOrRemoveItems($add_or_remove_items)
    {
        $this->add_or_remove_items = $add_or_remove_items;
    }

    /**
     * @return string
     */
    public function getChooseFromMostUsed()
    {
        return $this->choose_from_most_used;
    }

    /**
     * @param string $choose_from_most_used
     */
    public function setChooseFromMostUsed($choose_from_most_used)
    {
        $this->choose_from_most_used = $choose_from_most_used;
    }

    /**
     * @return string
     */
    public function getNotFound()
    {
        return $this->not_found;
    }

    /**
     * @param string $not_found
     */
    public function setNotFound($not_found)
    {
        $this->not_found = $not_found;
    }

    /**
     * @return string
     */
    public function getNoTerms()
    {
        return $this->no_terms;
    }

    /**
     * @param string $no_terms
     */
    public function setNoTerms($no_terms)
    {
        $this->no_terms = $no_terms;
    }

    /**
     * @return string
     */
    public function getItemsListNavigation()
    {
        return $this->items_list_navigation;
    }

    /**
     * @param string $items_list_navigation
     */
    public function setItemsListNavigation($items_list_navigation)
    {
        $this->items_list_navigation = $items_list_navigation;
    }

    /**
     * @return string
     */
    public function getItemsList()
    {
        return $this->items_list;
    }

    /**
     * @param string $items_list
     */
    public function setItemsList($items_list)
    {
        $this->items_list = $items_list;
    }

    /**
     * @return string
     */
    public function getNameAdminBar()
    {
        return $this->name_admin_bar;
    }

    /**
     * @param string $name_admin_bar
     */
    public function setNameAdminBar($name_admin_bar)
    {
        $this->name_admin_bar = $name_admin_bar;
    }

    /**
     * @return string
     */
    public function getArchives()
    {
        return $this->archives;
    }

    /**
     * @param string $archives
     */
    public function setArchives($archives)
    {
        $this->archives = $archives;
    }




}
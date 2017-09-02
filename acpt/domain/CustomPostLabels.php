<?php
/**
  * Date: 08.02.17
 * Time: 14:59
 */

namespace wichita_webmasters_acpt\domain;


class CustomPostLabels
{
private $name = "__ITEM__s";
private $singular_name;
private $add_new = 'Add New';
private $add_new_item = 'Add New __ITEM__';
private $edit_item = 'Edit __ITEM__';
private $new_item = 'New __ITEM__';
private $view_item = 'View __ITEM__';
private $view_items = 'View __ITEM__s';
private $search_items = 'Search __ITEM__';
private $not_found = 'Not __ITEM__ found';
private $not_found_in_trash = 'No __ITEM__ found in Trash';
private $parent_item_colon = 'Parent __ITEM__:';
private $all_items = 'All __ITEM__s';
private $archives = '__ITEM__ Archives';
private $attributes = '__ITEM__ Attributes';
private $insert_into_item = 'Insert into __ITEM__';
private $uploaded_to_this_item = 'Uploaded to the __ITEM__';
private $featured_image = 'Featured Image’';
private $set_featured_image = 'Set featured image';
private $remove_featured_image = 'Remove featured image';
private $use_featured_image = 'Use as featured image';
private $menu_name = "__ITEM__s";
private $filter_items_list = 'Filter __ITEM__s list';
private $items_list_navigation = '__ITEM__s list navigation';
private $add_item = 'New __ITEM__ Items';
private $items_list = '__ITEM__s list';
    private $name_admin_bar = '__ITEM__ Item';

    function __construct($customPostName)
    {
        $this->singular_name = $customPostName;
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
     * @return mixed
     */
    public function getSingularName()
    {
        return $this->singular_name;
    }

    /**
     * @param mixed $singular_name
     */
    public function setSingularName($singular_name)
    {
        $this->singular_name = $singular_name;
    }

    /**
     * @return string
     */
    public function getAddNew()
    {
        return $this->add_new;
    }

    /**
     * @param string $add_new
     */
    public function setAddNew($add_new)
    {
        $this->add_new = $add_new;
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
    public function getNewItem()
    {
        return $this->new_item;
    }

    /**
     * @param string $new_item
     */
    public function setNewItem($new_item)
    {
        $this->new_item = $new_item;
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
    public function getViewItems()
    {
        return $this->view_items;
    }

    /**
     * @param string $view_items
     */
    public function setViewItems($view_items)
    {
        $this->view_items = $view_items;
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
    public function getNotFoundInTrash()
    {
        return $this->not_found_in_trash;
    }

    /**
     * @param string $not_found_in_trash
     */
    public function setNotFoundInTrash($not_found_in_trash)
    {
        $this->not_found_in_trash = $not_found_in_trash;
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

    /**
     * @return string
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @param string $attributes
     */
    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * @return string
     */
    public function getInsertIntoItem()
    {
        return $this->insert_into_item;
    }

    /**
     * @param string $insert_into_item
     */
    public function setInsertIntoItem($insert_into_item)
    {
        $this->insert_into_item = $insert_into_item;
    }

    /**
     * @return string
     */
    public function getUploadedToThisItem()
    {
        return $this->uploaded_to_this_item;
    }

    /**
     * @param string $uploaded_to_this_item
     */
    public function setUploadedToThisItem($uploaded_to_this_item)
    {
        $this->uploaded_to_this_item = $uploaded_to_this_item;
    }

    /**
     * @return string
     */
    public function getFeaturedImage()
    {
        return $this->featured_image;
    }

    /**
     * @param string $featured_image
     */
    public function setFeaturedImage($featured_image)
    {
        $this->featured_image = $featured_image;
    }

    /**
     * @return string
     */
    public function getSetFeaturedImage()
    {
        return $this->set_featured_image;
    }

    /**
     * @param string $set_featured_image
     */
    public function setSetFeaturedImage($set_featured_image)
    {
        $this->set_featured_image = $set_featured_image;
    }

    /**
     * @return string
     */
    public function getRemoveFeaturedImage()
    {
        return $this->remove_featured_image;
    }

    /**
     * @param string $remove_featured_image
     */
    public function setRemoveFeaturedImage($remove_featured_image)
    {
        $this->remove_featured_image = $remove_featured_image;
    }

    /**
     * @return string
     */
    public function getUseFeaturedImage()
    {
        return $this->use_featured_image;
    }

    /**
     * @param string $use_featured_image
     */
    public function setUseFeaturedImage($use_featured_image)
    {
        $this->use_featured_image = $use_featured_image;
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
    public function getFilterItemsList()
    {
        return $this->filter_items_list;
    }

    /**
     * @param string $filter_items_list
     */
    public function setFilterItemsList($filter_items_list)
    {
        $this->filter_items_list = $filter_items_list;
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
    public function getAddItem()
    {
        return $this->add_item;
    }

    /**
     * @param string $add_item
     */
    public function setAddItem($add_item)
    {
        $this->add_item = $add_item;
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


}
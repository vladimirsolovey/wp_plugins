<?php
/**
  * Date: 08.02.17
 * Time: 16:50
 */

namespace wichita_webmasters_acpt\models;


use wichita_webmasters_acpt\models\impl\CustomPostsImpl;
use wichita_webmasters_acpt\models\impl\CustomTaxonomiesImpl;

require_once WWMACPT_PLUGIN_DIR.'models/impl/CustomPostsImpl.php';
require_once WWMACPT_PLUGIN_DIR.'models/impl/CustomTaxonomiesImpl.php';

class ModelContext
{
    private $customPosts;
    private $customTaxonomies;

    function __construct()
    {
        $this->customPosts = new CustomPostsImpl();
        $this->customTaxonomies = new CustomTaxonomiesImpl();
    }

    /**
     * @return CustomPostsImpl
     */
    public function getCustomPosts()
    {
        return $this->customPosts;
    }

    /**
     * @return CustomTaxonomiesImpl
     */
    public function getCustomTaxonomies()
    {
        return $this->customTaxonomies;
    }




}
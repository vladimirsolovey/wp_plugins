<?php
/**
  * Date: 16.02.17
 * Time: 15:23
 */

namespace wichita_webmasters_acpt\models\impl;


use wichita_webmasters_acpt\domain\CustomTaxonomy;
use wichita_webmasters_acpt\domain\CustomTaxonomyLabels;
use wichita_webmasters_acpt\models\BaseModel;
use wichita_webmasters_acpt\models\ICustomTaxonomies;


require_once WWMACPT_PLUGIN_DIR.'models/BaseModel.php';
require_once WWMACPT_PLUGIN_DIR.'models/ICustomTaxonomies.php';
require_once WWMACPT_PLUGIN_DIR.'domain/CustomTaxonomy.php';
require_once WWMACPT_PLUGIN_DIR.'domain/CustomTaxonomyLabels.php';

class CustomTaxonomiesImpl extends BaseModel implements ICustomTaxonomies
{
    private $wwm_taxonomies = array();

    function __construct()
    {
        parent::__construct();
         $this->option_name = 'wwm_taxonomies';
    }

    function getAllTaxonomies()
    {
        $arr_posts = array();
        $custom_post_types = $this->getOption();

            $args = array('_builtin' => false);
            $postTypes = get_taxonomies($args, 'object', 'and');


            foreach ($postTypes as $key => $value) {

                if ($custom_post_types && in_array($key, array_keys($custom_post_types))) {
                    $arr_posts[] = $this->initTaxonomyObject($value);
                }
                //$arr_posts[] = $this->initTaxonomyObject($value);


            }

        return $arr_posts;
    }

    function create(CustomTaxonomy $customTaxonomy)
    {
        return $this->update($customTaxonomy);
    }

    function update(CustomTaxonomy $customTaxonomy)
    {
        $this->wwm_taxonomies = $this->getOption();
        $this->wwm_taxonomies[$customTaxonomy->getTaxonomy()]=$customTaxonomy->toArray();

        return update_option($this->option_name,$this->wwm_taxonomies);
    }

    function delete($customTaxonomyName)
    {
        $this->wwm_taxonomies = $this->getOption();
        unset($this->wwm_taxonomies[$customTaxonomyName]);
        return update_option($this->option_name,$this->wwm_taxonomies);
    }

    function isExists($slug)
    {
        $public = get_taxonomies( array( '_builtin' => false, 'public' => true ) );
        $private = get_taxonomies( array( '_builtin' => false, 'public' => false ) );
        $registered_taxonomies = array_merge( $public, $private );
        if ( in_array( $slug, $registered_taxonomies ) ) {
            return true;
        }
        return false;
    }

    function getTaxonomyByName($customTaxonomyName)
    {

        $public = get_taxonomies( array('taxonomy' => $customTaxonomyName ),'object' );

        if(!empty($public)) {
            return $this->initTaxonomyObject($public[$customTaxonomyName]);
        }
        return null;
    }

    private function initTaxonomyObject($args)
    {
        $labels = new CustomTaxonomyLabels($args->labels->name);

        foreach($args->labels as $key=>$val)
        {
            if($val!=null && $key!='singular_name_lowercase' && $key!='plural_name_lowercase')
            {

                $method = preg_replace('/_/',' ',$key);
                $method = ucwords($method);
                $method = preg_replace('/\s+/','',$method);
                $method = 'set'.$method;

                $labels->$method($val);
            }
        }


        $postType = new CustomTaxonomy();


        $postType->setTaxonomy($args->name);
        $postType->setLabels($labels->toArray());
        /** @var array|object|string $val */
        foreach($args as $key=>$val)
        {

                if($val!=null)
                {
                    $method = preg_replace('/_/',' ',$key);
                    $method = ucwords($method);
                    $method = preg_replace('/\s+/','',$method);
                    $method = 'set'.$method;
                    if($key!='labels' && $key!='cap') {
                        $postType->$method($val);
                    }
                }


        }
        $postType->setCapabilities($args->cap);

        return $postType;
    }

}
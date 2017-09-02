<?php
/**
  * Date: 08.02.17
 * Time: 16:45
 */

namespace wichita_webmasters_acpt\models\impl;


use wichita_webmasters_acpt\domain\CustomPost;
use wichita_webmasters_acpt\domain\CustomPostLabels;
use wichita_webmasters_acpt\domain\CustomPostRewrite;
use wichita_webmasters_acpt\models\BaseModel;
use wichita_webmasters_acpt\models\ICustomPosts;
use WP_Post_Type;

require_once WWMACPT_PLUGIN_DIR.'models/BaseModel.php';
require_once WWMACPT_PLUGIN_DIR.'models/ICustomPosts.php';
require_once WWMACPT_PLUGIN_DIR.'domain/CustomPost.php';

/**
 * Class CustomPostsImpl
 * @package wichita_webmasters_acpt\models\impl
 */
class CustomPostsImpl extends BaseModel implements ICustomPosts
{
    private $wwm_cpts = array();

    private $supports = array('title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats');

    function __construct()
    {
        parent::__construct();
        $this->option_name = 'wwm_custom_post_type';
    }

    function getAllCustomPostTypes()
    {
        $arr_posts = array();

        $custom_post_types = $this->getOption();
        if($custom_post_types) {
            $args = array('_builtin' => false);
            $postTypes = get_post_types($args, 'object', 'and');

            foreach ($postTypes as $key => $value) {
                if (in_array($key, array_keys($custom_post_types))) {
                    $arr_posts[] = $this->initPostTypeObject($value);
                }
                //$arr_posts[] = $this->initPostTypeObject($value);
            }
        }
        return $arr_posts;
    }

    function create(CustomPost $customPost)
    {
        $this->wwm_cpts = $this->getOption();
        $this->wwm_cpts[$customPost->getPostType()]=$customPost->toArray();
        return update_option($this->option_name,$this->wwm_cpts,false);
    }

    function update(CustomPost $customPost)
    {
        $this->wwm_cpts = $this->getOption();
        $this->wwm_cpts[$customPost->getPostType()]=$customPost->toArray();
        return update_option($this->option_name,$this->wwm_cpts,false);
    }

    function delete($customPostType)
    {
        $this->wwm_cpts = $this->getOption();
        unset($this->wwm_cpts[$customPostType]);
        return update_option($this->option_name,$this->wwm_cpts);
    }


    function isExists($slug)
    {
        $public = get_post_types( array( '_builtin' => false, 'public' => true ) );
        $private = get_post_types( array( '_builtin' => false, 'public' => false ) );
        $registered_post_types = array_merge( $public, $private );
        if ( in_array( $slug, $registered_post_types ) ) {
            return true;
        }
        return false;
    }


    function getCustomPostByName($customPostName)
    {

        /** @var WP_Post_Type $public */
        $public = get_post_types( array('post_type' => $customPostName ),'object' );

        if(!empty($public)) {
            return $this->initPostTypeObject($public[$customPostName]);
        }
        return null;
    }

    /**
     * @param string $customPostName
     * @return object
     */
    function getCapabilitiesByPostType($customPostName)
    {
        /** @var WP_Post_Type[] $public */
        $public = get_post_types( array('post_type' => $customPostName ),'object' );

        return $public[$customPostName]->cap;
    }


    /**
     * @param WP_Post_Type $args
     * @return CustomPost
     */
    private function initPostTypeObject($args)
    {


        $labels = new CustomPostLabels($args->labels->name);

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


        $postType = new CustomPost();


        $postType->setPostType($args->name);
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
        $postType->setSupports($this->getSupports($postType->getPostType()));

      return $postType;
    }

    function getSupports($post_name)
    {
        $supp = array();
        foreach($this->supports as $key=>$val)
        {
            if(post_type_supports($post_name,$val))
            {
                $supp[] = $val;
            }
        }
        return implode(',',$supp);
    }
}
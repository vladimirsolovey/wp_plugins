<?php
/**
  * Date: 08.02.17
 * Time: 16:43
 */

namespace wichita_webmasters_acpt\models;


use wichita_webmasters_acpt\domain\CustomPost;

interface ICustomPosts
{
    /**
     * @return CustomPost[]
     */
    function getAllCustomPostTypes();

    /**
     * @param CustomPost $customPost
     * @return bool
     */
    function create(CustomPost $customPost);

    /**
     * @param CustomPost $customPost
     * @return bool
     */
    function update(CustomPost $customPost);

    /**
     * @param $customPostType
     * @return bool
     */
    function delete($customPostType);

    /**
     * @param string $slug
     * @return bool
     */
    function isExists($slug);

    /**
     * @param string $customPostName
     * @return CustomPost
     */
    function getCustomPostByName($customPostName);

    /**
     * @param string $customPostName
     * @return object
     */
    function getCapabilitiesByPostType($customPostName);
}
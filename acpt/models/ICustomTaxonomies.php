<?php
/**
  * Date: 15.02.17
 * Time: 09:53
 */

namespace wichita_webmasters_acpt\models;


use wichita_webmasters_acpt\domain\CustomTaxonomy;

interface ICustomTaxonomies
{
    /**
     * @return CustomTaxonomy[]
     */
    function getAllTaxonomies();

    /**
     * @param CustomTaxonomy $customTaxonomy
     * @return bool
     */
    function create(CustomTaxonomy $customTaxonomy);

    /**
     * @param CustomTaxonomy $customTaxonomy
     * @return bool
     */
    function update(CustomTaxonomy $customTaxonomy);

    /**
     * @param $customTaxonomyName
     * @return bool
     */
    function delete($customTaxonomyName);

    /**
     * @param string $slug
     * @return bool
     */
    function isExists($slug);

    /**
     * @param string $customTaxonomyName
     * @return CustomTaxonomy
     */
    function getTaxonomyByName($customTaxonomyName);

}
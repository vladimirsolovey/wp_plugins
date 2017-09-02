<?php
/**
  * Date: 15.02.17
 * Time: 10:00
 */

namespace wichita_webmasters_acpt\domain;


class CustomTaxonomyRewrite
{
    /**
     * @var string
     */
    private $slug;
    /**
     * @var bool
     */
    private $with_front=true;

    /**
     * @var bool
     */
    private $hierarchical = false;

    /**
     * @var int
     */
    private $ep_mask = EP_NONE;

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * @return boolean
     */
    public function isWithFront()
    {
        return $this->with_front;
    }

    /**
     * @param boolean $with_front
     */
    public function setWithFront($with_front)
    {
        $this->with_front = $with_front;
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
        $this->hierarchical = $hierarchical;
    }

    /**
     * @return int
     */
    public function getEpMask()
    {
        return $this->ep_mask;
    }

    /**
     * @param int $ep_mask
     */
    public function setEpMask($ep_mask)
    {
        $this->ep_mask = $ep_mask;
    }




    function toArray()
    {
        return get_object_vars($this);
    }

    function initObject(array $options)
    {

        $this->slug = $options['slug'];
        $this->with_front = isset($options['with_front'])?(boolean)$options['with_front']:false;
        $this->hierarchical = isset($options['hierarchical'])?(boolean)$options['hierarchical']:false;
        $this->ep_mask = isset($options['ep_mask'])?intval($options['ep_mask']):EP_NONE;
    }
}
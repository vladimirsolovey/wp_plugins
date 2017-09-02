<?php
/**
  * Date: 08.02.17
 * Time: 14:59
 */

namespace wichita_webmasters_acpt\domain;


class CustomPostRewrite
{
    /**
     * @var
     */
    private $slug;
    /**
     * @var bool
     */
    private $with_front=true;
    /**
     * @var bool
     */
    private $feeds = true;
    /**
     * @var bool
     */
    private $pages = true;
    /**
     * @var bool
     */
    private $ep_mask = true;

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param mixed $slug
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
    public function isFeeds()
    {
        return $this->feeds;
    }

    /**
     * @param boolean $feeds
     */
    public function setFeeds($feeds)
    {
        $this->feeds = $feeds;
    }

    /**
     * @return boolean
     */
    public function isPages()
    {
        return $this->pages;
    }

    /**
     * @param boolean $pages
     */
    public function setPages($pages)
    {
        $this->pages = $pages;
    }

    /**
     * @return boolean
     */
    public function isEpMask()
    {
        return $this->ep_mask;
    }

    /**
     * @param boolean $ep_mask
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
        $this->feeds = isset($options['feeds'])?(boolean)$options['feeds']:false;
        $this->pages = isset($options['pages'])?(boolean)$options['pages']:false;
    }
}
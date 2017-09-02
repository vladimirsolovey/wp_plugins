<?php


namespace SoundCloud\classes\metabox;


use SoundCloud\classes\HF_SoundCloud_Service;

class HF_SoundCloud_MetaBox extends HF_SoundCloud_Service
{
    private static $instance;
    private $p;
    static function getInstance()
    {
        if(!self::$instance instanceof HF_SoundCloud_MetaBox)
        {
            self::$instance = new self();
        }
        return self::$instance;
    }

    function init()
    {
        add_meta_box("hf-sound-cloud-meta-box","Scheduler Configuration",array($this,"initSchedulerMetaBox"),'sound_cloud_import','normal','high');
    }

    function initSchedulerMetaBox()
    {
        global $post;
        $this->p = $post;
        echo $this->View('metabox/scheduler-init',array('obj'=>$this,'post_id'=>$post->ID));
    }

    function getFqDay()
    {
       $val = get_post_meta($this->p->ID,$this->settings['scheduler_meta_key'].'days',true);
        return $val?$val:null;
    }

    function getFq()
    {
        $val = get_post_meta($this->p->ID,$this->settings['scheduler_meta_key'].'frequency',true);
        return $val?$val:null;
    }

    function getFqHour()
    {
        $val =  get_post_meta($this->p->ID,$this->settings['scheduler_meta_key'].'hours',true);
        return $val?$val:null;
    }

    function getFqMonth()
    {
        $val = get_post_meta($this->p->ID,$this->settings['scheduler_meta_key'].'months',true);
        return $val?$val:null;
    }
    function getSoundCloudUserId()
    {
        $val = get_post_meta($this->p->ID,$this->settings['scheduler_meta_key'].'user-name',true);
        return $val?$val:null;
    }

    function getUsers()
    {
        $args = array('fields'=>array('id','display_name'),'role__in'=>array('administrator','editor','subscriber'));
        $users = get_users($args);

        return $users;
    }
}
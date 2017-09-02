<?php
/**
 * Date: 25.08.17
 * Time: 17:18
 */

namespace SoundCloud\classes\test;


use SoundCloud\api\SoundCloud;
use SoundCloud\classes\base\HF_SoundCloud_Base_Manager;
use SoundCloud\classes\HF_SoundCloud_Service;
use WP_Post;

class HF_SoundCloud_Test extends HF_SoundCloud_Service
{

   function __construct()
   {
       $this->api = SoundCloud::getInstance();
   }
    static function getInstance()
    {
        if(!self::$_instance instanceof HF_SoundCloud_Test)
        {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    function init()
    {

    }

    function getTracks($filters=false)
    {
        $args = array(
            'post_type'=>$this->import_post_type,
            'post_per_pages'=>-1
        );

        $posts = get_posts($args);
        /** @var WP_Post $p */
        $p = count($posts)==1?reset($posts):$posts[0];

        if($filters)
        $filters['created_at[from]']=$p->post_modified;

        return $this->api->getTracks(get_post_meta($p->ID,$this->settings['scheduler_meta_key']."user-id",true),$filters);
    }

    function saveTracks()
    {
        $meta_query=array(
            'key'=>$this->settings['scheduler_meta_key']."track-id",
            'value'=>'',
            'compare'=>'=',
            'type'=>'NUMERIC'
        );
        $args = array(
            'post_type'=>$this->default_main_post_type,
            'post_status'=>'publish',
            'numberposts'=>1,

        );
        $tracks = $this->getTracks();
        //var_dump($tracks);
        foreach($tracks as $track)
        {
            $meta_query['value']=$track->id;
            $args['meta_query']=$meta_query;
            var_dump($args);
            var_dump($track);
            $ps = get_posts($args);
            var_dump($ps);
            break;
        }
    }

    private function createPost($track)
    {

    }


}
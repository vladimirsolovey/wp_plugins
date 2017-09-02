<?php
/**
 * Date: 25.08.17
 * Time: 16:09
 */

namespace SoundCloud\classes\engine;


use SoundCloud\api\SoundCloud;
use SoundCloud\classes\cron\HF_SoundCloud_Cron;
use SoundCloud\classes\HF_SoundCloud_Service;
use WP_Post;

class HF_SoundCloud_Engine extends HF_SoundCloud_Service
{

    private $embed_options = array(
            'maxWidth'=>'100%',
            'maxHeight'=>'166'
    );
    /**
     * @var HF_SoundCloud_Cron
     */
    private $cron;
    private $embed_code = '<iframe src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/__TRACKID__&color=ff5500&auto_play=false&hide_related=false&show_comments=true&show_user=true&show_reposts=false" width="__WIDTH__" height="__HEIGHT__" frameborder="no" scrolling="no"></iframe>';


    private function __construct()
    {
        $this->api = SoundCloud::getInstance();
        $this->api->setClientId(get_option("hf_sound_cloud_settings",true)['client-id']);
    }

    static function getInstance()
    {
        if(!self::$_instance instanceof HF_SoundCloud_Engine)
        {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    function init()
    {
        // TODO: Implement init() method.
    }


    function setCron(HF_SoundCloud_Cron $cron)
    {
        $this->cron= $cron;
    }

    function runImport($p)
    {
        $filters = false;
        try {
            $this->updateSchedulerTimer($p);

            if (metadata_exists('post', $p->ID, $this->settings['scheduler_meta_key'] . "is-init")) {
                $filters['created_at[from]'] = $p->post_modified;
            }else
            {
                update_post_meta($p->ID, $this->settings['scheduler_meta_key'] . "is-init", true);
            }

            $tracks = $this->api->getTracks(get_post_meta($p->ID, $this->settings['scheduler_meta_key'] . "user-id", true), $filters);
            $this->saveTracks($tracks,$p);
            update_post_meta($p->ID, $this->settings['scheduler_meta_key'] . "status", "success");
        }catch(\Exception $ex)
        {
            update_post_meta($p->ID, $this->settings['scheduler_meta_key'] . "status", $ex->getMessage());
        }
    }

    function getTracks($filters=false)
    {
        $args = array(
            'post_type'=>$this->import_post_type,
            'post_per_pages'=>-1,
            'post_status'=>'publish'
        );


        $posts = get_posts($args);

        if($posts) {
            /** @var WP_Post $p */
            foreach($posts as $p) {
                    if ($this->isTimeOut($p)) {
                        $this->runImport($p);
                    }
            }

        }
    }

    function saveTracks($tracks,$post)
    {
        $result_qty = 0;

        if($tracks!=null) {

            foreach ($tracks as $track) {
                if (!$this->isTrackExists($track->id)) {
                    $this->createPost($track);
                    $result_qty++;
                }
            }
            $total = get_post_meta($post->ID, $this->settings['scheduler_meta_key'] . "total", true);
            update_post_meta($post->ID, $this->settings['scheduler_meta_key'] . "total", ($total ? $total : 0) + $result_qty);
        }
        update_post_meta($post->ID,$this->settings['scheduler_meta_key']."last-import-new",$result_qty);
        return $result_qty;
    }

    private function isTrackExists($id)
    {

        $meta_query=array(
            'key'=>$this->settings['scheduler_meta_key']."track-id",
            'value'=>$id,
            'compare'=>'=',
            'type'=>'NUMERIC'
        );
        $args = array(
            'post_type'=>$this->default_main_post_type,
            'post_status'=>'publish',
            'numberposts'=>1,
            'meta_query'=>array($meta_query)
        );
        $posts = get_posts($args);

        return count($posts)==1?true:false;
    }


    /**
     * @param $track
     * @param WP_Post $post_scheduler
     * @return int|\WP_Error
     * @throws \Exception
     */
    private function createPost($track,$post_scheduler=null)
    {
        $embed_code = preg_replace("/__TRACKID__/",$track->id,$this->embed_code);
        $embed_code = preg_replace("/__WIDTH__/",$this->embed_options['maxWidth'],$embed_code);
        $embed_code = preg_replace("/__HEIGHT__/",$this->embed_options['maxHeight'],$embed_code);
        $args = array(

            'post_author' => $post_scheduler?get_post_meta($post_scheduler->ID,$this->settings['scheduler_meta_key'].'author'):get_current_user_id(),
            'post_date' => $track->created_at,
            'post_date_gmt' => $track->created_at,
            'post_excerpt' => $track->description,
            'post_name' => $this->createPostSlug($track->title),
            'post_content'=> $track->description,
            'post_title' => $track->title,
            'post_status' =>'publish',
            'post_type' =>$this->default_main_post_type,
            'meta_input' => array(
                    $this->settings['scheduler_meta_key'].'track-id'=>$track->id,
                    'embed_code'=>$embed_code,
                    $this->settings['scheduler_meta_key'].'frame-max-width'=>$this->embed_options['maxWidth'],
                    $this->settings['scheduler_meta_key'].'frame-max-height'=>$this->embed_options['maxHeight'],
            )

        );

        $post_ID = wp_insert_post($args);

        if(!is_wp_error($post_ID))
        {

         return $post_ID;
        }
        else
        {
            throw new \Exception($post_ID->get_error_message());
        }
    }
    private  function createPostSlug($title)
    {
        $title = strtolower($title);
        $title = preg_replace('/\,\./','',$title);
        $title = preg_replace('/(\-){2,}/','$1',$title);
        $title = preg_replace('/(\s){2,}/','$1',$title);
        $title = preg_replace('/^s+|\s+$/','',$title);
        $title = preg_replace('/\s+/','-',$title);
        return $title;

    }

    private function isTimeOut($post)
    {
        $frequency = $this->cron->getFrequency(array('id'=>$post->post_content));
        $post_modified  = strtotime($post->post_modified);
        $today = current_time('timestamp');
        $t_hour = date("H",$today);
        $t_min = date("i",$today);
        $t_sec = date("s",$today);
        $t_day = date("j",$today);
        $t_week_day = date("w",$today);


        $hour = date("H",$post_modified);
        $min = date("i",$post_modified);
        $sec = date("s",$post_modified);
        $day = date("j",$post_modified);
        $week_day = date("w",$post_modified);

        switch($frequency->id)
        {
            case 'daily':
                    if($t_hour>=$hour && $t_min>=$min && $t_sec>=$sec)
                    {
                        return true;
                    }
                break;
            case 'weekly':
                if($t_week_day>=$week_day && $t_hour>=$hour && $t_min>=$min && $t_sec>=$sec)
                {
                    return true;
                }
                break;
            case 'monthly':
                if($t_day>=$day && $t_hour>=$hour && $t_min>=$min && $t_sec>=$sec)
                {
                    return true;
                }
                break;
            default:
                $current_interval = $post_modified+$frequency->interval;

                if($current_interval<$today)
                {
                    return true;
                }
                break;
        }


        return false;

    }
    function updateSchedulerTimer($post)
    {
        $args = array("ID"=>$post->ID,"post_modified"=>date("Y-m-d H:i:s",current_time('timestamp')),"post_modified_gmt"=>date("Y-m-d H:i:s",current_time('timestamp')));
        $post_ID = wp_update_post($args);
        if(!is_wp_error($post_ID))
        {

            return $post_ID;
        }
        else
        {
            throw new \Exception($post_ID->get_error_message());
        }
    }
}
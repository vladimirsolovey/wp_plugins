<?php
/**
 * Date: 25.08.17
 * Time: 11:51
 */

namespace SoundCloud\classes\cron;


use SoundCloud\classes\engine\HF_SoundCloud_Engine;

class HF_SoundCloud_Cron
{
    private static $instance;
    private static $action = 'hf_sc_scheduler_cron';
    private $is_running = false;

    public static function getInstance()
    {
        if(!self::$instance instanceof HF_SoundCloud_Cron)
        {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * @return string
     */
    public static function getAction()
    {
        return self::$action;
    }


    private function __construct()
    {
        add_action( 'init', array( $this, 'registerCron' ) );

        add_filter( 'cron_schedules', array( $this, 'filterCronSchedules' ) );

        add_action( self::$action, array( $this, 'run' ) );

        // Add the Actual Process to run on the Action
        add_action( 'hf_sc_scheduler_cron_run', array( $this, 'fetchTracks' ), 15 );

    }
    function filterCronSchedules(array $schedules)
    {
        $schedules['hf-sc-every15minutes'] = array(
            'interval' => MINUTE_IN_SECONDS * 15,
            'display'  => 'Every 15 minutes',
        );

        return (array) $schedules;
    }
    function getFrequency($search=array())
    {
        $search = wp_parse_args($search,array());

        $found=$schedulers = array(
            (object) array(
                'id'=>'every30minutes',
                'interval'=>MINUTE_IN_SECONDS * 30,
                'text'=>'Every 30 Minutes'
            ),
            (object) array(
                'id'=>'every3hours',
                'interval'=>HOUR_IN_SECONDS * 3,
                'text'=>'Every 3 Hours'
            ),
            (object) array(
                'id'=>'daily',
                'interval'=>DAY_IN_SECONDS,
                'text'=>'Daily'
            ),
            (object) array(
                'id'=>'weekly',
                'interval'=>WEEK_IN_SECONDS,
                'text'=>'Weekly'
            ),
            (object) array(
                'id'=>'monthly',
                'interval'=>MONTH_IN_SECONDS,
                'text'=>'Monthly'
            ),
        );

        if(!empty($search))
        {
            $found = array();
            foreach($schedulers as $i=>$schedule)
            {
                $intersect = array_intersect_assoc($search,(array)($schedule));
                if(!empty($intersect))
                {
                    $found[] = $schedule;
                }
            }
        }
        return count($found)===1?reset($found):$found;
    }

    function registerCron()
    {
        if ( wp_next_scheduled( self::$action ) ) {
            return;
        }

        // Fetch the initial Date and Hour
        $date = date( 'Y-m-d H' );

        // Based on the Minutes construct a Cron
        $minutes = (int) date( 'i' );
        if ( $minutes < 15 ) {
            $date .= ':00';
        } elseif ( $minutes >= 15 && $minutes < 30 ) {
            $date .= ':15';
        }elseif ( $minutes >= 30 && $minutes < 45 ) {
            $date .= ':30';
        } else {
            $date .= ':45';
        }
        $date .= ':00';

        // Fetch the last half hour as a timestamp
        $start_timestamp = strtotime( $date );

        // Now add an action twice hourly
        wp_schedule_event( $start_timestamp, 'hf-sc-every15minutes', self::$action );
    }

    function run()
    {
        $this->is_running = true;
        do_action( 'hf_sc_scheduler_cron_run' );
        $this->is_running = false;
    }

    function fetchTracks()
    {
        $engine = HF_SoundCloud_Engine::getInstance();
       $engine->setCron($this);
        $engine->getTracks();
    }
}
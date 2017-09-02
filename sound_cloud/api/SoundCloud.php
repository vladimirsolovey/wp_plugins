<?php


namespace SoundCloud\api;


class SoundCloud extends APIService implements ISoundCloud{

    private static $instance;


    /**
     * @return self
     */
    public static function getInstance()
    {
        if(!self::$instance instanceof SoundCloud)
        {
            self::$instance = new self();
        }
        return self::$instance;
    }


    function getUserId($userName)
    {

            $this->url .= $this->endpoints['resolve'] . $userName . '&' . $this->getClientId();

            $this->request();
            $res = json_decode($this->result);

            return $res->id;

    }

    function getTracks($userId,$filters=array())
    {

        $filters = $filters?http_build_query($filters):'';

        $this->url .= $this->endpoints['users'].$userId."/tracks?".$this->getClientId().'&'.$filters;

        $this->request();

        if($this->result==null)
            return null;

        $res = json_decode($this->result);
        return $res;
    }




}
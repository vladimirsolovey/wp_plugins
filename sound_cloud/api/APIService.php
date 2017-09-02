<?php


namespace SoundCloud\api;


abstract class APIService {

    protected $url = 'http://api.soundcloud.com';
    protected $post_data;
    protected $endpoints = array(
        'resolve'=>'/resolve?url=http://soundcloud.com/',
        'users'=>'/users/'
    );
    private $client_id = null;//'dfabf391f96e745af41faa9512934f2b';
    protected $result = null;

    protected function request()
    {
        if(isset($this->client_id) && !empty($this->client_id)) {
            try {
                $ch = curl_init($this->url);
                if (FALSE === $ch)
                    throw new \Exception('Failed to initialize');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($ch, CURLOPT_HEADER, 0);
                if ($this->post_data) {
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $this->post_data);
                }
                $this->result = curl_exec($ch);
                if (FALSE === $this->result)
                    throw new \Exception(curl_error($ch), curl_errno($ch));
                $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                if (200 != $http_status)
                    throw new \Exception($this->result, $http_status);
                curl_close($ch);
            } catch (\Exception $e) {
                throw new \Exception(sprintf(
                    'Curl failed with error #%d: %s',
                    $e->getCode(), $e->getMessage()),
                    E_USER_ERROR);
            }
        }
    }

    /**
     * @return null
     */
    public function getClientId()
    {
        return 'client_id='.$this->client_id;
    }

    /**
     * @param null $client_id
     */
    public function setClientId($client_id)
    {
        if($client_id)
        $this->client_id = $client_id;
    }


}
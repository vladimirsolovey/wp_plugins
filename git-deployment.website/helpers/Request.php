<?php


namespace wp_git_deploy_service\helpers;


class Request
{
    /**
     * @var array
     */
    private $request = array();

    /**
     * @param array $method
     */
    function __construct($method)
    {
        $this->request = $method;
    }

    /**
     * @param string $elementNam
     *
     * @return string|array
     */
    function get($elementNam)
    {
        if(!empty($this->request)) {

            if(!isset($this->request[ $elementNam ]))
            {
                return '';
            }
            if(!is_array($this->request[$elementNam]))
            {
                $str = esc_html( $this->request[ $elementNam ] );
            }


            if ( empty( $str ) ) {
                return '';
            }

            return $str;
        }
        else
            return '';

    }
}
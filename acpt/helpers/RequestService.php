<?php

/**
  * Date: 08.02.17
 * Time: 14:10
 */
namespace wichita_webmasters_acpt\helpers;
class RequestService
{

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
            else {
                $str = $this->request[$elementNam];
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
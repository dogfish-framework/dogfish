<?php

namespace DogfishCore\http;

class Input{

    private static $_input = null;

    /**
     * @param $name
     * @param null $default
     * @return null
     */
    public function __construct()
    {

    }

    public static function get($name, $default = null)
    {
        $value = Input::input();
        return isset($value[$name]) ? $value[$name] : $default;
    }

    private static function input(){
        if(Input::$_input === null)
        {
            $requestBody = file_get_contents("php://input");

            $requestQueryString = $_SERVER['QUERY_STRING'];
            $return = [];

            if(Request::isGetMethod())
            {
                parse_str($requestQueryString, $return);
            }
            else{

                $contentType = '';
                foreach (getallheaders() as $name => $value){
                    if($name === 'Content-Type')
                    {
                        $contentType = $value;
                    }
                }

                if(strtolower($contentType) === 'application/json')
                {
                    $return = json_decode($requestBody, true);

                    if(!is_array($return))
                    {
                        $return = [];
                    }
                }
                else if(strtolower($contentType) === 'application/x-www-form-urlencoded')
                {
                    parse_str($requestBody, $return);
                }
            }

            Input::$_input = $return;

            return $return;
        }
        else
        {
            return Input::$_input;
        }
    }
}
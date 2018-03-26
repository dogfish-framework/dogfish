<?php
function baseUrl()
{
    // output: /myproject/index.php
    $currentPath = $_SERVER['PHP_SELF'];


    // output: Array ( [dirname] => /myproject [basename] => index.php [extension] => php [filename] => index )
    $pathInfo = pathinfo($currentPath);

    // output: localhost
    $hostName = $_SERVER['HTTP_HOST'];


    // output: http://
    $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https://'?'https://':'http://';

    // return: http://localhost/myproject/
    return $protocol.$hostName.$pathInfo['dirname'];
}


function config($key)
{
    $config = require_once '../config.php';
    return $config[$key];
}

function url($url)
{
    return baseUrl().$url;
}
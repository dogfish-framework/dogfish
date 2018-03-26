<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 10/27/17
 * Time: 1:49 PM
 */

namespace DogfishCore;


class Autoloader
{
    public static function autoload($classname)
    {
       $classname = str_replace('\\','/',$classname);
       require_once $classname.'.php';
       //die($classname);
    }


    public static function register()
    {
        spl_autoload_register(array(__CLASS__,'autoload'));
    }
}
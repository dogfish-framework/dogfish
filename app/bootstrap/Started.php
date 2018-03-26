<?php
/**
 * Created by PhpStorm.
 * User: macintosh
 * Date: 21/03/2018
 * Time: 21:41
 */

namespace App\bootstrap;
require_once '../core/helpers.php';
require_once '../vendor/autoload.php';

use DogfishCore\DB;
use DogfishCore\routes\Routing;
use DogfishCore\View;

class Started
{
    public static  $config ;
    public function __construct()
    {
       self::$config = require_once '../config.php';
        new DB(self::$config['database']);
        Routing::getInstance()->setOption(self::$config['controller']);
        View::$myViewPath = self::$config["view"]["pathview"];
        View::$myCachePath = self::$config["view"]["pathcache"];
    }
}

new \App\bootstrap\Started();

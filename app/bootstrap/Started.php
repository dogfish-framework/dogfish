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
require_once '../app/routes/route.php';

use DogfishCore\DB;
use DogfishCore\routes\Routing;
use DogfishCore\View;
use DogfishCore\routes\Routing as Route;

class Started
{
    public function __construct()
    {
        new DB(config('database'));
        Routing::getInstance()->setOption(config('controller'));
        View::$myViewPath = config("view")["pathview"];
        View::$myCachePath = config("view")["pathcache"];
        if(config('debug')){
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);
        }
        Route::run();
        //die('ok');
    }
}

new \App\bootstrap\Started();

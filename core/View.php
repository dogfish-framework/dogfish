<?php
/**
 * Created by PhpStorm.
 * User: macintosh
 * Date: 21/03/2018
 * Time: 21:18
 */

namespace DogfishCore;


use Jenssegers\Blade\Blade;

class View extends Blade
{
    public static $myViewPath ;
    public static $myCachePath ;
    public function __construct()
    {
        parent::__construct(self::$myViewPath, self::$myCachePath);
    }
}
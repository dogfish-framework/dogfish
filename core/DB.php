<?php
/**
 * Created by PhpStorm.
 * User: macintosh
 * Date: 21/03/2018
 * Time: 23:55
 */

namespace DogfishCore;
use Illuminate\Database\Capsule\Manager as Capsule;

class DB extends Capsule
{

    public function __construct(array $paramsConnexion )
    {
        parent::__construct();
        $this->addConnection($paramsConnexion,"default");
        $this->setAsGlobal();
        $this->bootEloquent();
    }


}
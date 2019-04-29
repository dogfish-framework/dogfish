<?php
return $config =  [

    //////////////CONFIGURATION DE LA BASSE DE DONNEE////////////
        "database" =>[
            'driver'    => 'mysql',
            'host'      => 'localhost',
            'database'  => 'dogfish',
            'username'  => 'root',
            'password'  => 'root',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => ''
        ],
    ///////////////CONFIGURATION VUES /////////////////////////
        "view" => [
            "pathview" => "../app/view/",
            "pathcache" => "../core/cache/",
        ],
    ///////////////CONFIGURATION CONTROLLER AND MIDDLEWARE/////////////////////////
        "controller" => [
            "controllerNamespace" => "\\App\\controller",
            "middlewareNamespace" => "\\App\\middleware",
        ],

    ///////////////CONFIGURATION VUES /////////////////////////
       "debug" => true
];



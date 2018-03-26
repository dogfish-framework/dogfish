<?php
/**
 * Created by PhpStorm.
 * User: macintosh
 * Date: 25/03/2018
 * Time: 19:59
 */

namespace App\controller;


use DogfishCore\Controller;
use Jenssegers\Blade\Blade;

class HomeController extends Controller
{
    public function index()
    {

        return $this->render('home');
    }
}
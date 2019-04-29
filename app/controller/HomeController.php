<?php
/**
 * Created by PhpStorm.
 * User: macintosh
 * Date: 25/03/2018
 * Time: 19:59
 */

namespace App\controller;


use App\model\User;
use DogfishCore\Controller;
use DogfishCore\http\Response;
use Jenssegers\Blade\Blade;

class HomeController extends Controller
{
    public function index()
    {
        $users = User::all();
        Response::withStatus(200);
      return  Response::withJson($users);
      //  return $this->render('home',compact('users'));
    }
}
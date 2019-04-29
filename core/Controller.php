<?php
/**
 * Created by PhpStorm.
 * User: macintosh
 * Date: 21/03/2018
 * Time: 21:12
 */

namespace DogfishCore;
use DogfishCore\http\Input;
use DogfishCore\http\Request;
use DogfishCore\http\Response;

class Controller
{
    protected $input ;
    protected $request;
    protected $response;
    private $view ;


    public function __construct()
    {
        $this->view  = new View();
        $this->input = new Input();
        $this->request = new Request();
        $this->response = new Response();
    }

    protected function render($viewpage,$data =array())
    {
       return $this->view->render($viewpage,$data);
    }

    public function redirect($page = '/')
    {

        header("Location: $page");
        exit;
    }
}
